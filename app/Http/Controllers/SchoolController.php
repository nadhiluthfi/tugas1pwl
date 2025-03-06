<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua sekolah beserta data siswa terkait
        $schools = School::with('students')->get();
        return response()->json($schools);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
            'email'   => 'nullable|email'
        ]);

        // Membuat sekolah baru berdasarkan data yang telah divalidasi
        $school = School::create($validatedData);

        return response()->json($school, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mencari sekolah berdasarkan id, beserta data siswa terkait
        $school = School::with('students')->find($id);

        if (!$school) {
            return response()->json(['message' => 'School not found'], 404);
        }

        return response()->json($school);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari sekolah berdasarkan id
        $school = School::find($id);

        if (!$school) {
            return response()->json(['message' => 'School not found'], 404);
        }

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
            'email'   => 'nullable|email'
        ]);

        // Update data sekolah
        $school->update($validatedData);

        return response()->json($school);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari sekolah berdasarkan id
        $school = School::find($id);

        if (!$school) {
            return response()->json(['message' => 'School not found'], 404);
        }

        // Hapus sekolah
        $school->delete();

        return response()->json(['message' => 'School deleted successfully']);
    }

    /**
     * Get the student count for each school.
     */
    public function getStudentCount()
    {
        // Mengambil semua sekolah beserta jumlah siswa yang terkait
        $schools = School::withCount('students')->get();
        return response()->json($schools);
    }
}
