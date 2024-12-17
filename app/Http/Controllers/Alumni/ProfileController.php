<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\ClassAlumni;
use App\Models\Classroom;
use App\Models\District;
use App\Models\Interest;
use App\Models\InterestAlumni;
use App\Models\Organization;
use App\Models\OrganizationAlumni;
use App\Models\Program;
use App\Models\Regency;
use App\Models\University;
use App\Models\UniversityAlumni;
use App\Models\Village;
use App\Services\EncryptionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function index() {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id', 'nisn', 'nism', 'full_name', 'drive_link', 'photo_link', 'whatsapp', 'linkedin', 'gen_id')->with('gen')->first();
        $myInterests = Alumni::find($alumni->id)->interests()->pluck('name');
        $myClasses = Alumni::find($alumni->id)->classes()->pluck('class');
        $myOrganizations = Alumni::find($alumni->id)
        ->organizations()
        ->select('name', 'logo', 'start', 'end', 'position', 'slug')
        ->orderBy('end', 'desc')
        ->get();    
        // dd($myOrganizations);
        $myStudies = UniversityAlumni::where('alumni_id', '=', $alumni->id)->where('is_enrolled', 1)->get();
        // dd($myStudies);
        return view('alumni.settings.index', compact('alumni', 'myInterests', 'myClasses', 'myOrganizations', 'myStudies'));
    }

    public function editIdentitas() {
        $alumni = Auth::user()->alumni;

        return view('alumni.settings.identitas', compact(['alumni']));
    }

    public function updateIdentitas(Request $request) {
        DB::beginTransaction();
        $activeTab = $request->tab;
        try {
            
            switch($activeTab) {
                case 'tab1':
                    $this->updateTab1($request);
                    break;
                case 'tab2':
                    $this->updateTab2($request);
                    break;
                case 'tab3':
                    $this->updateTab3($request);
                    break;
                case 'tab4':
                    $this->updateTab4($request);
                    break;
                case 'tab5':
                    $this->updateTab5($request);
                    break;
                case 'tab6':
                    $this->updateTab6($request);
                    break;
            }
            
            DB::commit();
            return redirect()->back()
                            ->with([
                                'success' => 'Data berhasil diperbarui',
                                'tab' => $activeTab 
                            ])
                           ->withFragment('#'.$activeTab);
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with([
                            'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
                            'tab' => $activeTab
                            ])
                           ->withFragment('#'.$activeTab);
        }
    }

    private function updateTab1(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'arabic_name' => 'required',
            'alias' => 'nullable',
            'birth_place' => 'required',
            'birth_date' => 'required|before:01/01/2008',
        ]);

        return Alumni::where('nism', Auth::user()->nism)->update($validated);
    }

    private function updateTab2(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|numeric',
            'nisn' => 'required|numeric',
            'passport_number' => 'nullable|min:6|max:12',
        ]);

        $encryptedNik = $this->encryptionService->encrypt($request->nik);
        $encryptedPassportNumber = $this->encryptionService->encrypt($request->passport_number);
        // dd($validated);

        return Alumni::where('nism', Auth::user()->nism)->update([
            'nisn' => $request->nisn,
            'nik' => $encryptedNik,
            'passport_number' => $encryptedPassportNumber,
        ]);
    }

    private function updateTab3(Request $request)
    {
        $validated = $request->validate([
            'father_name' => 'required',
            'father_status' => 'required',
            'mother_name' => 'required',
            'mother_status' => 'required',
        ]);

        $encryptedMotherName = $this->encryptionService->encrypt($request->mother_name);

        return Alumni::where('nism', Auth::user()->nism)->update([
            'father_name' => $request->father_name,
            'father_status' => $request->father_status,
            'mother_name' => $encryptedMotherName,
            'mother_status' => $request->mother_status,
        ]);
    }

    private function updateTab4(Request $request)
    {
        
    }

    private function updateTab5(Request $request)
    {
        $validated = $request->validate([
            'whatsapp' => 'required|numeric',
            'emergency_contact' => 'required|numeric',
            'email' => 'required|email',
            'linkedin' => 'nullable|string', 
        ]);

        // Melakukan update pada model Alumni
        return Alumni::where('nism', Auth::user()->nism)->update($validated);
    }

    private function updateTab6(Request $request)
    {
        $validated = $request->validate([
            'ma_average' => 'required|numeric',
            'im_average' => 'required|numeric',
        ]);

        return Alumni::where('nism', Auth::user()->nism)->update($validated);
    }
    
    public function showKebijakanPrivasi() {
        // $universities = University::select('id', 'name')->get();
        // $cities = Regency::select('id', 'name')->get();
        // dd($cities);
        return view('alumni.settings.privacy');
    }
}
