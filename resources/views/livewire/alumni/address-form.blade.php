<div class="bg-white border-2 border-gray-700/30 rounded-3xl p-6 backdrop-blur-xl mb-4 shadow-lg">
    <h2 class="text-2xl font-semibold mb-4 text-primary">Alamat</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <input type="hidden" name="tab" value="tab4">

        <div class="space-y-4">
            {{-- Negara --}}
            <div class="space-y-4">
                <div class="relative">
                    <label class="text-sm text-black">Negara <span class="text-red-500">*</span></label>
                    <select 
                    class="w-full px-4 py-3 rounded-xl border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none" 
                    wire:model.live="selectedCountry">
                        <option value="" @if(!$selectedCountry) selected @endif>Pilih Negara</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ ($country->id == $myAddress->country_id) ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedCountry')
                        <span class="invalid-feedback text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($selectedCountry == 1)                
                @if ($selectedProvince || $provinces && count($provinces) > 0)
                    {{-- Provinsi --}}
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-sm text-black">Provinsi <span class="text-red-500">*</span></label>
                            <select class="w-full px-4 py-3 rounded-xl border border-gray-700 disabled:text-gray-300 disabled:border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none" wire:model.live="selectedProvince">
                                <option value="" >Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ ($province->id == $myAddress->province_id) ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedProvince')
                                <span class="invalid-feedback text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                @endif

                @if ($myAddress->regency_id || $regencies && count($regencies) > 0)
                    {{-- Kab/Kota --}}
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-sm text-black">Kab/Kota <span class="text-red-500">*</span></label>
                            <select 
                            wire:key="{{ $selectedProvince }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-700 disabled:text-gray-300 disabled:border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none" 
                            wire:model.live="selectedRegency" 
                            @if(!$selectedProvince) disabled @endif
                            >
                                <option value="" @if(!$selectedProvince) selected @endif>Pilih Kab/Kota</option>
                                @foreach($regencies as $regency)
                                    <option value="{{ $regency->id }}" {{ ($regency->id == $selectedProvince) ? 'selected' : '' }}>
                                        {{ $regency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedRegency')
                                <span class="invalid-feedback text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                @if ($myAddress->district_id || $districts && count($districts) > 0)
                    {{-- Kecamatan --}}
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-sm text-black">Kecamatan <span class="text-red-500">*</span></label>
                            <select 
                            wire:key="{{ $selectedRegency }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-700 disabled:text-gray-300 disabled:border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none" 
                            wire:model.live="selectedDistrict" 
                            @if(!$selectedRegency) disabled @endif
                            >
                                <option value="" @if(!$selectedRegency) selected @endif>Pilih Kecamatan</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ ($district->id == $selectedRegency) ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedDistrict')
                                <span class="invalid-feedback text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                @if ($myAddress->village_id || $villages && count($villages) > 0)
                    {{-- Kelurahan / Desa --}}
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-sm text-black disabled:text-gray-300">Kelurahan / Desa <span class="text-red-500">*</span></label>
                            <select
                                wire:key="{{ $selectedDistrict }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-700 disabled:text-gray-300 disabled:border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none" 
                                wire:model.live="selectedVillage"
                                @if(!$selectedDistrict) disabled @endif
                            >
                                <option value="" @if(!$selectedDistrict) selected @endif>Pilih Kelurahan / Desa</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}" {{ ($village->id == $selectedDistrict) ? 'selected' : '' }}>
                                        {{ $village->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedVillage')
                                <span class="invalid-feedback text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
            @endif
    
            <div class="space-y-2">
                <label class="text-sm text-black">Alamat Lengkap <span class="text-red-500">*</span></label>
                <div class="relative" x-data="{ charCount: 0 }">
                    <textarea 
                        id="address" 
                        rows="6" 
                        maxlength="500"
                        x-on:input="charCount = $event.target.value.length"
                        x-init="charCount = $el.value.length"
                        class="w-full px-4 py-3 rounded-xl border border-gray-700 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all resize-none"
                        wire:model.live="address"
                    >{{$myAddress->address}}</textarea>
                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                        <span x-text="charCount"></span>/500
                    </div>
                </div>
                @error('address')
                    <span class="invalid-feedback text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
        </div>
    </form>
</div>
