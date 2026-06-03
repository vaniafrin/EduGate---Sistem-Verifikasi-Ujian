@extends('layout')

@section('content')
<style>
    /* Styling Dasar Halaman */
    .page-header { margin-bottom: 1.5rem; }
    
    /* Card Panel Styling */
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
    
    /* Form & Label Styling */
    .form-label-custom {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.5rem;
        display: block;
    }
    .custom-input {
        border-radius: 8px;
        border-color: #CBD5E1;
        padding: 0.65rem 1rem;
        font-size: 0.9rem;
        color: #0F172A;
        transition: all 0.2s;
    }
    .custom-input:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* RFID Input Accent */
    .rfid-input-group {
        background-color: #F8FAFC;
        border: 1px dashed #CBD5E1;
        border-radius: 8px;
        padding: 1rem;
    }

    /* Avatar & Photo Container */
    .photo-preview-wrapper {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 1rem;
    }
    .avatar-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #FFFFFF;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    /* Button Layout */
    .btn-custom-save {
        background-color: #2563EB;
        border-color: #2563EB;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-custom-save:hover {
        background-color: #1D4ED8;
        border-color: #1D4ED8;
    }
    .btn-custom-back {
        background-color: #FFFFFF;
        color: #64748B;
        border: 1px solid #E2E8F0;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-custom-back:hover {
        background-color: #F8FAFC;
        color: #475569;
    }
</style>

<div class="page-header">
    <h4 class="fw-bold mb-1" style="color: #0F172A;">Perbarui Profil Siswa</h4>
    <p class="text-muted small mb-0">Ubah data identitas, kelas, foto, serta konfigurasi kartu RFID akses siswa.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="saas-card">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-primary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Formulir Ubah Data</h6>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control custom-input" value="{{ $student->nisn }}" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control custom-input" value="{{ $student->kelas }}" required autocomplete="off">
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control custom-input" value="{{ $student->nama }}" required autocomplete="off">
                        </div>

                        <div class="col-12 mt-4">
                            <div class="rfid-input-group">
                                <label class="form-label-custom mb-2 text-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-broadcast"></i> Kode UID RFID / Kartu Akses <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="rfid_uid" class="form-control custom-input bg-white" value="{{ $student->rfid_uid }}" placeholder="Tempelkan kartu pada reader..." required>
                                <div class="form-text small text-muted mt-1">Gunakan pemindai RFID fisik untuk memperbarui kode UID ini secara otomatis.</div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label-custom">Foto Profil Siswa</label>
                            
                            @if($student->photo_path)
                            <div class="mb-3">
                                <div class="photo-preview-wrapper">
                                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto {{ $student->nama }}" class="avatar-preview">
                                    <div>
                                        <span class="badge bg-soft-primary text-primary px-2 py-1 mb-1" style="background-color: #EFF6FF; font-size: 0.75rem;">Foto Terpasang</span>
                                        <p class="small text-muted mb-0">File gambar saat ini aktif digunakan sistem.</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <input type="file" name="photo" class="form-control custom-input" accept="image/*">
                            <div class="form-text small text-muted mt-1">Format rekomendasi: JPG, JPEG atau PNG. Biarkan kosong jika tidak ingin mengubah foto saat ini.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2 mt-5 pt-3 border-top">
                        <a href="{{ route('students.index') }}" class="btn btn-custom-back">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom-save text-white shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection