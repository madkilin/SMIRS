@extends('layouts.app')

@section('content')
<style>
    .dropdown-menu {
        min-width: 300px;  /* Adjust this value as needed */
    }
</style>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Riwayat Pengecekan Seluruh Ruangan</h4>
                <div class="buttons">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button"
                        id="dropdownMenuButtonForFilter" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    Filter
                </button>
                <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonForFilter">
                    <form method="GET" action="{{ route('admin.reports.item_checks') }}">
                        <div class="mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="bagus" {{ request('status') == 'bagus' ? 'selected' : '' }}>Bagus</option>
                                <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="mb-2">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </form>
                </div>
                        <button class="btn btn-primary dropdown-toggle" type="button"
                                id="dropdownMenuButtonForExport" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonForExport">
                            <a class="dropdown-item" href="{{ route('admin.export.pdf') }}">PDF</a>
                            <a class="dropdown-item" href="{{ route('admin.export.excel') }}">Excel</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Kuantitas</th>
                            <th>Ruangan</th>
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
                                <td>{{ $check->inventory->category }}</td>
                                <td>{{ $check->quantity }}</td>
                                <td>{{ $check->location->name ?? '-' }}</td>
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
