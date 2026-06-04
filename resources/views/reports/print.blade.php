<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran - {{ $examp->mata_pelajaran }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; font-family: sans-serif; color: #000; padding: 20px; }
        .table th { background-color: #f1f5f9 !important; color: #000 !important; font-size: 12px; text-transform: uppercase; }
        .table td { font-size: 12px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<div class="text-center mb-4">
    <h3 class="fw-bold mb-1">LAPORAN KEHADIRAN UJIAN</h3>
    <h5 class="text-muted fw-normal">Sistem Akademik EduGate</h5>
</div>

<div class="row mb-4" style="font-size: 14px;">
    <div class="col-6">
        <table class="table table-sm table-borderless">
            <tr><td width="150" class="fw-bold">Mata Pelajaran</td><td>: {{ $examp->mata_pelajaran }}</td></tr>
            <tr><td class="fw-bold">Sesi Pelaksanaan</td><td>: {{ $examp->sesi ?? '1 / Pagi' }}</td></tr>
        </table>
    </div>
    <div class="col-6">
        <table class="table table-sm table-borderless">
            <tr><td width="150" class="fw-bold">Hari / Tanggal</td><td>: {{ \Carbon\Carbon::parse($examp->tanggal)->format('d F Y') }}</td></tr>
            <tr><td class="fw-bold">Waktu Jam</td><td>: {{ $examp->waktu_mulai }} - {{ $examp->waktu_selesai }} WIB</td></tr>
        </table>
    </div>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr class="text-center">
            <th width="50">No</th>
            <th width="120">NISN</th>
            <th>Nama Lengkap Siswa</th>
            <th width="100">Kelas</th>
            <th width="120">Waktu Absen</th>
            <th width="100">Status</th>
            <th>Metode Audit</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $index => $row)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $row->student->nisn ?? '-' }}</td>
            <td>{{ $row->student->nama ?? 'N/A' }}</td>
            <td class="text-center">{{ $row->student->kelas ?? '-' }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($row->created_at)->format('H:i:s') }} WIB</td>
            <td class="text-center fw-bold">{{ strtoupper($row->status) }}</td>
            <td class="small text-muted">
                {{ strtoupper($row->verification_method) }} ({{ strtoupper($row->verification_status) }})
                @if($row->notes) <br><span class="text-danger">*{{ $row->notes }}</span> @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-4">Belum ada data kehadiran terekam untuk sesi ujian ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-end mt-5 pt-4">
    <div class="text-center" style="width: 250px;">
        <p class="mb-5">Pengawas Ruang Ujian,</p>
        <div class="border-bottom w-100 mb-1"></div>
        <p class="text-muted small">NIP / Kode Pengawas</p>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => { window.print(); }, 500);
    });
</script>
</body>
</html>