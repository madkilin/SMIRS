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
                        <li class="breadcrumb-item active" aria-current="page">Kelola Pemasok</li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pemasok</li>
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
                        <h4 class="card-title">Tambah Pemasok</h4>
                        <p class="text-subtitle text-muted">
                            Tambahkan pemasok baru sesuai kebutuhan dan pastikan data yang dimasukkan sudah benar.
                        </p>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="createSupplierForm" action="{{ route('admin.suppliers.store') }}" method="POST" data-parsley-validate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="supplier-column" class="form-label">Nama Pemasok</label>
                                            <input type="text" id="supplier-column" class="form-control" placeholder="Nama Pemasok" name="name" value="{{ old('name') }}" required data-parsley-required="true" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="phone-column" class="form-label">Nomor Telepon</label>
                                            <input type="tel" id="phone-column" class="form-control" placeholder="Nomor Telepon/WhatsApp" name="phone" value="{{ old('phone') }}" required data-parsley-required="true" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="email-id-column" class="form-label">Email</label>
                                            <input type="email" id="email-id-column" class="form-control" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required data-parsley-required="true" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="address-column" class="form-label">Alamat</label>
                                            <textarea id="address-column" class="form-control" placeholder="Alamat Pemasok" name="address" required data-parsley-required="true">{{ old('address') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="saveButton" class="btn btn-primary me-1 mb-1">Simpan</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Atur Ulang</button>
                                    </div>
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
                    document.getElementById('createSupplierForm').submit();
                }
            });
        });
    </script>
@endsection