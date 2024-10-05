@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>SMIRS Medina</h3>
                    <p class="text-subtitle text-muted">
                        Sistem Manajemen Inventaris Rumah Sakit Medina
                    </p>
                    
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Monitoring Inventaris</li>
                            <li class="breadcrumb-item active" aria-current="page">Cek Inventaris</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Cek Inventaris Ruangan {{ $location->name }}</h4>
                            <p class="text-subtitle text-muted">
                                Cek Inventaris sesuai dengan keadaan dan pastikan data yang dicek sudah benar.
                            </p>
                            <div class="text-end">
                                <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
            </div>
            <div class="card-body">
                <form action="{{ route('item_checks.store', $location->id) }}" method="POST">
                    @csrf
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Inventaris</th>
                                <th>Kategori</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Pemasok</th>
                                <th>Kuantitas</th>
                                <th>Kondisi</th>
                                <th>keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $item->supplier->name }}</td>
                                    <td>{{ $item->pivot->quantity }} {{ $item->unit->name }}</td>
                                    <td>
                                        <select name="inventories[{{ $item->id }}][status]" class="form-control">
                                            <option value="bagus">Bagus</option>
                                            <option value="hilang">Hilang</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="butuh_perbaikan">Butuh Perbaikan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="inventories[{{ $item->id }}][description]" id="description" cols="30" rows="2" placeholder="Deskripsi..."></textarea>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
