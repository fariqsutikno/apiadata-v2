<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\InterestAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user()->alumni;
        return view('alumni.community.index', compact('user'));
    }

    public function category($category)
    {
        if($category == 'byMinat'){
            $header = 'By  Minat';
            $title = ' Passion-mu, Koneksi-mu!';
            $description = ' Temukan teman-teman dengan minat yang sama! Siapa tahu kamu bisa menemukan partner kolaborasi impianmu!';
            $data = DB::table('interest_alumni')
            ->join('interests', 'interest_alumni.interest_id', '=', 'interests.id')
            ->select(
                'interests.name',
                'interests.slug',
                DB::raw('COUNT(interest_alumni.alumni_id) as total_alumni')
            )
            ->groupBy('interests.id', 'interests.name', 'interests.slug')
            ->orderBy('total_alumni', 'desc')
            ->get();

        }else if($category == 'byMajma'){
            $header = 'By Majma';
            $title = 'Solidaritas Satu Majma';
            $description = 'Pengen cari relasi dari alumni yang pernah satu majma dulu? Atau dari majma lain? Di sini, kamu bisa nemuin berbagai anggota majma di zamannya, biar bisa nostalgia, atau bahkan kolaborasi bikin project keren bareng! Siapa tau bisa bikin gebrakan baru, kayak dulu!';
            $data = DB::table('organization_alumni')
            ->join('organizations', 'organization_alumni.organization_id', '=', 'organizations.id')
            ->select(
                'organizations.name',
                'organizations.slug',
                DB::raw('COUNT(organization_alumni.alumni_id) as total_alumni')
            )
            ->groupBy('organizations.id', 'organizations.name', 'organizations.slug')
            ->orderBy('total_alumni', 'desc')
            ->get();

        }else if($category == 'byDomisili'){
            $header = 'By Domisili';
            $title = 'Koneksi Dekat, Impact Besar!';
            $description = ' Temukan alumni di kotamu! Gampang banget buat ngobrol langsung, ketemuan buat majlas, atau kolaborasi dalam projek lokal.';
            $data = DB::table('regencies')
            ->join('alumnis', 'regencies.id', '=', 'alumnis.regency_id')
            ->select(
                'regencies.name',
                'regencies.id as slug',
                DB::raw('COUNT(alumnis.regency_id) as total_alumni')
            )
            ->groupBy('regencies.name', 'regencies.id')
            ->orderBy('total_alumni', 'desc')
            ->get();

        }else if($category == 'byKampus'){
            $header = 'By Kampus';
            $title = 'Satu Almamater, Satu Jaringan!';
            $description = 'Temukan senior, junior, dan teman seperjuangan yang sedang berjuang di kampus yang sama. Tukar tips kuliah, cari mentor, atau kolaborasi bikin project bareng!';
            $data = DB::table('university_alumni')
            ->join('universities', 'university_alumni.university_id', '=', 'universities.id')
            ->select(
                'universities.name',
                'universities.id as slug',
                DB::raw('COUNT(university_alumni.alumni_id) as total_alumni')
            )
            ->groupBy('universities.name', 'universities.id')
            ->orderBy('total_alumni', 'desc')
            ->where('university_alumni.is_visible', true)
            ->get();

        }else if($category == 'byRanahStudi'){
            $header = 'By Ranah Studi';
            $title = 'Satu Bidang, Sejuta Peluang!';
            $description = 'Koneksikan dirimu dengan alumni yang memiliki latar belakang studi yang sama! Tukar pikiran, cari mentor, atau kolaborasi dalam project yang relevan dengan bidangmu. Eksplorasi peluang karir dan kembangkan potensimu bersama!';
            $data = DB::table('program_categories')
            ->select([
                'program_categories.name',
                DB::raw('COUNT(DISTINCT university_alumni.alumni_id) as total_alumni'),
                'program_categories.slug'
            ])
            ->leftJoin('programs', 'program_categories.id', '=', 'programs.category_id')
            ->leftJoin('university_alumni', 'programs.id', '=', 'university_alumni.program_id')
            ->groupBy('program_categories.id', 'program_categories.name', 'program_categories.slug')
            ->where('university_alumni.is_visible', true)
            ->get();
            
        }else if($category == 'byLokasiKampus'){
            $header = 'By Lokasi Kampus';
            $title = 'Lokasi Kampus';
            $description = 'Kuliah di kota yang sama? Yuk, kenalan sama irsyadi lainnya yang juga kuliah di sini! Bisa sharing info kampus, tempat nongkrong asik, atau bahkan cari teman untuk jalan-jalan bareng.';
            $data = DB::table('university_alumni')
            ->join('programs', 'university_alumni.program_id', '=', 'programs.id')
            ->leftJoin('regencies', 'programs.regency_id', '=', 'regencies.id')
            ->leftJoin('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->join('countries', 'programs.country_id', '=', 'countries.id')
            ->select([
                DB::raw('COALESCE(regencies.name, countries.name) as name'),
                DB::raw('COUNT(DISTINCT university_alumni.alumni_id) as total_alumni'),
                DB::raw('COALESCE(programs.regency_id, programs.country_id) as slug')
            ])
            ->groupBy('regencies.id', 'regencies.name', 'countries.id', 'countries.name', 'programs.regency_id', 'programs.country_id')
            ->orderBy('total_alumni', 'desc')
            ->where('university_alumni.is_visible', true)
            ->get();
        }else{
            return redirect()->route('community')->with('error', 'Kategori komunitas tidak ditemukan!');
        }

        return view('alumni.community.category', compact('header', 'category', 'title', 'description', 'data'));
    }

    public function profile($category, $community)
    {

        if($category == 'byMinat'){
            $title = DB::table('interests')->where('slug', $community)->value('name');
            $data = DB::table('alumnis')
            ->select(
                'alumnis.full_name as alumni_name', 
                'alumnis.whatsapp as alumni_whatsapp', 
                'gens.name as angkatan',
            )
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('interest_alumni', 'alumnis.id', '=', 'interest_alumni.alumni_id')
            ->join('interests', 'interest_alumni.interest_id', '=', 'interests.id')
            ->where('interests.slug', $community)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');

        }else if($category == 'byMajma'){
            $title = DB::table('organizations')->where('slug', $community)->value('name');
            $data = DB::table('alumnis')
            ->select(
                'alumnis.full_name as alumni_name', 
                'alumnis.whatsapp as alumni_whatsapp', 
                'gens.name as angkatan',
            )
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('organization_alumni', 'alumnis.id', '=', 'organization_alumni.alumni_id')
            ->join('organizations', 'organization_alumni.organization_id', '=', 'organizations.id')
            ->where('organizations.slug', $community)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');
            
        }else if($category == 'byDomisili'){
            $title = DB::table('regencies')->where('id', $community)->value('name');
            $data = DB::table('alumnis')
            ->select(
                'alumnis.full_name as alumni_name', 
                'alumnis.whatsapp as alumni_whatsapp', 
                'gens.name as angkatan',
            )
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('regencies', 'alumnis.regency_id', '=', 'regencies.id')
            ->where('regencies.id', $community)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');
            

        }else if($category == 'byKampus'){
            $title = DB::table('universities')->where('id', $community)->value('name');
            $data = DB::table('alumnis')
            ->select(
                'alumnis.full_name as alumni_name', 
                'alumnis.whatsapp as alumni_whatsapp', 
                'gens.name as angkatan',
            )
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('university_alumni', 'alumnis.id', '=', 'university_alumni.alumni_id')
            ->join('universities', 'university_alumni.university_id', '=', 'universities.id')
            ->where('universities.id', $community)
            ->where('university_alumni.is_visible', true)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');
            

        }else if($category == 'byRanahStudi'){
            $title = DB::table('program_categories')->where('slug', $community)->value('name');
            $data = DB::table('alumnis')
            ->select([
                'alumnis.full_name as alumni_name',
                'alumnis.whatsapp as alumni_whatsapp',
                'gens.name as angkatan',
            ])
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('university_alumni', 'alumnis.id', '=', 'university_alumni.alumni_id')
            ->join('programs', 'university_alumni.program_id', '=', 'programs.id')
            ->join('program_categories', 'programs.category_id', '=', 'program_categories.id')
            ->where('program_categories.slug', $community)
            ->where('university_alumni.is_visible', true)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');
            
        }else if($category == 'byLokasiKampus'){
            $slugLength = strlen($community);

            if ($slugLength === 4) {
                $title = DB::table('regencies')->where('id', $community)->value('name');
            } elseif ($slugLength === 1) {
                $title = DB::table('countries')->where('id', $community)->value('name');
            } else {
                $title = '[Data Invalid]'; 
            }
            $data = DB::table('alumnis')
            ->select([
                'alumnis.full_name as alumni_name',
                'alumnis.whatsapp as alumni_whatsapp',
                'gens.name as angkatan',
            ])
            ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
            ->join('university_alumni', 'alumnis.id', '=', 'university_alumni.alumni_id')
            ->join('programs', 'university_alumni.program_id', '=', 'programs.id')
            ->leftJoin('regencies', 'programs.regency_id', '=', 'regencies.id')
            ->leftJoin('countries', 'programs.country_id', '=', 'countries.id')
            ->where(function($query) use ($community) {
                $query->where('regencies.id', $community)
                      ->orWhere('countries.id', $community);
            })
            ->where('university_alumni.is_visible', true)
            ->orderBy('alumni_name')
            ->get()
            ->groupBy('angkatan');
            
        }else{
            return redirect()->route('community')->with('error', 'Kategori komunitas tidak ditemukan!');
        }

        if($data->isEmpty()){
            return redirect()->route('community')->with('error', 'Gagal menemukan komunitas!');             
        }

        return view('alumni.community.profile', compact('title', 'category', 'community', 'data'));
    }
}
