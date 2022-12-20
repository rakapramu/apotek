@extends('admin.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <h5 class="card-header">Edit Data Obat</h5>
                <div class="card-body">
                    <form action="{{ route('obat.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" name="nama_obat" placeholder="Nama Obat"
                                value="{{ $data->nama_obat }}">
                            @error('nama_obat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" placeholder="Harga" class="form-control"
                                value="{{ $data->harga }}">
                            @error('harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
