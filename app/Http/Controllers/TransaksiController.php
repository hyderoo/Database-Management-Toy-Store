<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $datas = DB::table('transaksi')
            ->leftJoin('customer', 'transaksi.customer_id', '=', 'customer.customer_id')
            ->leftJoin('toy', 'transaksi.toy_id', '=', 'toy.toy_id')
            ->leftJoin('supplier', 'transaksi.supplier_id', '=', 'supplier.supplier_id')
            ->select(
                'transaksi.transaksi_id',
                'customer.customer_name',
                'toy.toy_name',
                'transaksi.total',
                'supplier.supplier_name',
                'transaksi.transaksi_date'
            )
            ->whereNull('transaksi.deleted')
            ->get();

        return view('dashboard.transaksi.index')->with('datas', $datas);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $datas = DB::table('transaksi')
            ->leftJoin('customer', 'transaksi.customer_id', '=', 'customer.customer_id')
            ->leftJoin('toy', 'transaksi.toy_id', '=', 'toy.toy_id')
            ->leftJoin('supplier', 'transaksi.supplier_id', '=', 'supplier.supplier_id')
            ->select(
                'transaksi.transaksi_id',
                'customer.customer_name',
                'toy.toy_name',
                'transaksi.total',
                'supplier.supplier_name',
                'transaksi.transaksi_date'
            )
            ->whereNull('transaksi.deleted')
            ->where(function ($query) use ($keyword) {
                $query->where('customer.customer_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('toy.toy_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('supplier.supplier_name', 'LIKE', '%' . $keyword . '%');
            })
            ->get();

        return view('dashboard.transaksi.index')->with('datas', $datas);
    }

    public function create()
    {
        $toys = DB::table('toy')->select('toy_id')->get();
        $transaksiIds = DB::table('transaksi')->pluck('transaksi_id');
        $suppliers = DB::table('supplier')->select('supplier_id')->get();
        $customers = DB::table('customer')->select('customer_id')->get();
    
        return view('dashboard.transaksi.add', [
            'toys' => $toys,
            'transaksiIds' => $transaksiIds,
            'suppliers' => $suppliers,
            'customers' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_date' => 'required',
            'total' => 'required',
            'supplier_id' => 'required',
            'toy_id' => 'required',
            'customer_id' => 'required',
        ]);

        $transaksiId = DB::table('transaksi')->insertGetId([
            'transaksi_date' => $request->transaksi_date,
            'total' => $request->total,
            'supplier_id' => $request->supplier_id,
            'toy_id' => $request->toy_id,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DB::table('transaksi')
            ->where('transaksi.transaksi_id', $id)
            ->leftJoin('customer', 'transaksi.customer_id', '=', 'customer.customer_id')
            ->leftJoin('toy', 'transaksi.toy_id', '=', 'toy.toy_id')
            ->leftJoin('supplier', 'transaksi.supplier_id', '=', 'supplier.supplier_id')
            ->select(
                'transaksi.transaksi_id',
                'customer.customer_id',
                'customer.customer_name',
                'toy.toy_id',
                'toy.toy_name',
                'transaksi.total',
                'supplier.supplier_id',
                'supplier.supplier_name',
                'transaksi.transaksi_date'
            )
            ->first();

        return view('dashboard.transaksi.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'transaksi_date' => 'required',
            'total' => 'required',
            'supplier_id' => 'required',
            'toy_id' => 'required',
            'customer_id' => 'required',
        ]);

        DB::table('transaksi')->where('transaksi_id', $id)->update([
            'transaksi_date' => $request->transaksi_date,
            'total' => $request->total,
            'supplier_id' => $request->supplier_id,
            'toy_id' => $request->toy_id,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diubah');
    }

    public function delete($id)
    {
        DB::table('transaksi')->where('transaksi_id', $id)->delete();

        return redirect()->route('transaksi.softindex')->with('success', 'Data transaksi berhasil dihapus');
    }

    public function softdelete($id)
    {
        DB::table('transaksi')->where('transaksi_id', $id)->update(['deleted' => now()]);

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus');
    }

    public function search_trash(Request $request)
    {
        $keyword = $request->keyword;
        $datas = DB::table('transaksi')
            ->leftJoin('customer', 'transaksi.customer_id', '=', 'customer.customer_id')
            ->leftJoin('toy', 'transaksi.toy_id', '=', 'toy.toy_id')
            ->leftJoin('supplier', 'transaksi.supplier_id', '=', 'supplier.supplier_id')
            ->select(
                'transaksi.transaksi_id',
                'customer.customer_name',
                'toy.toy_name',
                'transaksi.total',
                'supplier.supplier_name',
                'transaksi.transaksi_date'
            )
            ->whereNotNull('transaksi.deleted')
            ->where('customer.customer_name', 'LIKE', '%' . $keyword . '%')
            ->get();

        return view('dashboard.transaksi.soft')->with('datas', $datas);
    }

    public function restore($id)
    {
        DB::table('transaksi')->where('transaksi_id', $id)->update(['deleted' => null]);

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dipulihkan');
    }

    public function softindex()
    {
        $datas = DB::table('transaksi')
            ->leftJoin('customer', 'transaksi.customer_id', '=', 'customer.customer_id')
            ->leftJoin('toy', 'transaksi.toy_id', '=', 'toy.toy_id')
            ->leftJoin('supplier', 'transaksi.supplier_id', '=', 'supplier.supplier_id')
            ->select(
                'transaksi.transaksi_id',
                'customer.customer_name',
                'toy.toy_name',
                'transaksi.total',
                'supplier.supplier_name',
                'transaksi.transaksi_date'
            )
            ->whereNotNull('transaksi.deleted')
            ->get();

        return view('dashboard.transaksi.soft')->with('datas', $datas);
    }
}
