@extends('layout')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>Dashboard Pengawas: {{ $room->nama_ruangan }}</h2>
        <span id="examp-status" class="badge bg-secondary fs-5">Mengecek Status...</span>
    </div>
</div>

<div class="row mb-4 text-center">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <h5>Total Peserta</h5>
                <h1 id="stat-total" class="display-4 fw-bold">-</h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <h5>Sudah Tervalidasi</h5>
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

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Log Verifikasi Terakhir</h5>
                <small class="text-warning">Live Update <span class="spinner-grow spinner-grow-sm text-warning" role="status"></span></small>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Waktu Masuk</th>
                            <th>Foto Wajah</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="log-table-body">
                        <tr>
                            <td colspan="5" class="text-center text-muted">Memuat data secara real-time...</td>
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

                // Update Status Ujian
                document.getElementById('examp-status').className = "badge bg-success fs-5";
                document.getElementById('examp-status').innerText = "UJIAN AKTIF: " + data.exam;

                // Update Angka Statistik
                document.getElementById('stat-total').innerText = data.stats.total;
                document.getElementById('stat-hadir').innerText = data.stats.hadir;
                document.getElementById('stat-belum').innerText = data.stats.belum;

                // Update Tabel Log Terakhir
                const tbody = document.getElementById('log-table-body');
                tbody.innerHTML = ''; // Bersihkan tabel lama

                if (data.logs.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Belum ada peserta yang masuk ruangan.</td></tr>';
                } else {
                    data.logs.forEach(log => {
                        const row = `
                            <tr>
                                <td><span class="badge bg-info text-dark fs-6">${log.waktu} WIB</span></td>
                                <td><img src="${log.photo}" class="rounded-circle border" width="50" height="50" style="object-fit: cover;"></td>
                                <td class="fw-bold">${log.nama}</td>
                                <td>${log.kelas}</td>
                                <td><span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Tervalidasi Wajah</span></td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                }
            })
            .catch(error => console.error('Error fetching real-time data:', error));
    }

    // Tarik data pertama kali halaman dibuka
    fetchMonitorData();

    // Jalankan penarikan data secara berulang setiap 3000 milidetik (3 detik)
    setInterval(fetchMonitorData, 3000);
</script>
@endsection