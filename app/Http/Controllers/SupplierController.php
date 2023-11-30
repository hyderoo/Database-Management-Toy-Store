<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SupplierController extends Controller
{
    public function index()
    {
        $datas = DB::select('select * from supplier where deleted is null');
        return view('dashboard.supplier.index')
            ->with('datas', $datas);
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('supplier')->where('deleted', NULL)->where('supplier_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.supplier.index')
            ->with('datas', $datas);
    }
    public function create()
    {
        return view('dashboard.supplier.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'supplier_name' => 'required',
            'contact_info' => 'required',
            'alamat' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::insert(
            'INSERT INTO supplier(supplier_id, supplier_name, contact_info, alamat) VALUES (:supplier_id, :supplier_name, :contact_info, :alamat)',
            [
                'supplier_id' => $request->supplier_id,
                'supplier_name' => $request->supplier_name,
                'contact_info' => $request->contact_info,
                'alamat' => $request->alamat,
            ]
        );

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DB::table('supplier')->where('supplier_id', $id)->first();

        return view('dashboard.supplier.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'supplier_name' => 'required',
            'contact_info' => 'required',
            'alamat' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::table('supplier')->where('supplier_id', $request->id)->update([
            'supplier_id' => $request->supplier_id,
            'supplier_name' => $request->supplier_name,
            'contact_info' => $request->contact_info,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diubah');
    }

    public function delete($id)
    {
        DB::delete('DELETE FROM supplier WHERE supplier_id = :supplier_id', ['supplier_id' => $id]);

        return redirect()->route('supplier.softindex')->with('success', 'Data supplier berhasil dihapus');
    }
    public function softdelete($id)
    {
        DB::update('UPDATE supplier SET deleted = current_timestamp() WHERE supplier_id = :supplier_id', ['supplier_id' => $id]);

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil dihapus');
    }
    public function search_trash(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('supplier')->where('deleted', '<>', '')->where('supplier_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.supplier.soft')
            ->with('datas', $datas);
    }
    public function restore($id)
    {
        DB::update('UPDATE supplier SET deleted=null WHERE supplier_id = :supplier_id', ['supplier_id' => $id]);
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil dipulihkan');
    }
    public function softindex()
    {
        $datas = DB::select('select * from supplier where deleted is not null');
        return view('dashboard.supplier.soft')
            ->with('datas', $datas);
    }
}