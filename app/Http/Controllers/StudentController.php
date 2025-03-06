<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data siswa beserta informasi sekolah terkait
        $students = Student::with('school')->get();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data siswa
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:students,email',
            'school_id' => 'required|exists:schools,id'
        ]);

        // Membuat data siswa baru
        $student = Student::create($validatedData);

        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mencari data siswa berdasarkan id beserta informasi sekolah terkait
        $student = Student::with('school')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari data siswa berdasarkan id
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:students,email,'.$student->id,
            'school_id' => 'required|exists:schools,id'
        ]);

        // Update data siswa
        $student->update($validatedData);

        return response()->json($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data siswa berdasarkan id
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Hapus data siswa
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }

    /**
     * Get the school for the specified student.
     */
    public function getSchool(string $id)
    {
        // Cari data siswa berdasarkan ID
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Mengambil data sekolah terkait dari relasi school
        $school = $student->school;

        if (!$school) {
            return response()->json(['message' => 'School not found for this student'], 404);
        }

        return response()->json($school);
    }
}
