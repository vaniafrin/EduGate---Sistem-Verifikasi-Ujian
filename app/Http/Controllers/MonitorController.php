<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Exam;
use App\Models\Placement;
use App\Models\Attendance;
use App\Models\Examp;
use Carbon\Carbon;

use Illuminate\Http\Request;

class MonitorController extends Controller
{
    
    public function index($room_id)
    {
        $room = Room::findOrFail($room_id);
        return view('index', compact('room'));
    }

    // mengirim data kehadiran untuk ditampilkan di monitor
    public function getData($room_id)
    {
        $now = Carbon::now();
        
        // cari ujian yang berlangsung
        $activeExamp = Examp::where('tanggal', $now->toDateString())
                          ->where('waktu_mulai', '<=', $now->toTimeString())
                          ->where('waktu_selesai', '>=', $now->toTimeString())
                          ->first();

        if (!$activeExamp) {
            return response()->json(['status' => 'offline', 'message' => 'Tidak ada ujian aktif saat ini di ruangan ini.']);
        }

        // cari siswa yang dialokasikan ke ruangan ini untuk ujian ini
        $placements = Placement::where('room_id', $room_id)
                               ->where('exam_id', $activeExamp->id)
                               ->pluck('student_id'); // Ambil ID siswanya saja
        
        $totalSiswa = $placements->count();

        // cari data presensi siswa-siswa  pada hari ini
        $attendances = Attendance::with('student')
            ->whereIn('student_id', $placements)
            ->whereDate('created_at', $now->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();

        $hadir = $attendances->count();
        $belumHadir = $totalSiswa - $hadir;

        // format data log verifikasi terakhir agar rapi dibaca oleh JavaScript
        $logs = $attendances->map(function($att) {
            return [
                'nama' => $att->student->nama,
                'kelas' => $att->student->kelas,
                'waktu' => $att->created_at->format('H:i:s'),
                'photo' => asset('storage/' . $att->student->photo_path)
            ];
        });

        return response()->json([
            'status' => 'online',
            'exam' => $activeExamp->mata_pelajaran . ' (' . $activeExamp->sesi . ')',
            'stats' => [
                'total' => $totalSiswa,
                'hadir' => $hadir,
                'belum' => $belumHadir
            ],
            'logs' => $logs
        ]);
    }
}
