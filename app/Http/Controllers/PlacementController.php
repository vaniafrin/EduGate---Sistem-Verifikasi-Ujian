<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placement;
use App\Models\Examp;
use App\Models\Room;
use App\Models\Student;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examps = Examp::all();
        $rooms = Room::all();
        $students = Student::orderBy('nama', 'asc')->get();
        
        // mengambil data alokasi yang sudah ada untuk ditampilkan di tabel
        $placements = Placement::with(['student', 'examp', 'room'])->latest()->get();

        return view('placements', compact('examps', 'rooms', 'students', 'placements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'examp_id' => 'required',
            'room_id' => 'required',
            'student_ids' => 'required|array',
        ]);

        foreach ($request->student_ids as $student_id) {
            // cek agar tidak ada duplikasi 
            Placement::updateOrCreate(
                ['student_id' => $student_id, 'examp_id' => $request->examp_id],
                ['room_id' => $request->room_id]
            );
        }

        return back()->with('success', 'Peserta berhasil dialokasikan ke ruangan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Placement $placement)
    {
        $placement->delete();
        return back()->with('success', 'Penempatan berhasil dihapus!');
    }
}
