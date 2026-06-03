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
        gap: 0.35rem;
    }
    .btn-soft-warning {
        background-color: #FEF3C7;
        color: #D97706;
        border: 1px solid transparent;
    }
    .btn-soft-warning:hover {
        background-color: #FDE68A;
        color: #B45309;
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

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .modal-header {
        border-bottom: 1px solid #F1F5F9;
        background-color: #F8FAFC;
        border-radius: 16px 16px 0 0;
        padding: 1.25rem 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid #F1F5F9;
        padding: 1.25rem 1.5rem;
    }
</style>

<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #0F172A;">Jadwal Ujian</h4>
        <p class="text-muted small mb-0">Kelola mata pelajaran, sesi, dan waktu pelaksanaan ujian.</p>
    </div>
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

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="saas-card">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-calendar-plus text-primary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Tambah Jadwal Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('examps.store') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" name="mata_pelajaran" class="form-control custom-input" placeholder="Misal: Kimia" required autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sesi</label>
                        <input type="text" name="sesi" class="form-control custom-input" placeholder="Misal: Sesi 1" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="waktu_mulai" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" name="waktu_selesai" class="form-control custom-input" required>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-3" style="background-color: #2563EB; border-color: #2563EB;">
                            <i class="bi bi-save me-1"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="saas-card">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-calendar3 text-secondary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Jadwal Ujian Terdaftar</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-borderless">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Sesi</th>
                                <th>Hari / Tanggal</th>
                                <th>Waktu (WIB)</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examps as $examp)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $examp->mata_pelajaran }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2 py-1">{{ $examp->sesi ?? '-' }}</span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-event text-muted me-1"></i> 
                                    {{ \Carbon\Carbon::parse($examp->tanggal)->format('d M Y') }}
                                </td>
                                <td>
                                    <i class="bi bi-clock text-muted me-1"></i> 
                                    {{ $examp->waktu_mulai }} <span class="text-muted mx-1">-</span> {{ $examp->waktu_selesai }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-action btn-soft-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $examp->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        
                                        <form action="{{ route('examps.destroy', $examp->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-soft-danger px-2" title="Hapus Jadwal">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $examp->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $examp->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h5 class="modal-title fw-bold text-dark mb-0 fs-5" id="editModalLabel{{ $examp->id }}">
                                                <i class="bi bi-pencil-square text-warning me-2"></i>Edit Jadwal Ujian
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                        <form action="{{ route('examps.update', $examp->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start p-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                                    <input type="text" name="mata_pelajaran" class="form-control custom-input" value="{{ $examp->mata_pelajaran }}" required autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sesi Ujian</label>
                                                    <input type="text" name="sesi" class="form-control custom-input" value="{{ $examp->sesi }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Ujian <span class="text-danger">*</span></label>
                                                    <input type="date" name="tanggal" class="form-control custom-input" value="{{ $examp->tanggal }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                                        <input type="time" name="waktu_mulai" class="form-control custom-input" value="{{ $examp->waktu_mulai }}" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                                        <input type="time" name="waktu_selesai" class="form-control custom-input" value="{{ $examp->waktu_selesai }}" required> 
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-light border bg-white text-secondary fw-medium shadow-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary fw-semibold px-4" style="background-color: #2563EB; border-color: #2563EB;">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-calendar-x d-block fs-1 mb-3 opacity-50"></i>
                                        <h6 class="fw-medium text-dark mb-1">Belum ada jadwal terdaftar</h6>
                                        <p class="small mb-0">Gunakan form di atas untuk menambahkan jadwal ujian baru.</p>
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