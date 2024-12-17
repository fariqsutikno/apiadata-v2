<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;

class VillagesController extends Controller
{
    public function index()
    {
        $villages = Village::all();
        return ['results' => $villages];
    }

    public function search(Request $request)
    {
        $villages = Village::where('name', 'LIKE', '%'.$request->input('term', '').'%')->get(['id', 'name as text']);
        return ['results' => $villages];
    }

    // public function search($keyword)
    // {
    //     $villages = Village::where('name', 'LIKE', '%'.$keyword.'%')->get(['id', 'name as text']);
    //     return ['results' => $villages];
    // }
}
