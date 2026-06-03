<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Presensi Ujian</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Design System Token (Slate & Premium Indigo Mood) */
        :root {
            --sidebar-width: 280px;
            --bg-canvas: #F8FAFC;
            --bg-surface: #FFFFFF;
            --bg-sidebar: #0F172A; /* Deep Slate */
            --bg-sidebar-hover: #1E293B;
            --text-main: #0F172A;
            --text-sub: #64748B;
            --border-color: #E2E8F0;
            --brand-color: #3B82F6;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            letter-spacing: -0.01em;
            overflow-x: hidden;
        }

        /* App Layout Containers */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* 1. SIDEBAR CONTAINER COMPONENTS */
        .sidebar-panel {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            color: #F8FAFC;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            border-right: 1px solid #1E293B;
            transition: all 0.3s ease;
        }

        /* Brand Identity */
        .sidebar-brand {
            padding: 1.5rem 1.75rem;
            font-size: 1.15rem;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.02em;
            border-bottom: 1px solid #1E293B;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-brand i {
            color: var(--brand-color);
            font-size: 1.35rem;
        }

        /* Nav Menu List */
        .sidebar-menu-wrapper {
            flex-grow: 1;
            padding: 1.5rem 1rem;
            overflow-y: auto;
        }

        .menu-heading {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.05em;
            padding-left: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            color: #94A3B8;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.75rem 0.85rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }
        
        .sidebar-nav-link:hover {
            color: #FFFFFF;
            /* background-color: var(--bg-sidebar-hover); */
        }

        /* Efek Aktif Pintar menggunakan CSS Native (jika link ditambahkan class active) */
        .sidebar-nav-link.active, 
        .sidebar-nav-link[href="{{ request()->url() }}"] {
            color: #FFFFFF;
            background-color: var(--bg-sidebar-hover); /* Solid Brand Blue */
            font-weight: 600;
        }

        /* User Profile Block at Sidebar Bottom */
        .sidebar-footer-profile {
            padding: 1.25rem;
            border-top: 1px solid #1E293B;
            background-color: #0B0F19;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* 2. MAIN CONTENT AREA COMPONENTS */
        .main-content-wrapper {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0; /* Mencegah flexbox memecah layout tabel responsive */
        }

        /* Dynamic Content Topbar Header */
        .content-topbar {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            height: 70px;
            padding: 0 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Main Slot Wrapper */
        .page-body-container {
            padding: 2.5rem;
            flex-grow: 1;
        }

        /* Responsivitas untuk layar kecil */
        @media (max-width: 991.98px) {
            .sidebar-panel {
                transform: translateX(-100%);
            }
            .sidebar-panel.show {
                transform: translateX(0);
            }
            .main-content-wrapper {
                margin-left: 0;
            }
            .content-topbar {
                padding: 0 1.25rem;
            }
            .page-body-container {
                padding: 1.5rem 1.25rem;
            }
            .mobile-toggle-btn {
                display: flex !important;
            }
        }

        .mobile-toggle-btn {
            display: none;
            background: #F1F5F9;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
        }
    </style>
</head>
<body>

<div class="app-container">

    <aside class="sidebar-panel" id="sidebarMenu">
        <div class="sidebar-brand">
            <i class="bi bi-shield-check"></i>
            <span>EduGate</span>
        </div>
        
        <div class="sidebar-menu-wrapper">
            <nav class="nav flex-column">
                <div class="menu-heading mt-4">Data Utama</div>
                <a class="sidebar-nav-link" href="{{ route('students.index') }}">
                    <i class="bi bi-people fs-5"></i> <span>Data Induk Siswa</span>
                </a>
                <a class="sidebar-nav-link" href="{{ route('rooms.index') }}">
                    <i class="bi bi-building fs-5"></i> <span>Ruangan</span>
                </a>
                
                <div class="menu-heading mt-4">Manajemen Ujian</div>
                <a class="sidebar-nav-link" href="{{ route('examps.index') }}">
                    <i class="bi bi-calendar3 fs-5"></i> <span>Jadwal Ujian</span>
                </a>
                <a class="sidebar-nav-link" href="{{ route('placements.index') }}">
                    <i class="bi bi-person-bounding-box fs-5"></i> <span>Penempatan Peserta</span>
                </a>
                <a href="{{ route('reports.index') }}" class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> Rekap & Laporan
                </a>
            </nav>
        </div>

        @auth
        <div class="sidebar-footer-profile">
            <div class="d-flex align-items-center gap-2 min-w-0">
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; flex-shrink: 0; background-color: #334155 !important; font-size: 0.85rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white small fw-semibold mb-0 text-truncate">{{ Auth::user()->name }}</p>
                    <span class="text-muted" style="font-size: 0.75rem;">Administrator</span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-link p-1 text-danger text-decoration-none" title="Keluar dari Aplikasi">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <div class="main-content-wrapper">
        
        <header class="content-topbar">
            <button class="mobile-toggle-btn" type="button" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="d-none d-sm-block">
                <span class="text-muted small fw-medium">Portal Administrator</span>
                <span class="text-muted small mx-2">/</span>
                <span class="text-dark small fw-semibold">Sistem Kendali Presensi</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="w-2 h-2 rounded-circle bg-success d-inline-block" style="width: 8px; height: 8px;"></span>
                <span class="text-secondary" style="font-size: 0.8rem; font-weight: 500;">Server Connected</span>
            </div>
        </header>

        <main class="page-body-container">
            @yield('content')
        </main>
        
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebarMenu');
        sidebar.classList.toggle('show');
    }

    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebarMenu');
        const toggleBtn = document.querySelector('.mobile-toggle-btn');
        
        if (window.innerWidth <= 991.98) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>
</body>
</html>