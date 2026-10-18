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

        <h5 class="card-title fw-bolder mb-3 text-center h2">Add Data Toy</h5>

        <form method="post" action="{{ route('toy.store') }}">
            @csrf
            <div class="mb-3">
                <label for="toy_id" class="form-label">ID Toy</label>
                <input type="text" class="form-control" id="toy_id" name="toy_id">
            </div>
            <div class="mb-3">
                <label for="toy_name" class="form-label">Nama Toy</label>
                <input type="text" class="form-control" id="toy_name" name="toy_name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary" value="Add" />
            </div>
        </form>
    </div>
</div>

@stop