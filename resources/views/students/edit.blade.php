@extends('layout')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Data Siswa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" value="{{ $student->nisn }}" required>
            </div>
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ $student->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ $student->kelas }}" required>
            </div>
            <div class="mb-3">
                <label>Foto Siswa</label>
                    @if($student->photo_path)
                     <div class="mb-2">
                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto Siswa" width="100" class="img-thumbnail">
                    </div>
                    @endif
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
             </div>
             <div class="mb-3">
                <label>Scan Kartu RFID</label>
                <input type="text" name="rfid_uid" class="form-control" value="{{ $student->rfid_uid }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Data</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection