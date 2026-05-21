<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Exam;
use App\Models\Placement;
use App\Models\Attendance;
use App\Models\Examp;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitorController extends Controller
{
    public function index($room_id)
    {
        $room = Room::findOrFail($room_id);
        return view('monitor', compact('room')); 
    }

    public function getData($room_id)
    {

        $now = Carbon::now('Asia/Jakarta');
        
        //cek ujian aktif di rooms
        $activeExamp = Examp::where('tanggal', $now->toDateString())
                          ->where('waktu_mulai', '<=', $now->toTimeString())
                          ->where('waktu_selesai', '>=', $now->toTimeString())
                          ->first();

        if (!$activeExamp) {
            return response()->json([
                'status' => 'offline', 
                'message' => 'Tidak ada ujian aktif saat ini di ruangan ini (Jam Server: ' . $now->format('H:i:s') . ')'
            ]);
        }

        //ambil data penempatan siswa
        $placements = Placement::with('student')
                               ->where('room_id', $room_id)
                               ->where('examp_id', $activeExamp->id)
                               ->get();
        
        $studentIds = $placements->pluck('student_id');

        // ambil data yang sudah hadir
        $attendances = Attendance::whereIn('student_id', $studentIds)
                                 ->whereDate('created_at', $now->toDateString())
                                 ->get()
                                 ->keyBy('student_id'); // Mempermudah pencocokan ID

        // peta status kehadiran
        $allStudents = $placements->map(function($place) use ($attendances) {
            $sudahHadir = $attendances->has($place->student_id);
            return [
                'nama' => $place->student->nama,
                'kelas' => $place->student->kelas,
                'photo' => asset('storage/' . $place->student->photo_path),
                'status' => $sudahHadir ? 'Hadir' : 'Belum Datang',
                'waktu' => $sudahHadir ? $attendances[$place->student_id]->created_at->format('H:i:s') : '-'
            ];
        });

        // recent log
        $recentLogs = Attendance::with('student')
                                ->whereIn('student_id', $studentIds)
                                ->whereDate('created_at', $now->toDateString())
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get()
                                ->map(function($att) {
                                    return [
                                        'nama' => $att->student->nama,
                                        'kelas' => $att->student->kelas,
                                        'waktu' => $att->created_at->format('H:i:s'),
                                        'photo' => asset('storage/' . $att->student->photo_path)
                                    ];
                                });

        $totalSiswa = $placements->count();
        $hadir = $attendances->count();
        $belumHadir = $totalSiswa - $hadir;

        return response()->json([
            'status' => 'online',
            'examp' => $activeExamp->mata_pelajaran . ' (' . $activeExamp->sesi . ')',
            'stats' => [
                'total' => $totalSiswa,
                'hadir' => $hadir,
                'belum' => $belumHadir
            ],
            'all_students' => $allStudents,
            'logs' => $recentLogs
        ]);
    }
}