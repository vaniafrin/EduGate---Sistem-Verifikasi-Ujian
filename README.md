<div align="center">

  # 🎓 EduGate
  **Sistem Informasi Manajemen Ujian & Absensi Pintar Berbasis Web**

  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
  [![Bootstrap](https://img.shields.io/badge/Bootstrap_5-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
</div>

---

## 💡 Tentang Project

Sistem ujian konvensional seringkali dihadapkan pada masalah inefisiensi administratif, kesalahan penempatan ruangan, hingga rentannya celah kecurangan seperti joki ujian. **EduGate** hadir sebagai solusi mutakhir untuk mendigitalisasi dan mengamankan seluruh ekosistem tersebut.

EduGate bukan sekadar pendataan biasa. Sistem ini memadukan **Kemudahan Manajemen Data (CRUD)** dengan **Teknologi Keamanan Biometrik & Hardware**. Dengan implementasi RFID dan Face Verification (Verifikasi Wajah), EduGate menjamin 100% integritas kehadiran peserta ujian secara *real-time* dan mencatat setiap anomali yang terjadi di lapangan.

## ✨ Fitur Unggulan

### 🛡️ Smart Security & Attendance
* **Dual-Layer Authentication:** Validasi kehadiran tingkat tinggi. Siswa melakukan *tap* kartu RFID untuk memverifikasi ruangan, dilanjutkan dengan pemindaian wajah (*Face Verification*) untuk mengonfirmasi identitas asli peserta.
* **Anomaly Detection System:** Sistem keamanan cerdas yang otomatis memblokir akses dan mencatat "Log Anomali" berwarna merah apabila mendeteksi siswa yang salah memasuki ruangan ujian atau menggunakan kartu yang tidak terdaftar.
* **Real-time Monitoring:** Dashboard *live-tracking* bagi administrator untuk memantau arus kehadiran siswa yang sedang masuk ke ruang ujian detik itu juga.

### ⚡ Efisiensi Administratif
* **Interactive Room Allocation:** Proses pembagian ruangan siswa yang ditenagai oleh AJAX (Fetch API). Admin dapat memfilter kelas dan menempatkan puluhan siswa sekaligus menggunakan fitur *Select-All* tanpa perlu *reload* halaman.
* **Smart UI/UX:** Dilengkapi dengan notifikasi *Auto-Dismiss* yang bersih, serta desain antarmuka responsif yang ramah pengguna.
* **Dynamic Scheduling:** Pengaturan mata pelajaran, sesi ujian, tanggal, dan durasi pengerjaan yang tersistematis.

### 📊 Laporan & Arsip
* **One-Click PDF Export:** Menghasilkan rekapitulasi kehadiran per ruangan secara instan. Laporan mencakup data NISN, waktu absen yang presisi, status validasi metode audit, dan siap untuk dicetak sebagai dokumen legal sekolah.

---

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan kombinasi arsitektur modern yang tangguh:
- **Backend:** Laravel (PHP 8.x)
- **Database:** MySQL
- **Frontend:** Bootstrap 5, Bootstrap Icons, Vanilla JavaScript (DOM & Fetch API)
- **Utilitas:** Carbon (Manipulasi Waktu/Timezone)

---

## 🚀 Alur Kerja Sistem (System Workflow)

1. **Tahap Persiapan:** Admin menginput data Master (Siswa, Foto Wajah, UID RFID, dan Ruangan).
2. **Tahap Penjadwalan:** Admin membuat Jadwal Ujian dan mengalokasikan Siswa ke Ruangan masing-masing.
3. **Tahap Pelaksanaan:** Siswa melakukan *scanning* di depan ruangan. Sistem memvalidasi UID kartu $\rightarrow$ Memvalidasi Ruangan $\rightarrow$ Memvalidasi Wajah.
4. **Tahap Pelaporan:** Pengawas mencetak hasil kehadiran (PDF) melalui sistem setelah ujian selesai.


