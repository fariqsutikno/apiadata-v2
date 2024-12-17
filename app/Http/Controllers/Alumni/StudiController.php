<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Program;
use App\Models\University;
use App\Models\UniversityAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudiController extends Controller
{
    public function index() {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();

        $myStudies = UniversityAlumni::where('alumni_id', '=', $alumni->id)->where('is_enrolled', 1)->get(); 
        return view('alumni.settings.studi.index', compact('myStudies'));
    }

}
