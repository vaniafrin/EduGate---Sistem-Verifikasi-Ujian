@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">Tambah Jadwal Ujian</div>
            <div class="card-body">
                <form action="{{ route('examps.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control" placeholder="Kimia / Bahasa Indonesia" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sesi</label>
                        <input type="text" name="sesi" class="form-control" placeholder="Sesi 1 / Pagi">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="waktu_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="waktu_selesai" class="form-control" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success px-4">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Jadwal Ujian Terdaftar</div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Sesi</th>
                            <th>Hari/Tanggal</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examps as $examp)
                        <tr>
                            <td><strong>{{ $examp->mata_pelajaran }}</strong></td>
                            <td>{{ $examp->sesi }}</td>
                            <td>{{ \Carbon\Carbon::parse($examp->tanggal)->format('d M Y') }}</td>
                            <td>{{ $examp->waktu_mulai }} - {{ $examp->waktu_selesai }} WIB</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $examp->id }}">
                                    Edit
                                </button>
    
                                <form action="{{ route('examps.destroy', $examp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</button>
                                </form>

                                <div class="modal fade" id="editModal{{ $examp->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $examp->id }}" aria-hidden="true">
                                     <div class="modal-dialog">
                                            <div class="modal-content">
                
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title fw-bold text-dark" id="editModalLabel{{ $examp->id }}">✏️ Edit Jadwal Ujian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                
                                                <form action="{{ route('examps.update', $examp->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                    
                                <div class="modal-body text-start">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Mata Pelajaran</label>
                                        <input type="text" name="mata_pelajaran" class="form-control" value="{{ $examp->mata_pelajaran }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sesi Ujian</label>
                                        <input type="text" name="sesi" class="form-control" value="{{ $examp->sesi }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Ujian</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ $examp->tanggal }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Waktu Mulai</label>
                                        <input type="time" name="waktu_mulai" class="form-control" value="{{ $examp->waktu_mulai }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Waktu Selesai</label>
                                        <input type="time" name="waktu_selesai" class="form-control" value="{{ $examp->waktu_selesai }}" required> 
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success fw-bold">Simpan Perubahan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
    </td>
                            <!-- <td>
                                <form action="{{ route('examps.destroy', $examp->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </td> -->
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection