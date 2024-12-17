<?php

namespace App\Livewire;

use App\Models\District;
use App\Models\Program;
use App\Models\Province;
use App\Models\Regency;
use App\Models\University;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class NameAlumni extends Component
{

    public $village;
    public $selectedVillage = '';

    public function fetchData($val)
    {
        dd($val);
        // $villages = Village::where('name', 'like', '%'.$val.'%')->get();

        // return $villages;
    }

    public function render()
    {

        return view('livewire.name-alumni');

    }
    
}
