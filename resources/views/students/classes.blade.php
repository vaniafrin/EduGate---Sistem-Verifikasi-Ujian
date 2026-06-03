@extends('layout')

@section('content')
<style>
    /* Styling Dasar Halaman */
    .page-header { margin-bottom: 2rem; }
    
    /* Tombol Utama */
    .btn-primary-custom {
        background-color: #2563EB;
        border-color: #2563EB;
        transition: all 0.2s;
    }
    .btn-primary-custom:hover {
        background-color: #1D4ED8;
        border-color: #1D4ED8;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }

    /* Card Folder Styling */
    .saas-card-folder {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    /* Efek Hover (Micro-interaction) */
    .saas-card-folder:hover {
        border-color: #3B82F6;
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }
    
    /* Ikon Folder */
    .folder-icon-wrapper {
        width: 64px;
        height: 64px;
        background-color: #EFF6FF;
        color: #2563EB;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem auto;
        transition: all 0.2s;
    }
    .saas-card-folder:hover .folder-icon-wrapper {
        background-color: #2563EB;
        color: #FFFFFF;
    }

    /* Badge Jumlah Siswa */
    .student-count-badge {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 0.8125rem;
        border: 1px solid #E2E8F0;
    }
    
    /* Empty State Styling */
    .border-dashed {
        border: 2px dashed #CBD5E1;
        border-radius: 16px;
        background-color: #F8FAFC;
    }
</style>

<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #0F172A;">Manajemen Data Siswa</h4>
        <p class="text-muted small mb-0">Kelola basis data siswa dan pantau jumlah peserta didik berdasarkan kelas.</p>
    </div>
    <a href="{{ route('students.create') }}" class="btn btn-primary-custom px-4 py-2 fw-semibold rounded-3 shadow-sm text-white text-decoration-none d-inline-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i> Tambah Siswa Baru
    </a>
</div>

<div class="row g-4">
    @forelse($classes as $c)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <a href="{{ route('students.class', $c->kelas) }}" class="text-decoration-none">
                <div class="saas-card-folder p-4 text-center h-100">
                    
                    <div class="folder-icon-wrapper">
                        <i class="bi bi-folder2-open fs-2"></i>
                    </div>
                    
                    <h5 class="fw-bold mb-2" style="color: #0F172A;">Kelas {{ $c->kelas }}</h5>
                    
                    <div class="mt-3">
                        <span class="badge student-count-badge rounded-pill px-3 py-2">
                            <i class="bi bi-people-fill me-1 opacity-50"></i> {{ $c->total }} Siswa
                        </span>
                    </div>
                    
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="border-dashed text-center py-5 shadow-sm">
                <i class="bi bi-folder-x d-block fs-1 mb-3" style="color: #94A3B8;"></i>
                <h6 class="fw-bold text-dark mb-1">Belum Ada Data Siswa</h6>
                <p class="text-muted small mb-3">Sistem belum mendeteksi adanya data kelas maupun siswa yang terdaftar.</p>
                <a href="{{ route('students.create') }}" class="btn btn-sm btn-outline-primary fw-medium rounded-pill px-4">
                    Mulai Tambah Data
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection