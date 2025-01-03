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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Cek Inventaris Ruangan {{ $location->name }}</h4>
                <div class="buttons">
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form id="ItemCheckForm" action="{{ route('item_checks.store', $location) }}" method="POST">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Alokasi</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locationItems as $locationItem)
                                <tr>
                                    <td>{{ $locationItem->id }}</td>
                                    <td>{{ $locationItem->inventory->name }}</td>
                                    <td>{{ $locationItem->inventory->category }}</td>
                                    <td>{{ $locationItem->inventory->quantity }}</td>
                                    <td>
                                        <select name="location_items[{{ $locationItem->id }}][status]" class="form-control">
                                            <option value="bagus">Bagus</option>
                                            <option value="hilang">Hilang</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="perbaikan">Perbaikan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="location_items[{{ $locationItem->id }}][description]" class="form-control"></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" id="saveButton" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        document.getElementById('saveButton').addEventListener('click', function(e) {
            // Prevent default form submission
            e.preventDefault();

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah Anda yakin ingin menyimpan data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('ItemCheckForm').submit();
                }
            });
        });
    </script>
@endsection
