@extends('admin.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <h5 class="card-header">Daftar Obat</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Obat</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($obats as $obat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td>Rp. {{ number_format($obat->harga) }}</td>
                                            <td>
                                                <form action="{{ route('obat.destroy', $obat->id) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-warning btn-sm">
                                                            <i class='bx bx-pencil'></i>
                                                        </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah anda yakin mau menghapus?')">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="4" class="text-center">Tidak Ada Data</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 order-0">
                <div class="card">
                    <h5 class="card-header">Tambah Data Obat</h5>
                    <div class="card-body">
                        <form action="{{ route('obat.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Obat</label>
                                <input type="text" class="form-control" name="nama_obat" placeholder="Nama Obat"
                                    value="{{ old('nama_obat') }}">
                                @error('nama_obat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" placeholder="Harga" class="form-control"
                                    value="{{ old('harga') }}">
                                @error('harga')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- tampil pesan --}}
        @if (Session::has('status'))
            <div class="alert alert-danger">
                <button class="close">
                    <span>&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
        @endif


        <div class="row">
            <div class="col-lg-5 mb-4 order-0">
                <div class="card">
                    <h1 class="card-header">Kasir Transaksi</h1>
                    <div class="card-body">
                        <form id="calcForm" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="">Nama Obat</label>
                                <select name="obat_id" id="obat_id" class="form-control" onkeyup="isiOtomatis()">
                                    <option value="0" disabled selected>-- Pilih Obat --</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id }}" id="obat_id">{{ $obat->nama_obat }} - Rp.
                                            {{ number_format($obat->harga) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="jumlah" type="text" placeholder="Angka 1"
                                    data-sb-validations="required" />
                                <label for="harga">Jumlah</label>
                                <div class="invalid-feedback" data-sb-feedback="harga:required">Jumlah Harus Di isi</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="harga" type="text" placeholder="Angka 1"
                                    data-sb-validations="required" />
                                <label for="harga">Harga</label>
                                <div class="invalid-feedback" data-sb-feedback="harga:required">Harga Harus Di isi</div>
                            </div>
                            {{-- <div class="form-floating mb-3">
                                <input class="form-control" name="bayar" type="text" placeholder="Angka 2"
                                    data-sb-validations="required" />
                                <label for="bayar">Bayar</label>
                                <div class="invalid-feedback" data-sb-feedback="bayar:required">Angka 2 is required.</div>
                            </div> --}}
                            <div class="form-floating mb-3">
                                <input class="form-control" name="hasil" type="text" placeholder=""
                                    data-sb-validations="" value="" disabled />
                                <label for="">Total</label>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg" value="tambah" name="btn"
                                    onclick="hitung('tambah')" type="button">Hitung</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Order --}}
            <div class="col-lg-7 mb-4 order-0">
                <div class="card">
                    <div class="card-header">
                        <h4>Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->obat->nama_obat }}</td>
                                            <td>{{ $order->obat->harga }}</td>
                                            <td>{{ $order->jumlah }}</td>
                                            <td>{{ $order->sub_total }}</td>
                                            <td>
                                                <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-blue">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak Ada Transaksi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <h4>Total : Rp. {{ number_format($orders->sum('sub_total')) }}</h4>
                        </div>
                        <form action="{{ route('save') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function hitung(tombol) {
            // tangkap id form
            var frm = document.getElementById('calcForm');
            var harga = parseFloat(frm.harga.value);
            var jumlah = parseFloat(frm.jumlah.value);

            switch (tombol) {
                case 'tambah':
                    if (isNaN(harga) || isNaN(jumlah)) {
                        alert('harap masukkan angka');
                    } else {
                        var total = harga * jumlah;
                        frm.hasil.value = total;
                    }
                    break;
            }
        }
    </script>
@endsection
