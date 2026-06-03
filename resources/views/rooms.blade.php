@extends('layout')

@section('content')
<style>
    /* Styling Dasar Halaman */
    .page-header { margin-bottom: 1.5rem; }
    
    /* Card & Panel Styling */
    .saas-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .saas-card-header {
        background-color: #FFFFFF;
        border-bottom: 1px solid #E2E8F0;
        padding: 1.25rem 1.5rem;
    }
    
    /* Form Styling */
    .form-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.5rem;
    }
    .custom-input {
        border-radius: 8px;
        border-color: #CBD5E1;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        color: #0F172A;
        transition: all 0.2s;
    }
    .custom-input:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Table Styling */
    .table-custom { margin-bottom: 0; }
    .table-custom thead th {
        background-color: #F8FAFC;
        color: #64748B;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        border-top: none;
    }
    .table-custom tbody td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.875rem;
        color: #0F172A;
        vertical-align: middle;
    }
    .table-custom tbody tr:hover { background-color: #F8FAFC; }
    
    /* Soft Buttons untuk Aksi */
    .btn-action {
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .btn-soft-primary {
        background-color: #EFF6FF;
        color: #2563EB;
        border: 1px solid transparent;
    }
    .btn-soft-primary:hover {
        background-color: #DBEAFE;
        color: #1D4ED8;
    }
    .btn-soft-success {
        background-color: #F0FDF4;
        color: #16A34A;
        border: 1px solid transparent;
    }
    .btn-soft-success:hover {
        background-color: #DCFCE7;
        color: #15803D;
    }
    .btn-soft-danger {
        background-color: #FEE2E2;
        color: #DC2626;
        border: 1px solid transparent;
    }
    .btn-soft-danger:hover {
        background-color: #FECACA;
        color: #B91C1C;
    }
</style>

<div class="page-header">
    <h4 class="fw-bold mb-1" style="color: #0F172A;">Manajemen Ruangan Ujian</h4>
    <p class="text-muted small mb-0">Kelola daftar ruangan, akses scanner RFID, dan layar monitor pengawas.</p>
</div>

@if(session('success'))
    <div id="success-alert" class="alert alert-success d-flex align-items-center p-3 mb-4 border-0 shadow-sm fade show" style="background-color: #DCFCE7; color: #15803D; border-radius: 10px; transition: opacity 0.5s ease-out;" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
        <div class="fw-medium" style="font-size: 0.875rem;">
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row align-items-start">
    <div class="col-md-4 mb-4 mb-md-0">
        <div class="saas-card position-sticky" style="top: 1.5rem;">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-plus-square text-primary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Tambah Ruangan Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ruangan" class="form-control custom-input" placeholder="Contoh: Lab Komputer 1" required autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3" style="background-color: #2563EB; border-color: #2563EB;">
                        <i class="bi bi-save me-1"></i> Simpan Ruangan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="saas-card">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-door-open text-secondary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Daftar Ruangan Tersedia</h6>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-borderless">
                        <thead>
                            <tr>
                                <th width="70" class="text-center">No</th>
                                <th>Identitas Ruangan</th>
                                <th width="320" class="text-center">Panel Kontrol (Buka Tab Baru)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $key => $room)
                            <tr>
                                <td class="text-center text-muted fw-medium">{{ $key + 1 }}</td>
                                <td class="fw-semibold text-dark">{{ $room->nama_ruangan }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('scanner', $room->id) }}" target="_blank" class="btn btn-action btn-soft-primary">
                                            <i class="bi bi-qr-code-scan me-1"></i> Scanner
                                        </a>
                                        
                                        <a href="{{ route('monitor.index', $room->id) }}" target="_blank" class="btn btn-action btn-soft-success">
                                            <i class="bi bi-display me-1"></i> Monitor
                                        </a>

                                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-soft-danger px-2" title="Hapus Ruangan">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-building-exclamation d-block fs-1 mb-3 opacity-50"></i>
                                        <h6 class="fw-medium text-dark mb-1">Belum ada data ruangan</h6>
                                        <p class="small mb-0">Silakan tambahkan ruangan baru melalui form di sebelah kiri.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = "0"; 
                setTimeout(() => {
                    successAlert.remove(); 
                }, 500); 
            }, 3000); 
        }
    });
</script>
@endsection