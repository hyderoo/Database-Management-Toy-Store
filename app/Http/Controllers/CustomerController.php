<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $datas = DB::select('select * from customer where deleted is null');
        return view('dashboard.customer.index')
            ->with('datas', $datas);
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('customer')->where('deleted', NULL)->where('customer_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.customer.index')
            ->with('datas', $datas);
    }
    public function create()
    {
        return view('dashboard.customer.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'customer_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::insert(
            'INSERT INTO customer(customer_id, customer_name, email, phone) VALUES (:customer_id, :customer_name, :email, :phone)',
            [
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]
        );

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DB::table('customer')->where('customer_id', $id)->first();

        return view('dashboard.customer.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'customer_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::table('customer')->where('customer_id', $request->id)->update([
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil diubah');
    }

    public function delete($id)
    {
        DB::delete('DELETE FROM customer WHERE customer_id = :customer_id', ['customer_id' => $id]);

        return redirect()->route('customer.softindex')->with('success', 'Data customer berhasil dihapus');
    }
    public function softdelete($id)
    {
        DB::update('UPDATE customer SET deleted = current_timestamp() WHERE customer_id = :customer_id', ['customer_id' => $id]);

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil dihapus');
    }
    public function search_trash(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('customer')->where('deleted', '<>', '')->where('customer_name', 'LIKE', '%' . $keyword . '%')->get();
        return view('dashboard.customer.soft')
            ->with('datas', $datas);
    }
    public function restore($id)
    {
        DB::update('UPDATE customer SET deleted=null WHERE customer_id = :customer_id', ['customer_id' => $id]);
        return redirect()->route('customer.index')->with('success', 'Data customer berhasil dipulihkan');
    }
    public function softindex()
    {
        $datas = DB::select('select * from customer where deleted is not null');
        return view('dashboard.customer.soft')
            ->with('datas', $datas);
    }
}
