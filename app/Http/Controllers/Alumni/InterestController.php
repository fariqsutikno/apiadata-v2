<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Interest;
use App\Models\InterestAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function index() {
        $alumni = Auth::user()->alumni->id;
        $myInterests = InterestAlumni::where('alumni_id', '=', $alumni)->get();

        return view('alumni.settings.interest.index', compact('myInterests'));
    }

    public function edit() {
        $interests = Interest::all();

        $alumni = Auth::user()->alumni->id;

        $myInterests = InterestAlumni::where('alumni_id', '=', $alumni)->pluck('interest_id')->toArray();

        return view('alumni.settings.interest.edit', compact('interests', 'myInterests'));
    }

    public function update(Request $request) {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();

        $selectedInterests = $request->input('interests', []);
        
        $alumni->interests()->sync($selectedInterests);
        
        return redirect()->route('settings')->with('success', 'Data minat berhasil diperbarui');

    }
}
