@extends('layout')

@section('content')
<style>
    .saas-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); overflow: hidden; }
    .table-custom thead th { background-color: #F8FAFC; color: #64748B; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; padding: 1rem 1.5rem; border-bottom: 1px solid #E2E8F0; }
    .table-custom tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #F1F5F9; font-size: 0.875rem; }
    .badge-failed { background-color: #FEE2E2; color: #DC2626; font-weight: 600; }
    .badge-manual { background-color: #FFEDD5; color: #D97706; font-weight: 600; }
</style>

<div class="mb-4">
    <a href="{{ route('reports.index') }}" class="text-decoration-none small fw-medium"><i class="bi bi-arrow-left"></i> Kembali ke Pelaporan</a>
    <h4 class="fw-bold mt-2 mb-1" style="color: #0F172A;">🛡️ Audit Keamanan: Log Ketidaksesuaian</h4>
    <p class="text-muted small mb-0">Daftar siswa bypass verifikasi sistem atau terdeteksi gagal mencocokkan wajah.</p>
</div>

<div class="saas-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-borderless align-middle mb-0">
                <thead>
                    <tr>
                        <th>Waktu Kejadian</th>
                        <th>Siswa</th>
                        <th>Ujian</th>
                        <th>Metode Validasi</th>
                        <th>Status Verifikasi</th>
                        <th>Keterangan Audit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anomalies as $log)
                    <tr>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }} WIB</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $log->student->nama ?? 'N/A' }}</div>
                            <div class="text-muted small">NISN: {{ $log->student->nisn ?? '-' }} • Kelas: {{ $log->student->kelas ?? '-' }}</div>
                        </td>
                        <td>{{ $log->examp->mata_pelajaran ?? 'Ujian Dihapus' }}</td>
                        <td>
                            @if($log->verification_method == 'manual')
                                <span class="badge badge-manual rounded-pill px-2.5 py-1">VALIDASI MANUAL</span>
                            @else
                                <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">{{ strtoupper($log->verification_method) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($log->verification_status == 'failed')
                                <span class="badge badge-failed rounded-pill px-2.5 py-1"><i class="bi bi-x-circle-fill me-1"></i> GAGAL COCOK</span>
                            @else
                                <span class="badge bg-soft-success text-success rounded-pill px-2.5 py-1" style="background-color: #DCFCE7;">BERHASIL</span>
                            @endif
                        </td>
                        <td class="text-secondary italic">"{{ $log->notes ?? 'Tidak ada catatan khusus dari pengawas.' }}"</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check text-success fs-1 d-block mb-2"></i>
                            <span class="fw-medium text-dark d-block">Sistem Aman Terkendali</span>
                            Tidak ditemukan indikasi anomali atau intervensi manual pada sesi ujian sejauh ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection