<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Program;
use App\Models\University;
use App\Models\Village;
use Illuminate\Http\Request;

class StudiController extends Controller
{
    public function getUniversity(Request $request)
    {
        $search = $request->get('q');
        $universities = University::where('name', 'like', "%{$search}%")->select('id', 'name as text')->get();
        
        return response()->json($universities);
    }
    
    public function getProgram(Request $request)
    {
        $search = $request->get('q');
        $university_id = $request->get('university_id');

        $programs = Program::where('university_id', 'like', "%{$university_id}%")
                    ->where('name', 'like', "%{$search}%")
                    ->select('id', 'name as text')
                    ->get();

        return response()->json($programs);
    }
}
