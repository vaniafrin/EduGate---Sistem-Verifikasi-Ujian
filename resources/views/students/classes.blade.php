@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Data Siswa</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary">+ Tambah Siswa Baru</a>
</div>

<div class="row">
    @forelse($classes as $c)
        <div class="col-md-3 mb-3">
            <a href="{{ route('students.class', $c->kelas) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 bg-light hover-shadow">
                    <div class="card-body text-center py-4">
                        <h1 class="text-primary mb-0"><i class="bi bi-folder-fill"></i></h1>
                        <h4 class="text-dark fw-bold mt-2">Kelas {{ $c->kelas }}</h4>
                        <span class="badge bg-secondary">{{ $c->total }} Siswa</span>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12 text-center text-muted">Belum ada data siswa sama sekali.</div>
    @endforelse
</div>
@endsection