<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\ClassAlumni;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatAkademikController extends Controller
{
    public function index() {
        $alumni = Auth::user()->alumni;
        $classrooms = ClassAlumni::join('classrooms', 'class_alumni.class_id', '=', 'classrooms.id')
        ->where('class_alumni.alumni_id', $alumni->id)
        ->select('classrooms.class', 'classrooms.teacher', 'classrooms.year')
        ->orderBy('classrooms.year', 'asc')
        ->get();
    
        return view('alumni.settings.akademik.index', compact(['alumni', 'classrooms']));
    }

    public function edit() {
        $classes = Classroom::all();

        $alumni = Auth::user()->alumni;

        $myClasses = ClassAlumni::where('alumni_id', '=', $alumni->id)->pluck('class_id')->toArray();

        return view('alumni.settings.akademik.edit', compact('classes', 'myClasses'));
    }

    public function update(Request $request) 
    {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();

        $selectedClasses = $request->input('classes', []);
        
        $alumni->classes()->sync($selectedClasses);
        
        return redirect()->route('settings.akademik.index')->with('success', 'Data kelas berhasil diperbarui');

    }
}
