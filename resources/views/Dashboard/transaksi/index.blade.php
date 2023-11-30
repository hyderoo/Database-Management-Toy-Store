@extends('dashboard.layout')

@section('content')

@if($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="mt-5 text-center h1 fw-bolder">Data Transaksi</h4>

        <div class="container d-flex mb-3">
            <a href="{{ route('transaksi.create') }}" type="button" class="btn btn-success rounded-3 me-auto">Add Data</a>
            <form class="d-flex" role="search" method="GET" action="{{ route('transaksi.search') }}">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="container mb-3">
            <a href="{{ route('transaksi.softindex') }}" type="button" class="btn btn-warning rounded-3">Trash</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover mt-2 table-bordered boder-primary rounded text-center shadow p-3 mb-5 rounded">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Customer</th>
                    <th>Nama Toy</th>
                    <th>Total</th>
                    <th>Nama Supplier</th>
                    <th>Tanggal Transaksi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->transaksi_id }}</td>
                    <td>{{ $data->customer_name }}</td>
                    <td>{{ $data->toy_name }}</td>
                    <td>{{ $data->total }}</td>
                    <td>{{ $data->supplier_name }}</td>
                    <td>{{ $data->transaksi_date }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', $data->transaksi_id) }}" type="button" class="btn btn-outline-warning rounded-3">Edit</a>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $data->transaksi_id }}">
                            Delete
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $data->transaksi_id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('transaksi.softdelete', $data->transaksi_id) }}">
                                        @csrf
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
