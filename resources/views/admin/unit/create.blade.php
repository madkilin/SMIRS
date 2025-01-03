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
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Inventaris</li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Unit</li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Unit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Unit</h4>
                        <p class="text-subtitle text-muted">
                            Tambahkan unit baru sesuai kebutuhan dan pastikan data yang dimasukkan sudah benar.
                        </p>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="createUnitForm" action="{{ route('admin.units.store') }}" method="POST" data-parsley-validate>
                                @csrf
                                <div class="form-group mandatory">
                                    <label for="name" class="form-label">Nama Unit</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required data-parsley-required="true">
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" id="saveButton" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Atur Ulang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script>
        document.getElementById('saveButton').addEventListener('click', function (e) {
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
                    document.getElementById('createUnitForm').submit();
                }
            });
        });
    </script>
@endsection