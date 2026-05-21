@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('placements.store') }}" method="POST">
            @csrf
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Alokasi Peserta ke Ruangan Ujian</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Mata Pelajaran (Jadwal)</label>
                            <select name="examp_id" class="form-select" required>
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($examps as $examp)
                                    <option value="{{ $examp->id }}">{{ $examp->mata_pelajaran }} ({{ $examp->sesi }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Ruangan Ujian</label>
                            <select name="room_id" class="form-select" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label class="fw-bold">Filter Berdasarkan Kelas</label>
                        <select id="select-kelas" class="form-select w-50">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach(\App\Models\Student::select('kelas')->distinct()->get() as $cls)
                                <option value="{{ $cls->kelas }}">{{ $cls->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="student-list-container" class="border rounded p-3 bg-light" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold">Pilih Siswa yang Akan Dialokasikan:</h6>
                            <button type="button" id="btn-check-all" class="btn btn-sm btn-outline-primary">Pilih Semua</button>
                        </div>
                        
                        <div id="checkbox-area" class="row"></div>
                    </div>

                    <button type="submit" class="btn btn-success mt-4 w-100 fw-bold">Simpan Alokasi</button>
                </div>
            </div>
        </form>

        <h4 class="mb-3 fw-bold mt-5 text-dark">📋 Daftar Siswa Teralokasi Per Ruangan</h4>

        @forelse($placements->groupBy('room_id') as $roomId => $roomPlacements)
            @php
                // Mengambil nama ruangan dengan aman dari data pertama di kelompok ini
                $namaRuangan = $roomPlacements->first()->room->nama_ruangan ?? 'Ruangan Tidak Diketahui';
            @endphp
            
            <div class="card shadow-sm mb-4 border-start border-primary border-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">📍 {{ $namaRuangan }}</h5>
                    <span class="badge bg-primary fs-6">{{ $roomPlacements->count() }} Siswa</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran (Sesi)</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomPlacements as $subKey => $placement)
                                <tr>
                                    <td>{{ $subKey + 1 }}</td>
                                    <td class="fw-bold text-secondary">{{ $placement->student->nama ?? 'Siswa Terhapus' }}</td>
                                    <td><span class="badge bg-secondary">{{ $placement->student->kelas ?? '-' }}</span></td>
                                    <td>{{ $placement->examp->mata_pelajaran ?? '-' }} ({{ $placement->examp->sesi ?? '-' }})</td>
                                    <td class="text-center">
                                        <form action="{{ route('placements.destroy', $placement->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm py-1" onclick="return confirm('Batalkan alokasi siswa ini?')">
                                                Batal
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
            <div class="card shadow-sm">
                <div class="card-body text-center text-muted py-4">
                    Belum ada siswa yang dialokasikan ke ruangan mana pun.
                </div>
            </div>
        @endforelse

    </div>
</div>

<script>
    const selectKelas = document.getElementById('select-kelas');
    const container = document.getElementById('student-list-container');
    const checkboxArea = document.getElementById('checkbox-area');
    const btnCheckAll = document.getElementById('btn-check-all');
    let isAllChecked = false;

    // Ketika dropdown kelas diubah
    selectKelas.addEventListener('change', async function() {
        const kelas = this.value;
        
        if (!kelas) {
            container.style.display = 'none';
            checkboxArea.innerHTML = '';
            return;
        }

        // loading state
        container.style.display = 'block';
        checkboxArea.innerHTML = '<div class="col-12 text-center text-muted">Sedang memuat data siswa...</div>';

        const response = await fetch(`/api/students/class/${kelas}`);
        const students = await response.json();

        checkboxArea.innerHTML = '';

        if(students.length === 0) {
            checkboxArea.innerHTML = '<div class="col-12 text-danger">Tidak ada siswa di kelas ini.</div>';
            return;
        }

        // tampilkan checkbox untuk setiap siswa
        students.forEach(student => {
            checkboxArea.innerHTML += `
                <div class="col-md-4 mb-2">
                    <div class="form-check border bg-white p-2 rounded shadow-sm">
                        <input class="form-check-input ms-1 student-checkbox" type="checkbox" name="student_ids[]" value="${student.id}" id="std-${student.id}">
                        <label class="form-check-label ms-2 w-100" style="cursor:pointer;" for="std-${student.id}">
                            ${student.nama} <br>
                            <small class="text-muted">${student.nisn}</small>
                        </label>
                    </div>
                </div>
            `;
        });
        
        isAllChecked = false;
        btnCheckAll.innerText = "Pilih Semua";
    });

    // select all toggle
    btnCheckAll.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        isAllChecked = !isAllChecked;
        
        checkboxes.forEach(cb => {
            cb.checked = isAllChecked;
        });

        this.innerText = isAllChecked ? "Batalkan Pilihan" : "Pilih Semua";
    });
</script>
@endsection