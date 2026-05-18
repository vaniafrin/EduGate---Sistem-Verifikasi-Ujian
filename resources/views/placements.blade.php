@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('placements.store') }}" method="POST">
            @csrf
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">Alokasi Peserta ke Ruangan Ujian</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Mata Pelajaran (Jadwal)</label>
                            <select name="examp_id" class="form-select" required>
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($examps as $examp)
                                    <option value="{{ $examp->id }}">{{ $examp->mata_pelajaran }} ({{ $examp->sesi }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Ruangan Ujian</label>
                            <select name="room_id" class="form-select" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h5>Pilih Siswa:</h5>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead class="sticky-top bg-white">
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>NISN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox"></td>
                                    <td>{{ $student->nama }}</td>
                                    <td>{{ $student->kelas }}</td>
                                    <td>{{ $student->nisn }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Proses Alokasi Peserta</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Data Penempatan Saat Ini</div>
            <div class="card-body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Ujian</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($placements as $p)
                        <tr>
                            <td>{{ $p->student->nama }}</td>
                            <td>{{ $p->examp->mata_pelajaran }}</td>
                            <td>{{ $p->room->nama_ruangan }}</td>
                            <td>
                                <form action="{{ route('placements.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Batal</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Fitur Check All
    document.getElementById('checkAll').onclick = function() {
        var checkboxes = document.querySelectorAll('.student-checkbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
@endsection