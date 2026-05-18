@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Tambah Ruangan</div>
            <div class="card-body">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" class="form-control" placeholder="Contoh: Lab Komputer 1" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Ruangan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Daftar Ruangan</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $key => $room)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $room->nama_ruangan }}</td>
                            <!-- <td>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td> -->
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('scanner', $room->id) }}" target="_blank" class="btn btn-warning btn-sm">Buka Scanner</a>
                                    <a href="{{ route('monitor.index', $room->id) }}" target="_blank" class="btn btn-info btn-sm text-white">Buka Monitor</a>

                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                                         @csrf
                                         @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection