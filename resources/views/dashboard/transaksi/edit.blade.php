@extends('dashboard.layout')

@section('content')

@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif

<div class="card mt-4 bg-light text-black shadow p-3 mb-5 rounded">
    <div class="card-body">

        <h5 class="card-title fw-bolder mb-3 h2 text-center">Edit Data Transaksi</h5>

        <form method="post" action="{{ route('transaksi.update', $data->transaksi_id) }}">
            @csrf
            <div class="mb-3">
                <label for="customer_id" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ $data->customer_id }}">
            </div>
            <div class="mb-3">
                <label for="toy_id" class="form-label">ID Toy</label>
                <input type="text" class="form-control" id="toy_id" name="toy_id" value="{{ $data->toy_id }}">
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="text" class="form-control" id="total" name="total" value="{{ $data->total }}">
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">ID Supplier</label>
                <input type="text" class="form-control" id="supplier_id" name="supplier_id" value="{{ $data->supplier_id }}">
            </div>
            <div class="mb-3">
                <label for="transaksi_date" class="form-label">Tanggal Transaksi</label>
                <input type="text" class="form-control" id="transaksi_date" name="transaksi_date" value="{{ $data->transaksi_date }}">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Edit" />
            </div>
        </form>
    </div>
</div>

@stop
