<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ToyController extends Controller
{
    public function index()
    {
        $datas = DB::select('select * from toy where deleted is null');
        return view('dashboard.toy.index')
            ->with('datas', $datas);
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('toy')->where('deleted', NULL)->where('toy_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.toy.index')
            ->with('datas', $datas);
    }
    public function create()
    {
        return view('dashboard.toy.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'toy_id' => 'required',
            'toy_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::insert(
            'INSERT INTO toy (toy_id, toy_name, price, stock) VALUES (:toy_id, :toy_name, :price, :stock)',
            [
                'toy_id' => $request->toy_id,
                'toy_name' => $request->toy_name,
                'price' => $request->price,
                'stock' => $request->stock,
            ]
        );

        return redirect()->route('toy.index')->with('success', 'Data toy berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DB::table('toy')->where('toy_id', $id)->first();

        return view('dashboard.toy.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'toy_id' => 'required',
            'toy_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::table('toy')->where('toy_id', $request->id)->update([
            'toy_id' => $request->toy_id,
            'toy_name' => $request->toy_name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('toy.index')->with('success', 'Data toy berhasil diubah');
    }

    public function delete($id)
    {
        DB::delete('DELETE FROM toy WHERE toy_id = :toy_id', ['toy_id' => $id]);

        return redirect()->route('toy.softindex')->with('success', 'Data toy berhasil dihapus');
    }
    public function softdelete($id)
    {
        DB::update('UPDATE toy SET deleted = current_timestamp() WHERE toy_id = :toy_id', ['toy_id' => $id]);

        return redirect()->route('toy.index')->with('success', 'Data toy berhasil dihapus');
    }
    public function search_trash(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('toy')->where('deleted', '<>', '')->where('toy_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.toy.soft')
            ->with('datas', $datas);
    }
    public function restore($id)
    {
        DB::update('UPDATE toy SET deleted=null WHERE toy_id = :toy_id', ['toy_id' => $id]);
        return redirect()->route('toy.index')->with('success', 'Data toy berhasil dipulihkan');
    }
    public function softindex()
    {
        $datas = DB::select('select * from toy where deleted is not null');
        return view('dashboard.toy.soft')
            ->with('datas', $datas);
    }
}
