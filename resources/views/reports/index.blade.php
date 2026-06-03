@extends('layout')

@section('content')
<style>
    .saas-card {
        background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05); overflow: hidden;
    }
    .saas-card-header {
        background-color: #FFFFFF; border-bottom: 1px solid #E2E8F0; padding: 1.25rem 1.5rem;
    }
    .table-custom thead th {
        background-color: #F8FAFC; color: #64748B; font-weight: 600; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.5rem; border-bottom: 1px solid #E2E8F0;
    }
    .table-custom tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #F1F5F9; font-size: 0.875rem; color: #0F172A; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: #0F172A;">Rekapitulasi & Pelaporan</h4>
        <p class="text-muted small mb-0">Unduh data kehadiran serta pantau keamanan jalannya ujian.</p>
    </div>
    <a href="{{ route('reports.anomalies') }}" class="btn btn-outline-danger fw-semibold px-3 py-2 rounded-3 text-decoration-none d-flex align-items-center gap-2">
        <i class="bi bi-shield-exclamation"></i> Lihat Log Anomali
    </a>
</div>

<div class="saas-card">
    <div class="saas-card-header">
        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text text-primary me-2"></i>Pilih Laporan Berdasarkan Ujian</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-borderless align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Sesi</th>
                        <th>Tanggal Ujian</th>
                        <th class="text-end" width="300">Opsi Cetak Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examps as $examp)
                    <tr>
                        <td class="fw-bold text-dark">{{ $examp->mata_pelajaran }}</td>
                        <td><span class="badge bg-light text-secondary border px-2 py-1">{{ $examp->sesi ?? 'Sesi -' }}</span></td>
                        <td><i class="bi bi-calendar-event text-muted me-1"></i> {{ \Carbon\Carbon::parse($examp->tanggal)->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('reports.excel', $examp->id) }}" class="btn btn-sm btn-light border text-success fw-medium">
                                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Excel (.csv)
                                </a>
                                <a href="{{ route('reports.pdf', $examp->id) }}" target="_blank" class="btn btn-sm btn-light border text-danger fw-medium">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak / PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Belum ada rekam jadwal ujian untuk dilaporkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection