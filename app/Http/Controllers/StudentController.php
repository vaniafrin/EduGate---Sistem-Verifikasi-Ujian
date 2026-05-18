<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'nama' => 'required',
            'kelas' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rfid_uid' => 'required|unique:students,rfid_uid', 
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student_photos', 'public');
        }

        Student::create([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'photo_path' => $photoPath,
            'rfid_uid' => $request->rfid_uid, 
        ]);

        return redirect()->route('students.index')->with('success', 'Siswa dan RFID berhasil ditambahkan!');
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
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn,' . $student->id,
            'nama' => 'required',
            'kelas' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rfid_uid' => 'required|unique:students,rfid_uid,' . $student->id, 
        ]);

        $data = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ];

        
        if ($request->hasFile('photo')) {
            
            if ($student->photo_path && Storage::disk('public')->exists($student->photo_path)) {
                Storage::disk('public')->delete($student->photo_path);
            }
            
            $data['photo_path'] = $request->file('photo')->store('student_photos', 'public');
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // hapus file foto dari folder storage sebelum menghapus data di database
        if ($student->photo_path && Storage::disk('public')->exists($student->photo_path)) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil dihapus!');
    }
}