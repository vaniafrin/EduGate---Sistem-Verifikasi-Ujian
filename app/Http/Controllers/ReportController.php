<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Examp;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $examps = Examp::orderBy('tanggal', 'desc')->get();
        return view('reports.index', compact('examps'));
    }

    public function anomalyLog()
    {
        $anomalies = Attendance::with(['student', 'examp']) 
            ->where('verification_method', 'manual')
            ->orWhere('verification_status', 'failed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reports.anomalies', compact('anomalies'));
    }

    public function exportCsv($examp_id)
    {
        $examp = Examp::findOrFail($examp_id);
        $attendances = Attendance::with('student')->where('examp_id', $examp_id)->get();

        $filename = "Laporan_Kehadiran_" . str_replace(' ', '_', $examp->mata_pelajaran) . "_" . Carbon::now()->format('Ymd') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Peringkat/No', 'NISN', 'Nama Siswa', 'Kelas', 'Jam Scan', 'Status', 'Metode Verifikasi', 'Status Verifikasi', 'Keterangan'];

        $callback = function() use($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $key => $attendance) {
                fputcsv($file, [
                    $key + 1,
                    $attendance->student->nisn ?? '-',
                    $attendance->student->nama ?? '-',
                    $attendance->student->kelas ?? '-',
                    Carbon::parse($attendance->created_at)->format('H:i:s'),
                    strtoupper($attendance->status),
                    strtoupper($attendance->verification_method),
                    strtoupper($attendance->verification_status),
                    $attendance->notes ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printPdf($examp_id)
    {
        $examp = Examp::findOrFail($examp_id);
        $attendances = Attendance::with('student')->where('examp_id', $examp_id)->get();

        return view('reports.print', compact('examp', 'attendances'));
    }
}
