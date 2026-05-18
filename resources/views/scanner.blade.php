@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h3 class="mb-0">Mesin Verifikasi: {{ $room->nama_ruangan }}</h3>
        @if($activeExamp)
            <p class="text-success fw-bold">Ujian Aktif: {{ $activeExamp->mata_pelajaran }} ({{ $activeExamp->sesi }})</p>
        @else
            <p class="text-danger fw-bold">STATUS: TIDAK ADA JADWAL AKTIF SAAT INI</p>
        @endif
        <hr>
        
        <div style="position: relative; display: inline-block;">
            <video id="webcam" width="600" height="450" autoplay muted class="border rounded shadow-sm bg-dark"></video>
            <canvas id="overlay" style="position: absolute; top: 0; left: 0;"></canvas>
        </div>

        <div id="status-box" class="alert alert-info mt-3">
            Silakan Tap Kartu ID Anda
        </div>
        <!-- <input type="text" id="rfid_input" style="opacity: 0; position: absolute;"> -->
        <input type="text" id="rfid_input" class="form-control w-50 mx-auto mt-3" placeholder="Atau ketik manual RFID di sini lalu tekan Enter...">
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm" id="student-info" style="display: none;">
            <div class="card-header bg-primary text-white">Data Peserta</div>
            <div class="card-body text-center">
                <img id="ref-photo" src="" class="img-thumbnail mb-3" width="150">
                <h4 id="res-nama"></h4>
                <p id="res-kelas" class="text-muted"></p>
                <hr>
                <div id="verify-status" class="fw-bold">Menunggu Verifikasi Wajah...</div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/face-api.min.js') }}"></script>
<script>
    const video = document.getElementById('webcam');
    const rfidInput = document.getElementById('rfid_input');
    let modelsLoaded = false;

    // 1. Load Model AI
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

    // 2. Deteksi Tapping Kartu
    document.addEventListener('click', () => rfidInput.focus()); // Jaga fokus tetap di input
    rfidInput.addEventListener('change', async (e) => {
        const uid = e.target.value;
        if (!uid) return;

        document.getElementById('status-box').innerHTML = "Mengecek Kartu...";
        
        // Cari siswa ke server
        const response = await fetch(`/check-rfid/${uid}/{{ $room->id }}`);
        const data = await response.json();

        if (data.success) {
            showStudent(data);
            verifyFace(data);
        } else {
            alert(data.message);
        }
        
        e.target.value = ''; // Reset input
    });

    function showStudent(data) {
        document.getElementById('student-info').style.display = 'block';
        document.getElementById('res-nama').innerText = data.nama;
        document.getElementById('res-kelas').innerText = data.kelas;
        document.getElementById('ref-photo').src = data.photo_url;
    }

    // 3. Bandingkan Wajah Webcam dengan Foto Profil
    async function verifyFace(student) {
        // Ambil descriptor dari foto profil (Referensi)
        const refImg = await faceapi.fetchImage(student.photo_url);
        const refResult = await faceapi.detectSingleFace(refImg).withFaceLandmarks().withFaceDescriptor();

        if (!refResult) {
            alert("Foto profil lama tidak jelas, sulit diverifikasi AI.");
            return;
        }

        const faceMatcher = new faceapi.FaceMatcher(refResult);

        // Scan wajah dari webcam selama 5 detik
        const scanInterval = setInterval(async () => {
            const detections = await faceapi.detectSingleFace(video).withFaceLandmarks().withFaceDescriptor();

            if (detections) {
                const match = faceMatcher.findBestMatch(detections.descriptor);
                
                // Jika tingkat kecocokan tinggi (semakin kecil angkanya semakin mirip, default < 0.6)
                if (match.distance < 0.5) {
                    clearInterval(scanInterval);
                    successVerification(student.student_id, match.distance);
                }
            }
        }, 500);
    }

    async function successVerification(id, score) {
        document.getElementById('verify-status').innerHTML = "<span class='text-success'>✓ WAJAH COCOK!</span>";
        document.getElementById('status-box').className = "alert alert-success mt-3";
        document.getElementById('status-box').innerText = "Presensi Berhasil!";

        // Simpan ke database
        await fetch('/attendance/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ student_id: id, score: score })
        });

        // Reset setelah 3 detik untuk siswa berikutnya
        setTimeout(() => location.reload(), 3000);
    }
</script>
@endsection