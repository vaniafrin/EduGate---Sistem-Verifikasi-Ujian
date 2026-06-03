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

    /* RFID Highlight Group */
    .rfid-input-group {
        background-color: #EFF6FF; /* Soft Blue Highlight */
        border: 2px dashed #93C5FD;
        border-radius: 10px;
        padding: 1.25rem;
        transition: all 0.2s;
    }
    .rfid-input-group:focus-within {
        background-color: #DBEAFE;
        border-color: #3B82F6;
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
    <h4 class="fw-bold mb-1" style="color: #0F172A;">Tambah Data Siswa Baru</h4>
    <p class="text-muted small mb-0">Daftarkan identitas, kelas, dan integrasikan kartu RFID akses untuk siswa baru.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="saas-card">
            <div class="saas-card-header d-flex align-items-center gap-2">
                <i class="bi bi-person-plus text-primary fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Formulir Pendaftaran</h6>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-12 mb-2">
                            <div class="rfid-input-group">
                                <label class="form-label-custom mb-2 text-primary d-flex align-items-center gap-2">
                                    <i class="bi bi-broadcast fs-5"></i> Registrasi Kartu RFID <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="rfid_uid" class="form-control custom-input bg-white shadow-sm" placeholder="Tap kartu ke alat scanner sekarang..." required autofocus autocomplete="off">
                                <div class="form-text small text-primary mt-2 fw-medium">
                                    <i class="bi bi-info-circle me-1"></i> Pastikan kursor berkedip di kotak ini saat Anda men-tap kartu pada scanner.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label-custom">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control custom-input" placeholder="Masukkan NISN siswa" required autocomplete="off">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label-custom">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control custom-input" placeholder="Contoh: 11 RPL 2" required autocomplete="off">
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control custom-input" placeholder="Masukkan nama lengkap siswa" required autocomplete="off">
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Foto Profil Siswa</label>
                            <input type="file" name="photo" class="form-control custom-input" accept="image/*">
                            <div class="form-text small text-muted mt-1">Format rekomendasi: JPG, JPEG atau PNG.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2 mt-5 pt-3 border-top">
                        <a href="{{ route('students.index') }}" class="btn btn-custom-back">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom-save text-white shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection