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

        <h5 class="card-title fw-bolder mb-3 text-center h2">Add Data Customer</h5>

        <form method="post" action="{{ route('customer.store') }}">
            @csrf
            <div class="mb-3">
                <label for="customer_id" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id">
            </div>
            <div class="mb-3">
                <label for="customer_name" class="form-label">Nama Customer</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary" value="Add" />
            </div>
        </form>
    </div>
</div>

@stop