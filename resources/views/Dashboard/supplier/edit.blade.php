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

        <h5 class="card-title fw-bolder mb-3 h2 text-center">Edit Data Supplier</h5>

        <form method="post" action="{{ route('supplier.update', $data->supplier_id) }}">
            @csrf
            <div class="mb-3">
                <label for="supplier_id" class="form-label">ID Supplier</label>
                <input type="text" class="form-control" id="supplier_id" name="supplier_id" value="{{ $data->supplier_id }}">
            </div>
            <div class="mb-3">
                <label for="supplier_name" class="form-label">Nama Supplier</label>
                <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="{{ $data->supplier_name }}">
            </div>
            <div class="mb-3">
                <label for="contact_info" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" value="{{ $data->contact_info}}">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $data->alamat }}">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Edit" />
            </div>
        </form>
    </div>
</div>

@stop