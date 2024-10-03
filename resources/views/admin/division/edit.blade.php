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
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola User</li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Divisi</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Divisi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Divisi</h4>
                        <p class="text-subtitle text-muted">
                            Edit/ubah divisi sesuai kebutuhan dan pastikan data yang dimasukkan sudah benar.
                        </p>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST" data-parsley-validate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="name" class="form-label">Divisi</label>
                                            <input type="text" id="name" class="form-control" placeholder="Nama Divisi" name="name" value="{{ $division->name }}" data-parsley-required="true" required>
                                        </div>
                                    </div>
                                    <!-- Category -->
                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group mandatory">
                                            <label for="category-column" class="form-label">Spesialisasi Barang</label>
                                            <select name="category" class="form-select" id="category-column" required>
                                                <option value="perangkat" {{ $division->category == 'perangkat' ? 'selected' : '' }}>Perangkat</option>
                                                <option value="elektronik" {{ $division->category == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                                                <option value="kesehatan" {{ $division->category == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                                <option value="perlengkapan" {{ $division->category == 'perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                                <option value="lainnya" {{ $division->category == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
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
    <!-- Basic multiple Column Form section end -->
</div>
@endsection
