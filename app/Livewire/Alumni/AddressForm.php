<?php

namespace App\Livewire\Alumni;

use App\Models\Alumni;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddressForm extends Component
{
    public $countries = null;
    public $provinces = null;
    public $regencies = null;
    public $districts = null;
    public $villages = null;
    public $alumni;
    
    public $myAddress;
    
    public $selectedCountry;
    public $selectedProvince;
    public $selectedRegency;
    public $selectedDistrict;
    public $selectedVillage;
    public $address;

    public function mount()
    {
        $this->countries = Country::select('name', 'id')->get();
        $this->provinces = Province::select('name', 'id')->get();
        $this->myAddress = Auth::user()->alumni;
        $this->selectedCountry = $this->myAddress->country_id;
        $this->address = $this->myAddress->address ?? '';

        if($this->myAddress->village_id)
        {
            $this->selectedProvince = $this->myAddress->village->district->regency->province_id;
            $this->selectedRegency = $this->myAddress->village->district->regency_id;
            $this->selectedDistrict = $this->myAddress->village->district_id;
            $this->selectedVillage = $this->myAddress->village_id;
            
            $this->regencies = Regency::where('province_id', $this->selectedProvince)->get();
            $this->districts = District::where('regency_id', $this->selectedRegency)->get();
            $this->villages = Village::where('district_id', $this->selectedDistrict)->get();
        }
    }
    
    public function updatedSelectedProvince($province)
    {
        $this->regencies = Regency::where('province_id', $province)->get();
        $this->selectedRegency = null;
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->districts = [];
        $this->villages = [];
    }
    
    public function updatedSelectedRegency($regency)
    {
        $this->districts = District::where('regency_id', $regency)->get();
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->villages = [];
    }
    
    public function updatedSelectedDistrict($district)
    {
        $this->villages = Village::where('district_id', $district)->get();
        $this->selectedVillage = null;
    }

    public function save()
    {
        // Validasi
        $rules = [
            'selectedCountry' => 'required',
            'address' => 'required'
        ];
    
        // Tambahkan validasi bersyarat untuk Indonesia (country_id = 1)
        if ($this->selectedCountry == 1) {
            $rules += [
                'selectedProvince' => 'required',
                'selectedRegency' => 'required',
                'selectedDistrict' => 'required',
                'selectedVillage' => 'required'
            ];
        }
    
        // Lakukan validasi
        $this->validate($rules);
    
        // Persiapkan data untuk update
        $updateData = [
            'country_id' => $this->selectedCountry,
            'address' => $this->address
        ];
    
        // Jika negara adalah Indonesia, tambahkan data wilayah
        if ($this->selectedCountry == 1) {
            $updateData += [
                'province_id' => $this->selectedProvince,
                'regency_id' => $this->selectedRegency,
                'district_id' => $this->selectedDistrict,
                'village_id' => $this->selectedVillage
            ];
        } else {
            // Jika bukan Indonesia, set wilayah menjadi null
            $updateData += [
                'province_id' => null,
                'regency_id' => null,
                'district_id' => null,
                'village_id' => null
            ];
        }
    
        // dd($updateData);
        // Update alamat
        $this->myAddress->update($updateData);
    
        // Tampilkan pesan sukses dan redirect
        session()->flash('success', 'Data berhasil diperbarui.');
        return redirect()->route('settings.identitas')->with('success', 'Alhamdulillah berhasil mengubah data!');
    }

    public function render()
    {
        return view('livewire.alumni.address-form');
    }
}
