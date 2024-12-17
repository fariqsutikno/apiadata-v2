<?php

namespace App\Livewire\Alumni;

use App\Models\Alumni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SearchAlumni extends Component
{
    public $alumnis = '';
    public $search;
    public int $on_page = 5; 

    public function mount(){
        $this->alumnis = DB::table('alumnis')
        ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
        ->where('alumnis.gen_id', '=', Auth::user()->alumni->gen_id)
        ->select('alumnis.full_name', 'alumnis.photo_link', 'alumnis.nism', 'gens.name as gen_name')
        ->limit(10)
        ->get();
    }

    public function loadMore(): void  
    {  
        $this->on_page += 5;  
    }  

    public function updatedSearch($search)
    {
        // $this->alumni = $search;
        if ($search) {
            $keywords = array_filter(explode(' ', trim($search))); // Membersihkan input dan menghilangkan empty spaces
            
            if (empty($keywords)) {
                $this->alumnis = collect();
                return;
            }
        
            $query = DB::table('alumnis')
                ->join('gens', 'alumnis.gen_id', '=', 'gens.id')
                ->select('alumnis.full_name', 'alumnis.photo_link', 'alumnis.nism', 'gens.name as gen_name');
        
            if (count($keywords) > 1) {
                $lastKeyword = end($keywords);
                $nameKeywords = implode(' ', array_slice($keywords, 0, -1));
        
                // Menggunakan subquery untuk mengecek apakah kata terakhir match dengan gen.name
                $genExists = DB::table('gens')
                    ->where('name', 'like', '%' . $lastKeyword . '%')
                    ->exists();
        
                if ($genExists) {
                    // Mencari berdasarkan kombinasi nama alumni dan angkatan
                    $query->where('gens.name', 'like', '%' . $lastKeyword . '%')
                          ->where('alumnis.full_name', 'like', '%' . $nameKeywords . '%');
                } else {
                    // Mencari full string di nama alumni
                    $query->where('alumnis.full_name', 'like', '%' . $search . '%');
                }
            } else {
                // Untuk single keyword, cari di kedua tabel
                $query->where(function($q) use ($search) {
                    $q->where('gens.name', 'like', '%' . $search . '%')
                      ->orWhere('alumnis.full_name', 'like', '%' . $search . '%');
                });
            }
        
            $this->alumnis = $query->orderBy('gens.year', 'asc' , 'alumnis.full_name', 'asc')
                                  ->limit(100) // Membatasi hasil pencarian
                                  ->get();
        } else {
            $this->alumnis = collect();
        }
        
    }

    public function render()
    {
        return view('livewire.alumni.search-alumni');
    }
}
