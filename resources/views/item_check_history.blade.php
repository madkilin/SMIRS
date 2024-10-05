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
                            <li class="breadcrumb-item active" aria-current="page">Histori Inventaris</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>Riwayat Pengecekan Ruangan {{ $location->name }}</h4>
                <div class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('export.pdf', $location->id) }}">PDF</a>
                            <a class="dropdown-item" href="{{ route('export.excel', $location->id) }}">Excel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th>Dicek Oleh</th>
                            <th>Tanggal Pengecekan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemChecks as $check)
                            <tr>
                                <td>{{ $check->inventory->name }}</td>
                                <td>{{ ucfirst($check->status) }}</td>
                                <td>{{ $check->description }}</td>
                                <td>{{ $check->user->name }}</td>
                                <td>{{ $check->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
