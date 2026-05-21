@extends('layout')

@section('content')
<div class="mb-3">
    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali ke Daftar Kelas
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Siswa- Kelas {{ $kelas ?? 'Semua' }}</h5>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <!-- <td>
                        @if($student->photo_path)
                            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto" width="50" height="50" class="rounded-circle" style="object-fit: cover;">
                        @else
                            <span class="badge bg-secondary">No Photo</span>
                        @endif
                     </td>  -->
                    <td>{{ $student->nisn }}</td>
                    <td>{{ $student->nama }}</td>
                    <td>{{ $student->kelas }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection