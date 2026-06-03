<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Ujian - {{ $room->nama_ruangan }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Palet UI Modern SaaS (Slate & Soft Tones) */
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            letter-spacing: -0.01em;
        }

        /* Styling Kartu Utama */
        .scanner-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        /* Container Kamera Modern */
        .video-container {
            position: relative;
            display: inline-block;
            border-radius: 16px;
            overflow: hidden;
            border: 6px solid #F1F5F9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background-color: #0F172A; /* Antisipasi saat kamera memuat */
            transition: border-color 0.3s ease;
        }
        
        .video-container.active-scan {
            border-color: #BFDBFE; /* Berubah biru muda saat scan */
        }

        #webcam {
            display: block;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Custom Soft Alerts */
        .alert-soft-info {
            background-color: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }
        .alert-soft-warning {
            background-color: #FEF3C7;
            color: #B45309;
            border: 1px solid #FDE68A;
        }
        .alert-soft-success {
            background-color: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }
        .alert-soft-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        /* Input Field Tersembunyi tapi Elegan */
        .rfid-input {
            background-color: #F8FAFC;
            border: 2px dashed #CBD5E1;
            color: var(--text-sub);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }
        .rfid-input:focus {
            outline: none;
            border-color: #93C5FD;
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .rfid-input::placeholder {
            color: #94A3B8;
        }

        /* Kartu Profil Siswa */
        .profile-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .profile-header {
            background-color: #F8FAFC;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            color: var(--text-sub);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .img-profile-wrapper {
            width: 140px;
            height: 140px;
            margin: 0 auto;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #E2E8F0, #F8FAFC);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .img-profile-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--bg-surface);
        }
        
        .verification-box {
            background-color: #F8FAFC;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center align-items-stretch g-4">
        
        <div class="col-lg-7 text-center">
            <div class="scanner-card h-100 d-flex flex-column justify-content-center align-items-center">
                
                <h2 class="fs-4 fw-bold mb-1" style="color: var(--text-main);">Mesin Verifikasi: {{ $room->nama_ruangan }}</h2>
                
                @if($activeExamp)
                    <div class="d-inline-flex align-items-center gap-2 mt-2 px-3 py-1 bg-success bg-opacity-10 text-success rounded-pill fw-semibold border border-success border-opacity-25" style="font-size: 0.875rem;">
                        <span class="spinner-grow spinner-grow-sm text-success" role="status" aria-hidden="true"></span>
                        Ujian Aktif: {{ $activeExamp->mata_pelajaran }} ({{ $activeExamp->sesi }})
                    </div>
                @else
                    <div class="alert alert-soft-warning fw-semibold d-inline-block px-4 py-2 mt-2 rounded-pill shadow-sm" style="font-size: 0.875rem;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> STATUS: TIDAK ADA JADWAL AKTIF SAAT INI
                    </div>
                @endif
                
                <hr class="w-100 my-4" style="border-color: var(--border-color);">
                
                <div class="video-container" id="video-wrapper">
                    <video id="webcam" width="560" height="420" autoplay muted></video>
                    <canvas id="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                </div>

                <div id="status-box" class="alert alert-soft-info mt-4 w-75 fs-6 fw-semibold shadow-sm rounded-3">
                    <i class="bi bi-credit-card-2-front me-2"></i> Silakan Tap Kartu ID Anda
                </div>
                
                <input type="text" id="rfid_input" class="form-control rfid-input w-75 mx-auto mt-2 text-center" placeholder="Posisikan kursor di sini untuk tap kartu RFID..." autocomplete="off">
                
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="profile-card" id="student-info" style="display: none;">
                <div class="profile-header">
                    <i class="bi bi-person-badge me-2"></i> Identitas Peserta Ujian
                </div>
                <div class="card-body text-center p-4 d-flex flex-column">
                    
                    <div class="img-profile-wrapper mb-4">
                        <img id="ref-photo" src="" alt="Foto Siswa">
                    </div>
                    
                    <h4 id="res-nama" class="fw-bold fs-5 mb-1" style="color: var(--text-main);"></h4>
                    
                    <div class="d-flex justify-content-center gap-2 mt-2 mb-4">
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-medium">
                            NISN: <span id="res-nisn"></span>
                        </span>
                        <span id="res-kelas" class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-medium"></span>
                    </div>
                    
                    <div class="verification-box w-100 text-center">
                        <div id="verify-status" class="fw-semibold" style="font-size: 0.875rem;">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            Menganalisis wajah peserta...
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/face-api.min.js') }}"></script>
<script>
    const video = document.getElementById('webcam');
    const rfidInput = document.getElementById('rfid_input');
    const videoWrapper = document.getElementById('video-wrapper');
    let modelsLoaded = false;

    // load model
    Promise.all([
        faceapi.nets.ssdMobilenetv1.loadFromUri('/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/models')
    ]).then(startVideo);

    function startVideo() {
        navigator.mediaDevices.getUserMedia({ video: {} })
            .then(stream => { 
                video.srcObject = stream;
                modelsLoaded = true;
                rfidInput.focus(); // Fokus ke input RFID
            });
    }

    // detect kartu
    document.addEventListener('click', () => rfidInput.focus()); 
    
    rfidInput.addEventListener('change', async (e) => {
        const uid = e.target.value;
        if (!uid) return;

        const statusBox = document.getElementById('status-box');
        statusBox.className = "alert alert-soft-warning mt-4 w-75 fs-6 fw-semibold shadow-sm rounded-3";
        statusBox.innerHTML = "<span class='spinner-border spinner-border-sm me-2'></span> Membaca Data RFID...";
        
        const response = await fetch(`/check-rfid/${uid}/{{ $room->id }}`);
        const data = await response.json();

        if (data.success) {
            showStudent(data);
            verifyFace(data);
            videoWrapper.classList.add('active-scan'); // Memberi efek highlight biru pada kamera
        } else {
            alert(data.message);
            statusBox.className = "alert alert-soft-info mt-4 w-75 fs-6 fw-semibold shadow-sm rounded-3";
            statusBox.innerHTML = "<i class='bi bi-credit-card-2-front me-2'></i> Silakan Tap Kartu ID Anda";
        }
        
        e.target.value = ''; 
    });

    function showStudent(data) {
        document.getElementById('student-info').style.display = 'flex';
        document.getElementById('res-nama').innerText = data.nama;
        document.getElementById('res-nisn').innerText = data.nisn;
        document.getElementById('res-kelas').innerText = data.kelas;
        document.getElementById('ref-photo').src = data.photo_url;
    }

    // sinkronisasi wajah
    async function verifyFace(student) {
        const refImg = await faceapi.fetchImage(student.photo_url);
        const refResult = await faceapi.detectSingleFace(refImg).withFaceLandmarks().withFaceDescriptor();

        if (!refResult) {
            alert("Foto profil lama tidak jelas, sulit diverifikasi AI.");
            videoWrapper.classList.remove('active-scan');
            return;
        }
        
        const distanceThreshold = 0.45;
        const faceMatcher = new faceapi.FaceMatcher(refResult, distanceThreshold);

        const scanInterval = setInterval(async () => {
            const detections = await faceapi.detectSingleFace(video).withFaceLandmarks().withFaceDescriptor();

            const verifyStatus = document.getElementById('verify-status');

            if (detections) {
                const match = faceMatcher.findBestMatch(detections.descriptor);
                
                if (match.label !== "unknown") {
                    clearInterval(scanInterval);
                    successVerification(student.student_id, match.distance);
                } else {
                    verifyStatus.innerHTML = 
                        "<span class='text-danger'><i class='bi bi-x-circle-fill me-1'></i> Wajah tidak cocok! (Skor: " + match.distance.toFixed(2) + ")</span>";
                }
            } else {
                verifyStatus.innerHTML = 
                    "<span class='text-warning' style='color: #D97706 !important;'><i class='bi bi-search me-1'></i> Mencari wajah di kamera...</span>";
            }
        }, 500);
    }

    async function successVerification(id, score) {
        document.getElementById('verify-status').innerHTML = "<span class='text-success fs-6 fw-bold'><i class='bi bi-check-circle-fill me-1'></i> WAJAH TERVALIDASI</span>";
        
        const statusBox = document.getElementById('status-box');
        statusBox.className = "alert alert-soft-success mt-4 w-75 fs-5 fw-bold shadow-sm rounded-3";
        statusBox.innerHTML = "<i class='bi bi-check-all me-2'></i> Presensi Berhasil!";
        
        videoWrapper.classList.remove('active-scan');
        videoWrapper.style.borderColor = "#BBF7D0";

        await fetch('/attendance/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ student_id: id, score: score })
        });
        
        setTimeout(() => location.reload(), 3000);
    }
</script>
</body>
</html>