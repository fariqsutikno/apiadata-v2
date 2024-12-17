<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Survey;
use App\Models\UniversityAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index() {
        $alumni= Auth::user()->alumni;
        $surveyFirst = Survey::where('alumni_id', '=', $alumni->id)->count();
        return view('alumni.survey.index', compact('surveyFirst'));
    }
    public function showFirst() {
        $univ_factor = [
            'reputasi_akreditasi' => 'Reputasi dan akreditasi kampus',
            'lokasi' => 'Lokasi kampus',
            'biaya' => 'Biaya kuliah',
            'ketersediaan_jurusan' => 'Ketersediaan jurusan yang diinginkan',
            'dosen' => 'Dosen pengajar',
            'kurikulum' => 'Kurikulum kampus', 
            'fasilitas' => 'Fasilitas kampus',
            'lingkungan' => 'Lingkungan kampus',
            'rekomendasi' => 'Rekomendasi dari keluarga atau teman',
            'realistis' => 'Realistis',
            'lainnya' => 'Lainnya'
        ];        

        $program_factor = [
            'minat_bakat' => 'Minat dan bakat',
            'prospek_kerja' => 'Prospek kerja',
            'saran_keluarga_teman' => 'Saran dari keluarga atau teman',
            'ketersediaan_jurusan' => 'Ketersediaan jurusan di kampus yang diinginkan',
            'realistis' => 'Realistis',
            'lainnya' => 'Lainnya',
        ];

        $activity = [
            'organisasi' => 'Organisasi (BEM, HIMA, UKM, dll)',
            'kampus_mengajar' => 'Kampus Mengajar',
            'magang_msib' => 'Magang MSIB',
            'sib' => 'Studi Independen Bersertifikat (SIB)',
            'pmm' => 'Pertukaran Mahasiswa Merdeka (PMM)',
            'wirausaha_merdeka' => 'Wirausaha Merdeka',
            'iisma' => 'IISMA',
            'praktisi_mengajar' => 'Praktisi Mengajar',
            'bangkit' => 'Bangkit',
            'asistensi_dosen' => 'Asistensi Dosen',
            'asisten_laboratorium' => 'Asisten Laboratorium',
            'lainnya' => 'Lainnya',
        ];

        $pia_impact =[
            'info_tim_edu' => 'Informasi dari tim edu',
            'seminar_studi_lanjut' => 'Seminar studi lanjut dan pengembangan diri',
            'kerjasama_bimbel' => 'Kerjasama dengan bimbel',
            'kurikulum_karakter' => 'Kurikulum pembelajaran dan pembentukan karakter',
            'partisipasi_organisasi' => 'Partisipasi dalam organisasi',
            'kesaktian_ijazah' => 'Kesaktian Ijazah IM atau berkas tazkiah tertentu',
            'tidak_ada' => 'Tidak ada',
            'lainnya' => 'Lainnya',
        ];

        return view('alumni.survey.first', compact('univ_factor', 'program_factor', 'activity', 'pia_impact'));
    }
    public function storeFirst(Request $request) {
        $alumni = Auth::user()->alumni->id;
        $request->validate([
            'univ_factor' => 'required',
            'program_factor' => 'required',
            'activity' => 'required',
            'pia_impact' => 'required',
            'kritik' => 'required'
        ]);

        Survey::create([
            'alumni_id' => $alumni,
            'univ_factor' => $request->univ_factor,
            'program_factor' => $request->program_factor,
            'activity' => $request->activity,
            'pia_impact' => $request->pia_impact,
            'kritik' => $request->kritik,
        ]);

        return redirect()->route('survey.index')->with('success', 'Terima kasih sudah mengisi!');
    }

    public function listSecond()
    {
        $alumni = Alumni::where('nism', '=', Auth::user()->alumni->nism)->select('id')->first();

        $myStudies = UniversityAlumni::where('alumni_id', '=', $alumni->id)->where('is_enrolled', 0)->get(); 
        return view('alumni.survey.listStudi', compact('myStudies'));
    }
}