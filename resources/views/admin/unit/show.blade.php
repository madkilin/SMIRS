@extends('layouts.app')

@section('content')
    <h1>{{ $unit->name }}</h1>

    <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" id="deleteUnitForm" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" id="deleteButton" class="btn btn-danger">
            Delete
        </button>
    </form>
@endsection

@section('scripts')
<script>
    document.addEventListener('click', function (event) {
        if (event.target.id === 'deleteButton') {
            event.preventDefault();

            const form = document.getElementById('deleteUnitForm'); // Ambil form berdasarkan ID

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus unit ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form terkait
                }
            });
        }
    });
</script>
@endsection
