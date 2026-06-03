@extends('layout')

@section('content')
<style>
    .page-header { margin-bottom: 1.5rem; }
    .table-container {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
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
    
    /* Soft Buttons */
    .btn-action {
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-soft-info {
        background-color: #EFF6FF;
        color: #2563EB;
        border: 1px solid transparent;
    }
    .btn-soft-info:hover {
        background-color: #DBEAFE;
        color: #1D4ED8;
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
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #FFFFFF;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
</style>

<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #0F172A;">Data Induk Siswa</h4>
        <p class="text-muted small mb-0">
            Menampilkan daftar peserta ujian untuk <strong class="text-dark">Kelas {{ $kelas ?? 'Semua' }}</strong>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('students.index') }}" class="btn btn-light border bg-white text-secondary fw-medium shadow-sm" style="font-size: 0.875rem;">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('students.create') }}" class="btn btn-primary fw-medium shadow-sm" style="font-size: 0.875rem; background-color: #2563EB; border-color: #2563EB;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center p-3 mb-4 border-0 shadow-sm" style="background-color: #DCFCE7; color: #15803D; border-radius: 10px;" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
        <div class="fw-medium" style="font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-custom table-borderless">
            <thead>
                <tr>
                    <th width="70" class="text-center">No</th>
                    <th width="150">NISN</th>
                    <th>Nama Lengkap</th>
                    <th width="150" class="text-center">Detail</th>
                    <th width="180" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $key => $student)
                <tr>
                    <td class="text-center text-muted fw-medium">{{ $key + 1 }}</td>
                    <td class="fw-semibold font-monospace text-secondary">{{ $student->nisn }}</td>
                    <td class="fw-medium">{{ $student->nama }}</td>
                    
                    <td class="text-center">
                        <button type="button" class="btn btn-action btn-soft-info" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDetailSiswa"
                                data-nama="{{ $student->nama }}"
                                data-nisn="{{ $student->nisn }}"
                                data-kelas="{{ $student->kelas }}"
                                data-rfid="{{ $student->rfid_uid ?? 'Belum Terdaftar' }}"
                                data-foto="{{ $student->photo_path ? asset('storage/' . $student->photo_path) : '' }}">
                            <i class="bi bi-person-vcard me-1"></i> Lihat Profil
                        </button>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-action btn-soft-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action btn-soft-danger" onclick="return confirm('Hapus siswa ini permanen?')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox d-block fs-1 mb-2 opacity-50"></i>
                        Belum ada data siswa yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalDetailSiswa" tabindex="-1" aria-labelledby="modalDetailSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0 pb-4 px-4">
                
                <div class="mb-3 mt-n3">
                    <img id="detail-foto" src="" alt="Foto Siswa" class="profile-avatar bg-light">
                    <div id="detail-no-foto" class="profile-avatar bg-light d-none align-items-center justify-content-center mx-auto text-secondary" style="font-size: 3rem;">
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <h4 id="detail-nama" class="fw-bold mb-1" style="color: #0F172A;">Nama Siswa</h4>
                <span id="detail-kelas" class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-medium mb-4">Kelas</span>

                <div class="row g-3 text-start">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                            <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.7rem;">Nomor Induk (NISN)</div>
                            <div id="detail-nisn" class="fw-bold text-dark font-monospace">123456789</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                            <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.7rem;">UID Kartu RFID</div>
                            <div id="detail-rfid" class="fw-bold text-dark font-monospace">A1B2C3D4</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalDetail = document.getElementById('modalDetailSiswa');
        
        modalDetail.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const nama = button.getAttribute('data-nama');
            const nisn = button.getAttribute('data-nisn');
            const kelas = button.getAttribute('data-kelas');
            const rfid = button.getAttribute('data-rfid');
            const foto = button.getAttribute('data-foto');
            
            document.getElementById('detail-nama').textContent = nama;
            document.getElementById('detail-nisn').textContent = nisn;
            document.getElementById('detail-kelas').textContent = 'Kelas: ' + kelas;
            document.getElementById('detail-rfid').textContent = rfid;
            
            const imgEl = document.getElementById('detail-foto');
            const noImgEl = document.getElementById('detail-no-foto');
            
            if (foto) {
                imgEl.src = foto;
                imgEl.classList.remove('d-none');
                imgEl.classList.add('d-block');
                noImgEl.classList.remove('d-flex');
                noImgEl.classList.add('d-none');
            } else {
                imgEl.classList.remove('d-block');
                imgEl.classList.add('d-none');
                noImgEl.classList.remove('d-none');
                noImgEl.classList.add('d-flex');
            }
        });
    });
</script>
@endsection