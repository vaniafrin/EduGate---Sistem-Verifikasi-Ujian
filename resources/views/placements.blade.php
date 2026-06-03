@extends('layout')

@section('content')
<style>
    /* Styling Dasar Halaman */
    .page-header { margin-bottom: 1.5rem; }
    
    /* Form & Cards Styling */
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
    .form-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.5rem;
    }
    .custom-select {
        border-radius: 8px;
        border-color: #CBD5E1;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        color: #0F172A;
    }
    .custom-select:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Interactive Table List UX untuk Pilih Siswa */
    .selection-table { margin-bottom: 0; }
    .selection-table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.8rem 1.25rem;
        border-bottom: 1px solid #E2E8F0;
    }
    .selection-row {
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }
    .selection-row td {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        font-size: 0.875rem;
    }
    .selection-row:hover {
        background-color: #F8FAFC;
    }
    .selection-row:has(input[type="checkbox"]:checked) {
        background-color: #EFF6FF;
    }
    .selection-row:has(input[type="checkbox"]:checked) td {
        color: #1E40AF;
        font-weight: 500;
    }
    .student-checkbox {
        width: 1.15em;
        height: 1.15em;
        cursor: pointer;
    }

    /* Tabel Ruangan Styling Bawah */
    .room-header {
        background-color: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
        border-left: 4px solid #3B82F6;
    }
    .table-custom { margin-bottom: 0; }
    .table-custom thead th {
        background-color: #FFFFFF;
        color: #64748B;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #E2E8F0;
    }
    .table-custom tbody td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .table-custom tbody tr:last-child td { border-bottom: none; }
    
    .btn-soft-danger {
        background-color: #FEE2E2;
        color: #DC2626;
        border: 1px solid transparent;
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        border-radius: 6px;
    }
    .btn-soft-danger:hover {
        background-color: #FECACA;
        color: #B91C1C;
    }
</style>

<div class="row">
    <div class="col-md-12">
        
        <div class="page-header">
            <h4 class="fw-bold mb-1" style="color: #0F172A;">Penempatan Peserta Ujian</h4>
            <p class="text-muted small mb-0">Alokasikan siswa ke dalam ruangan berdasarkan jadwal mata pelajaran.</p>
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

        <form action="{{ route('placements.store') }}" method="POST">
            @csrf
            <div class="saas-card mb-5">
                <div class="saas-card-header d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-primary fs-5"></i>
                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem;">Formulir Alokasi</h5>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran (Jadwal) <span class="text-danger">*</span></label>
                            <select name="examp_id" class="form-select custom-select" required>
                                <option value="">-- Pilih Jadwal Ujian --</option>
                                @foreach($examps as $examp)
                                    <option value="{{ $examp->id }}">{{ $examp->mata_pelajaran }} ({{ $examp->sesi }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ruangan Ujian <span class="text-danger">*</span></label>
                            <select name="room_id" class="form-select custom-select" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="border-light-subtle my-4">

                    <div class="p-4 rounded-3" style="background-color: #F8FAFC; border: 1px dashed #CBD5E1;">
                        <div class="row align-items-center mb-4">
                            <div class="col-md-5">
                                <label class="form-label mb-1">Filter Siswa Berdasarkan Kelas</label>
                                <select id="select-kelas" class="form-select custom-select shadow-sm">
                                    <option value="">-- Tampilkan Siswa Dari Kelas --</option>
                                    @foreach(\App\Models\Student::select('kelas')->distinct()->get() as $cls)
                                        <option value="{{ $cls->kelas }}">Kelas {{ $cls->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="student-list-container" style="display: none;">
                            <div class="bg-white border rounded-3 overflow-hidden shadow-sm">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table selection-table table-borderless w-100">
                                        <thead class="sticky-top z-1">
                                            <tr>
                                                <th width="5%" class="text-center">
                                                    <input class="form-check-input student-checkbox m-0" type="checkbox" id="btn-check-all">
                                                </th>
                                                <th width="35%">Nama Lengkap Siswa</th>
                                                <th width="20%">NISN</th>
                                                <th width="40%" class="text-end pe-4">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-area">
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-text mt-2 text-muted small"><i class="bi bi-info-circle me-1"></i> Klik pada baris nama untuk memilih/membatalkan pilihan dengan cepat.</div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold rounded-3" style="background-color: #2563EB; border-color: #2563EB;">
                            <i class="bi bi-save me-1"></i> Simpan Alokasi
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="d-flex align-items-center gap-2 mb-4 mt-5">
            <h5 class="fw-bold mb-0 text-dark">Daftar Siswa Teralokasi Per Ruangan</h5>
            <span class="badge bg-light text-secondary border px-2 py-1">Auto-Updated</span>
        </div>

        @forelse($placements->groupBy('room_id') as $roomId => $roomPlacements)
            @php
                $namaRuangan = $roomPlacements->first()->room->nama_ruangan ?? 'Ruangan Tidak Diketahui';
            @endphp
            
            <div class="saas-card mb-4">
                <div class="room-header p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-door-open fs-5 text-primary"></i>
                        <h6 class="mb-0 fw-bold text-dark">{{ $namaRuangan }}</h6>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                        {{ $roomPlacements->count() }} Peserta
                    </span>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-borderless">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama Siswa</th>
                                    <th width="12%">Kelas</th>
                                    <th>Mata Pelajaran (Sesi)</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomPlacements as $subKey => $placement)
                                <tr>
                                    <td class="text-center text-muted fw-medium">{{ $subKey + 1 }}</td>
                                    <td class="fw-medium text-dark">{{ $placement->student->nama ?? 'Siswa Terhapus' }}</td>
                                    <td><span class="badge bg-light text-secondary border">{{ $placement->student->kelas ?? '-' }}</span></td>
                                    <td class="text-secondary">{{ $placement->examp->mata_pelajaran ?? '-' }} <span class="text-muted small">({{ $placement->examp->sesi ?? '-' }})</span></td>
                                    <td class="text-center">
                                        <form action="{{ route('placements.destroy', $placement->id) }}" method="POST" class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan alokasi siswa ini?')" title="Batal Alokasi">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="saas-card border-dashed">
                <div class="card-body text-center py-5">
                    <i class="bi bi-clipboard-x d-block fs-1 text-muted mb-3 opacity-50"></i>
                    <h6 class="fw-medium text-dark">Belum Ada Alokasi</h6>
                    <p class="text-muted small mb-0">Silakan gunakan formulir di atas untuk menempatkan peserta ke ruangan.</p>
                </div>
            </div>
        @endforelse

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectKelas = document.getElementById('select-kelas');
        const container = document.getElementById('student-list-container');
        const tableArea = document.getElementById('table-area');
        const btnCheckAll = document.getElementById('btn-check-all');

        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = "0"; 
                setTimeout(() => {
                    successAlert.remove(); 
                }, 500); 
            }, 3000);
        }

        selectKelas.addEventListener('change', async function() {
            const kelas = this.value;
            
            if (!kelas) {
                container.style.display = 'none';
                tableArea.innerHTML = '';
                btnCheckAll.checked = false;
                return;
            }

            container.style.display = 'block';
            tableArea.innerHTML = `
                <tr>
                    <td colspan="4" class="py-4 text-center text-muted">
                        <div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div>
                        Memuat data siswa...
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(`/api/students/class/${kelas}`);
                const students = await response.json();

                tableArea.innerHTML = '';

                if(students.length === 0) {
                    tableArea.innerHTML = `
                        <tr>
                            <td colspan="4" class="py-4 text-center">
                                <div class="text-danger mb-0">
                                    <i class="bi bi-exclamation-circle me-1"></i> Tidak ada siswa yang terdaftar di kelas ini.
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                students.forEach(student => {
                    tableArea.innerHTML += `
                        <tr class="selection-row" onclick="toggleCheckbox('std-${student.id}')">
                            <td class="text-center" onclick="event.stopPropagation();">
                                <input class="form-check-input student-checkbox m-0 fs-5 row-cb" type="checkbox" name="student_ids[]" value="${student.id}" id="std-${student.id}" onchange="updateCheckAllStatus()">
                            </td>
                            <td>
                                <label for="std-${student.id}" class="mb-0 w-100" style="cursor: pointer;" onclick="event.preventDefault();">${student.nama}</label>
                            </td>
                            <td class="text-muted font-monospace">${student.nisn}</td>
                            <td class="text-end pe-4"><span class="badge bg-light text-secondary border">Siap Dialokasi</span></td>
                        </tr>
                    `;
                });
                
                btnCheckAll.checked = false;
            } catch (error) {
                tableArea.innerHTML = '<tr><td colspan="4" class="py-4 text-danger text-center">Gagal memuat data. Periksa koneksi jaringan.</td></tr>';
            }
        });

        btnCheckAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-cb');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });
    });

    function toggleCheckbox(id) {
        const checkbox = document.getElementById(id);
        checkbox.checked = !checkbox.checked;
        updateCheckAllStatus();
    }

    function updateCheckAllStatus() {
        const checkboxes = document.querySelectorAll('.row-cb');
        const checkedCheckboxes = document.querySelectorAll('.row-cb:checked');
        const btnCheckAll = document.getElementById('btn-check-all');
        
        btnCheckAll.checked = (checkboxes.length > 0 && checkboxes.length === checkedCheckboxes.length);
    }
</script>
@endsection