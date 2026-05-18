<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Placement;
use App\Models\Room;
use App\Models\Examp;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // menampilkan halaman scanner
    public function index($room_id)
    {
        $room = Room::findOrFail($room_id);
        
        // mencari ujian yang sedang berlangsung
        $now = Carbon::now();
        $activeExamp= Examp::where('tanggal', $now->toDateString())
                          ->where('waktu_mulai', '<=', $now->toTimeString())
                          ->where('waktu_selesai', '>=', $now->toTimeString())
                          ->first();

        return view('scanner', compact('room', 'activeExamp'));
    }

    // mencari data siswa saat kartu ditap
    public function checkRfid($uid, $room_id)
    {
        $now = Carbon::now();
        
        // 1. cek ujian aktif
        $activeExamp= Examp::where('tanggal', $now->toDateString())
                          ->where('waktu_mulai', '<=', $now->toTimeString())
                          ->where('waktu_selesai', '>=', $now->toTimeString())
                          ->first();

        if (!$activeExamp) {
            return response()->json(['success' => false, 'message' => 'Tidak ada jadwal ujian aktif saat ini!']);
        }

        // 2. mencari siswa berdasarkan uid kartu
        $student = Student::where('rfid_uid', $uid)->first();
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Kartu tidak terdaftar!']);
        }

        // 3. cek alokasi siswa untuk ujian ini
        $placement = Placement::where('student_id', $student->id)
                              ->where('examp_id', $activeExamp->id)
                              ->first();

        if (!$placement) {
            return response()->json(['success' => false, 'message' => 'Anda tidak terdaftar di ujian ini!']);
        }

        if ($placement->room_id != $room_id) {
            $correctRoom = Room::find($placement->room_id);
            return response()->json([
                'success' => false, 
                'message' => 'RUANGAN SALAH! Anda seharusnya di ' . $correctRoom->nama_ruangan
            ]);
        }

        // jika semua ok, kirim data siswa untuk verifikasi wajah
        return response()->json([
            'success' => true,
            'nama' => $student->nama,
            'kelas' => $student->kelas,
            'photo_url' => asset('storage/' . $student->photo_path),
            'student_id' => $student->id
        ]);
    }

    // menyimpan absensi jika wajah cocok
    public function store(Request $request)
    {
        Attendance::create([
            'student_id' => $request->student_id,
            'scanned_at' => Carbon::now(),
            'status' => 'Valid',
            'confidence_score' => $request->score
        ]);

        return response()->json(['success' => true]);
    }

    public function dashboard()
    {
        // mengambil semua data kehadiran beserta relasi data siswanya, diurutkan dari yang terbaru
        $attendances = Attendance::with('student')->latest()->get();
        
        return view('dashboard', compact('attendances'));
    }
}
