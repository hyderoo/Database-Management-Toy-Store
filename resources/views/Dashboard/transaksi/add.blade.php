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

        <h5 class="card-title fw-bolder mb-3 text-center h2">Add Data Transaksi</h5>

        <form method="post" action="{{ route('transaksi.store') }}">
            @csrf

                <div class="mb-3">
        <label for="customer_id" class="form-label">Customer ID</label>
        <select class="form-select" id="customer_id" name="customer_id">
            @foreach($customers as $customer)
                <option value="{{ $customer->customer_id }}">{{ $customer->customer_id }}</option>
            @endforeach
        </select>
    </div>


<div class="mb-3">
    <label for="toy_id" class="form-label">Toy ID</label>
    <select class="form-select" id="toy_id" name="toy_id">
        @foreach($toys as $toy)
            <option value="{{ $toy->toy_id }}">{{ $toy->toy_id }}</option>
        @endforeach
    </select>
</div>

            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="text" class="form-control" id="total" name="total">
            </div>
            <div class="mb-3">
    <label for="supplier_id" class="form-label">Supplier ID</label>
    <select class="form-select" id="supplier_id" name="supplier_id">
        @foreach($suppliers as $supplier)
            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_id }}</option>
        @endforeach
    </select>
</div>
            <div class="mb-3">
                <label for="transaksi_date" class="form-label">Transaksi Date</label>
                <input type="date" class="form-control" id="transaksi_date" name="transaksi_date">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary" value="Add" />
            </div>
        </form>
    </div>
</div>

@stop
