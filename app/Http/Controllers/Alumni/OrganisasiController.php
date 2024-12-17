<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Organization;
use App\Models\OrganizationAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganisasiController extends Controller
{
    public function __construct()
    {
        $this->alumni = Auth::user()->alumni;
    }

    public function index()
    {
        // dd($this->alumni->id);
        $organizations = OrganizationAlumni::where('alumni_id', $this->alumni->id)->with('organization')->get();
        return view('alumni.settings.organisasi.index', compact('organizations'));
    }

    public function create()
    {
        $organizations = Organization::select('id', 'name')->get();
        return view('alumni.settings.organisasi.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        try {
            $currentYear = date('Y');
            
            $validated = $request->validate([
                'organization_id' => [
                    'required',
                    'numeric',
                    'exists:organizations,id',
                ],
                'start' => [
                    'required',
                    'numeric',
                    'min:2018',
                    "max:{$currentYear}",
                    'lte:end'
                ],
                'end' => [
                    'required',
                    'numeric', 
                    'min:2018',
                    "max:{$currentYear}",
                    'gte:start'
                ],
                'position' => 'required',
            ]);
        
            $create = OrganizationAlumni::create([
                'alumni_id' => $this->alumni->id, 
                'organization_id' => $validated['organization_id'],
                'start' => $validated['start'],
                'end' => $validated['end'],
                'position' => $validated['position'],
            ]); 
            
            alert()->success('Alhamdulillah','Berhasil menambahkan data');
            return redirect()->route('settings.organisasi.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Masukin datanya yang bener wak! Pastiin tahunnya bener, dan semua field udah keisi');
        }
    }    

    public function edit($id)
    {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();
        $organizations = Organization::select('name', 'id')->get();
        $myOrganization = OrganizationAlumni::where('alumni_id', $this->alumni->id)->where('id', $id)->first();

        // Cek jika data tidak ditemukan
        if (!$myOrganization) {
            alert()->error('Oopss!', 'Data tidak ditemukan');
            return redirect()->route('settings.organisasi.index');
        }
        
        // $title = 'Sohihan ni mau dihapus?';
        // $text = "";
        // confirmDelete($title, $text);

        return view('alumni.settings.organisasi.edit', compact('organizations', 'myOrganization'));
    }

    public function update(Request $request, $id)
    {
        try{
            $currentYear = date('Y');
            $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();
            
            $validated = $request->validate([
                'organization_id' => [
                    'required',
                    'numeric',
                    'exists:organizations,id',
                ],
                'start' => [
                    'required',
                    'numeric',
                    'min:2018',
                    "max:{$currentYear}",
                    'lte:end'
                ],
                'end' => [
                    'required',
                    'numeric', 
                    'min:2018',
                    "max:{$currentYear}",
                    'gte:start'
                ],
                'position' => 'required',
            ]);
        
            $myOrganization = OrganizationAlumni::where('alumni_id', $this->alumni->id)->where('id', $id)->update($validated);
            
            alert()->success('Alhamdulillah','Berhasil mengubah data');
            return redirect()->route('settings.organisasi.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: '. $e);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = OrganizationAlumni::where('alumni_id', $this->alumni->id)
                ->where('id', $id)
                ->delete();
            
            if ($deleted) {
                return response()->json(['message' => 'Berhasil menghapus data'], 200);
            } else {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        } catch(\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
