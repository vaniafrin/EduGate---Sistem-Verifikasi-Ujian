<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Ruangan - {{ $room->nama_ruangan }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-canvas: #F8FAFC;
            --bg-surface: #FFFFFF;
            --text-main: #0F172A;
            --text-sub: #64748B;
            --brand-color: #2563EB;
            --border-color: #E2E8F0;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        /* Top Bar & Header */
        .main-header {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
        }

        .burger-btn {
            background: #F1F5F9;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .burger-btn:hover {
            background: #E2E8F0;
        }

        /* Modern Metric Cards */
        .card-metric {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .metric-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
            margin-top: 0.5rem;
        }
        .metric-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-sub);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Table Design Fixes */
        .card-table-container {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .table-custom-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table thead th {
            background-color: #F8FAFC;
            color: var(--text-sub);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.875rem;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        .table tbody tr {
            transition: background-color 0.15s ease;
        }
        .table tbody tr:hover {
            background-color: #F8FAFC !important;
        }

        /* Custom Soft Badges */
        .badge-soft-success {
            background-color: #DCFCE7;
            color: #15803D;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .badge-soft-warning {
            background-color: #FEF3C7;
            color: #B45309;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .badge-soft-server {
            background-color: #F1F5F9;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Sidebar Offcanvas */
        .offcanvas-modern {
            background-color: #0F172A;
            color: #FFFFFF;
            border-right: none;
        }
        .offcanvas-modern .nav-link {
            color: #94A3B8;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
        }
        .offcanvas-modern .nav-link:hover {
            color: #FFFFFF;
            background-color: #1E293B;
        }
    </style>
</head>
<body>

<div class="offcanvas offcanvas-start offcanvas-modern" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header border-bottom border-secondary py-4">
        <h5 class="offcanvas-title fw-bold fs-6 tracking-tight" id="sidebarMenuLabel">MENU UTAMA</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <nav class="nav flex-column">
            <a class="nav-link" href="/"><i class="bi bi-grid-1x2"></i> Halaman Utama</a>
            <a class="nav-link" href="/monitor"><i class="bi bi-display"></i> Daftar Monitor</a>
            <a class="nav-link" href="/placements"><i class="bi bi-shield-check"></i> Alokasi Ruangan</a>
        </nav>
    </div>
</div>

<header class="main-header sticky-top d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button class="burger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <i class="bi bi-text-left fs-4"></i>
        </button>
        <div>
            <h1 class="fs-5 fw-bold mb-0" style="color: var(--text-main);">Monitor: {{ $room->nama_ruangan }}</h1>
            <p class="text-muted small mb-0">Sistem Pemantauan Kehadiran Ujian Real-time</p>
        </div>
    </div>
    <span id="examp-status" class="badge badge-soft-server px-3 py-2 rounded-8">
        <i class="bi bi-arrow-clockwise me-1"></i> Sinkronisasi Jam Server...
    </span>
</header>

<div class="container-fluid py-4 px-md-5">
    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-metric">
                <div>
                    <div class="metric-label">Total Alokasi Siswa</div>
                    <div id="stat-total" class="metric-value">-</div>
                </div>
                <div class="metric-icon-box" style="background-color: #EFF6FF; color: #1D4ED8;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-metric">
                <div>
                    <div class="metric-label">Sudah Tervalidasi</div>
                    <div id="stat-hadir" class="metric-value" style="color: #16A34A;">-</div>
                </div>
                <div class="metric-icon-box" style="background-color: #DCFCE7; color: #16A34A;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-metric">
                <div>
                    <div class="metric-label">Belum Datang</div>
                    <div id="stat-belum" class="metric-value" style="color: #D97706;">-</div>
                </div>
                <div class="metric-icon-box" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-table-container">
                <div class="table-custom-header">
                    <h2 class="fs-6 fw-bold mb-0"><i class="bi bi-list-task me-2 text-muted"></i>Daftar Kehadiran Seluruh Peserta</h2>
                    <span class="badge bg-light text-secondary border fw-medium px-2 py-1" style="font-size: 0.75rem;">
                        <i class="bi bi-broadcast text-danger me-1"></i> Live Update
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">Foto</th>
                                <th>Nama Lengkap Peserta</th>
                                <th width="150">Kelas</th>
                                <th width="180">Status Verifikasi</th>
                                <th width="150">Waktu Presensi</th>
                            </tr>
                        </thead>
                        <tbody id="all-students-body">
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                                    Memuat daftar data siswa...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const roomId = '{{ $room->id }}';

    function fetchMonitorData() {
        fetch(`/monitor/data/${roomId}`)
            .then(response => {
                if (!response.ok) throw new Error("Gagal terhubung ke server.");
                return response.json();
            })
            .then(data => {
                const statusBox = document.getElementById('examp-status');
                const studentTbody = document.getElementById('all-students-body');

                if (data.status === 'offline') {
                    statusBox.className = "badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-8";
                    statusBox.innerHTML = `<i class="bi bi-wifi-off me-1"></i> ${data.message}`;
                    
                    document.getElementById('stat-total').innerText = "-";
                    document.getElementById('stat-hadir').innerText = "-";
                    document.getElementById('stat-belum').innerText = "-";
                    
                    studentTbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-calendar-x d-block fs-3 mb-2 opacity-50"></i> Belum ada jadwal ujian yang aktif di ruangan ini.</td></tr>';
                    
                    return; 
                }

                statusBox.className = "badge badge-soft-server px-3 py-2 rounded-8";
                statusBox.innerHTML = `<i class="bi bi-shield-check text-primary me-1"></i> UJIAN AKTIF: ${data.examp}`;

                document.getElementById('stat-total').innerText = data.stats?.total || 0;
                document.getElementById('stat-hadir').innerText = data.stats?.hadir || 0;
                document.getElementById('stat-belum').innerText = data.stats?.belum || 0;

                studentTbody.innerHTML = '';
                
                if (!data.all_students || data.all_students.length === 0) {
                    studentTbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-folder2-open d-block fs-3 mb-2 opacity-50"></i> Tidak ada siswa teralokasi di ruangan ini.</td></tr>';
                } else {
                    data.all_students.forEach(student => {
                        const statusBadge = student.status === 'Hadir' 
                            ? '<span class="badge-soft-success"><i class="bi bi-check-circle-fill"></i> Hadir</span>' 
                            : '<span class="badge-soft-warning"><i class="bi bi-clock"></i> Belum Datang</span>';
                        
                        studentTbody.innerHTML += `
                            <tr>
                                <td class="text-center">
                                    <img src="${student.photo}" class="rounded-circle border" width="40" height="40" style="object-fit:cover; border-color: var(--border-color) !important;">
                                </td>
                                <td class="fw-semibold" style="color: var(--text-main);">${student.nama}</td>
                                <td class="text-secondary">${student.kelas}</td>
                                <td>${statusBadge}</td>
                                <td class="text-muted fw-medium">${student.waktu || '-'}</td>
                            </tr>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error('Gagal mengambil data monitor:', error);
                document.getElementById('all-students-body').innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-5 text-danger bg-danger-subtle">
                            <i class="bi bi-exclamation-triangle-fill d-block fs-3 mb-2"></i> 
                            Gagal memuat data dari server. Silakan cek koneksi atau hubungi admin.
                        </td>
                    </tr>
                `;
            });
    }

    fetchMonitorData();
    setInterval(fetchMonitorData, 3000);
</script>
</body>
</html>