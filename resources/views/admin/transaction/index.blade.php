@extends('admin.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                Data Transaksi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Kasir</th>
                                <th>Nama Produk</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $data)
                                <tr>
                                    <td>{{ $data->user->name }}</td>
                                    <td>{{ $data->obat->nama_obat }}</td>
                                    <td>{{ number_format($data->total_price) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <br>
                {{ $datas->links() }}
            </div>
        </div>
    </div>
@endsection
