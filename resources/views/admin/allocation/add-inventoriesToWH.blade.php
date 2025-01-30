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
                            <li class="breadcrumb-item active" aria-current="page">Alokasi Inventaris</li>
                            <li class="breadcrumb-item active" aria-current="page">Alokasi Gudang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Alokasi Gudang - {{ $location->name }}</h4>
                    <div class="buttons">
                        <a href="{{ route('admin.alokasi.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-subtitle text-muted">Alokasikan Inventaris/barang yang sesuai ke gudang.</p>
                    <form id="allocationToWHForm" action="{{ route('admin.location.returnToWarehouse', $location->id) }}"
                        method="POST">
                        @csrf
                        @method('POST') <!-- If you are updating, use POST -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Alokasi</th>
                                    <th>Nama Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locationItems as $locationItem)
                                    <tr>
                                        <td>{{ $locationItem->id }}</td>
                                        <td>{{ $locationItem->inventory->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <input type="checkbox" name="return_items[]"
                                                    value="{{ $locationItem->id }}">
                                                <label class="ms-2">Kembalikan Ke Gudang</label>
                                            </div>
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
    </div>
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
                    document.getElementById('allocationToWHForm').submit();
                }
            });
        });
    </script>
@endsection
