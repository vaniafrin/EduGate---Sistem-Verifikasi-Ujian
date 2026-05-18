@extends('layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard Verifikasi Hari-H</h5>
                <span class="badge bg-light text-success">Total Terverifikasi: {{ $attendances->count() }} Siswa</span>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Waktu Verifikasi</th>
                            <th>Foto</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status AI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $key => $attendance)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->scanned_at)->format('d M Y - H:i:s') }}</td>
                            <td>
                                @if($attendance->student->photo_path)
                                    <img src="{{ asset('storage/' . $attendance->student->photo_path) }}" width="40" height="40" class="rounded-circle" style="object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $attendance->student->nisn }}</td>
                            <td><strong>{{ $attendance->student->nama }}</strong></td>
                            <td>{{ $attendance->student->kelas }}</td>
                            <td>
                                <span class="badge bg-success">Cocok (Score: {{ round($attendance->confidence_score, 2) }})</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada siswa yang terverifikasi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection