@extends('layout')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tambah Data Siswa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Foto Siswa</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
             </div>
             <div class="mb-3">
                <label>Scan Kartu RFID</label>
                <input type="text" name="rfid_uid" class="form-control" placeholder="Tap kartu ke alat scanner..." required>
                <small class="text-muted">Pastikan kursor ada di kotak ini saat men-tap kartu.</small>
            </div>
            <button type="submit" class="btn btn-success">Simpan Data</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection