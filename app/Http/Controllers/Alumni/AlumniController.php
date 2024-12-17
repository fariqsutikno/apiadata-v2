<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\UniversityAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{
    public function index() {
        $alumni = Auth::user()->alumni;
        
        $photoCard = '';

        if ($alumni->gen_id == '1') {
            $photoCard = 'gen/card30.svg';
        } elseif ($alumni->gen_id == '2') {
            $photoCard = 'gen/card31.svg';
        } elseif ($alumni->gen_id == '3') {
            $photoCard = 'gen/card32.svg';
        } elseif ($alumni->gen_id == '4') {
            $photoCard = 'gen/card33.svg';
        } else {
            $photoCard = ''; // Default image if no match
        }
        return view('home', compact('alumni', 'photoCard'));
    }

    public function search() {
        return view('alumni.search.index');
    }

    public function profile($kodeAlumni) {
        $alumni = Alumni::where('nism', '=', $kodeAlumni)->select('id', 'full_name', 'regency_id', 'province_id', 'country_id', 'address', 'drive_link', 'photo_link', 'whatsapp', 'linkedin', 'emergency_contact', 'gen_id')->with('gen', 'regency', 'province', 'country')->first();
        $myInterests = Alumni::find($alumni->id)->interests()->pluck('name');
        $myClasses = Alumni::find($alumni->id)->classes()->pluck('class');
        $myOrganizations = Alumni::find($alumni->id)
        ->organizations()
        ->select('name', 'logo', 'start', 'end', 'position')
        ->orderBy('end', 'desc')
        ->get();    
        // dd($myOrganizations);
        $myStudies = UniversityAlumni::where('alumni_id', '=', $alumni->id)->where('is_enrolled', 1)->get();
        return view('alumni.search.profile', compact('alumni', 'myInterests', 'myClasses', 'myOrganizations', 'myStudies'));
    }
}
