<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examp;

class ExampController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Mengurutkan jadwal dari yang paling dekat
        $examps = Examp::orderBy('tanggal', 'desc')->orderBy('waktu_mulai', 'asc')->get();
        return view('examps', compact('examps'));
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
            'mata_pelajaran' => 'required',
            'sesi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        Examp::create($request->all());
        return back()->with('success', 'Jadwal Ujian berhasil ditambahkan!');
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
        $examp = Examp::findOrFail($id);
        return view('examps.edit', compact('examp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string|max:255',
            'sesi'           => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'waktu_mulai'     => 'required',
            'waktu_selesai'   => 'required|after:waktu_mulai',
        ]);

        $examp = Examp::findOrFail($id);
        
        $examp->update([
            'mata_pelajaran' => $request->mata_pelajaran,
            'sesi'           => $request->sesi,
            'tanggal'         => $request->tanggal,
            'waktu_mulai'     => $request->waktu_mulai,
            'waktu_selesai'   => $request->waktu_selesai,
        ]);

        return redirect()->route('examps.index')->with('success', 'Jadwal ujian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examp $examp)
    {
        $examp->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
