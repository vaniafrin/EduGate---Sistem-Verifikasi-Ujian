@extends('layout')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>Dashboard Monitor Ruangan: {{ $room->nama_ruangan }}</h2>
        <span id="examp-status" class="badge bg-secondary fs-5">Mengecek Status Jam Server...</span>
    </div>
</div>

<div class="row mb-4 text-center">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <h5>Total Alokasi Siswa</h5>
                <h1 id="stat-total" class="display-4 fw-bold">-</h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <h5>Sudah Tervalidasi (Hadir)</h5>
                <h1 id="stat-hadir" class="display-4 fw-bold">-</h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body">
                <h5>Belum Datang</h5>
                <h1 id="stat-belum" class="display-4 fw-bold">-</h1>
            </div>
        </div>
    </div>
</div>

    <div class="col-md-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 small fw-bold">📋 Daftar Kehadiran Seluruh Peserta</h5>
                <small class="badge bg-light text-dark">Live Update ⏳</small>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody id="all-students-body">
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Memuat daftar siswa...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const roomId = '{{ $room->id }}';

    function fetchMonitorData() {
        fetch(`/monitor/data/${roomId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'offline') {
                    document.getElementById('examp-status').className = "badge bg-danger fs-5";
                    document.getElementById('examp-status').innerText = data.message;
                    return;
                }

                document.getElementById('examp-status').className = "badge bg-success fs-5";
                document.getElementById('examp-status').innerText = "UJIAN AKTIF: " + data.examp;

                document.getElementById('stat-total').innerText = data.stats.total;
                document.getElementById('stat-hadir').innerText = data.stats.hadir;
                document.getElementById('stat-belum').innerText = data.stats.belum;


                // update tabel siswa
                const studentTbody = document.getElementById('all-students-body');
                studentTbody.innerHTML = '';
                if (data.all_students.length === 0) {
                    studentTbody.innerHTML = '<tr><td colspan="5" class="text-center py-3">Tidak ada siswa teralokasi di ruangan ini.</td></tr>';
                } else {
                    data.all_students.forEach(student => {
                        const statusBadge = student.status === 'Hadir' 
                            ? '<span class="badge bg-success">✓ Hadir</span>' 
                            : '<span class="badge bg-danger">⏳ Belum Datang</span>';
                        
                        studentTbody.innerHTML += `
                            <tr>
                                <td><img src="${student.photo}" class="rounded-circle border" width="40" height="40" style="object-fit:cover;"></td>
                                <td class="fw-bold">${student.nama}</td>
                                <td>${student.kelas}</td>
                                <td>${statusBadge}</td>
                                <td class="text-muted small">${student.waktu}</td>
                            </tr>
                        `;
                    });
                }
            })
            .catch(error => console.error('Gagal mengambil data monitor:', error));
    }

   
    fetchMonitorData();
    setInterval(fetchMonitorData, 3000);
</script>
@endsection