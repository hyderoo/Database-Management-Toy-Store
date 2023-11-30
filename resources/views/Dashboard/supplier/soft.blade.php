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
        <h4 class="mt-5 text-center h1 fw-bolder">Data Supplier Terhapus</h4>

        <div class="container d-flex mb-3">
            <form class="d-flex" role="search" method="GET" action="{{ route('supplier.search_trash') }}">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover mt-2 table-bordered boder-primary rounded text-center shadow p-3 mb-5 rounded">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Contact</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->supplier_id }}</td>
                    <td>{{ $data->supplier_name }}</td>
                    <td>{{ $data->contact_info }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>
                        <a href="{{ route('supplier.restore', $data->supplier_id) }}" type="button" class="btn btn-outline-warning rounded-3">Restore</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $data->supplier_id }}">
                            Hapus
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $data->supplier_id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('supplier.delete', $data->supplier_id) }}">
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