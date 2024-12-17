<div class="max-w-2xl mx-auto px-4">
    <form wire:submit.prevent="save" class="space-y-4">
        @csrf
        <!-- Universitas -->
        <div wire:ignore>
            <label class="text-sm mb-1 text-gray-700">Universitas <span class="text-red-500 text-sm">*</span></label>
            <select
                class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none select2-university"
                id="university" wire:model.live="selectedUniversity" required>
                @if ($dataStudiId)
                    <option value="{{ $selectedUniversity }}">{{ $selectedUniversityName }}</option>
                @endif
            </select>
            @error('selectedUniversity')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <p class="mt-2 text-xs text-primary">Tidak menemukan studi lanjutmu? Laporkan! <a href="https://wa.me/"
                    class="font-bold">Klik di sini</a></p>
        </div>

        <!-- Program Studi -->
        <div wire:ignore>
            <label class="text-sm mb-1 text-gray-700">Program Studi<span class="text-red-500 text-sm">*</span></label>
            <select
                class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none select2-program"
                id="program" wire:model.live="selectedProgram" required>
                @if ($dataStudiId)
                    <option value="{{ $selectedProgram }}">{{ $selectedProgramName }}</option>
                @endif
            </select>
            @error('selectedProgram')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        @if($dataMethod === 'create@studi' || $dataMethod === 'edit@studi')
            <!-- Waktu Mulai -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm mb-1 text-gray-700">Bulan Mulai<span class="text-red-500 text-sm">*</span></label>
                    <select wire:model.live="monthStart"
                        class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                        <option value="">Pilih Bulan</option>
                        @foreach ($months as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('monthStart')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="text-sm mb-1 text-gray-700">Tahun Mulai<span class="text-red-500 text-sm">*</span></label>
                    <select wire:model.live="yearStart"
                        class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                        <option value="">Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    @error('yearStart')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Status Kelanjutan Studi --}}
            <div class="space-y-2">
                <label class="text-sm mb-1 text-gray-700">Status Kelanjutan Studi<span class="text-red-500 text-sm">*</span></label>
                <div class="flex flex-row items-center justify-between">
                    @foreach ($statusOptions as $statusOption)
                        <div class="flex items-center">
                            <div class="relative">
                                <input type="radio" name="status" id="{{ $statusOption->name }}"
                                    value="{{ $statusOption->value }}" wire:model.live="completionStatus"
                                    class="peer appearance-none w-4 h-4 rounded-full border-2 border-gray-300 text-primary checked:border-primary checked:border-6 transition-all duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <label for="{{ $statusOption->name }}"
                                    class="ml-1 peer-checked:text-primary cursor-pointer select-none transition-colors duration-200">
                                    {{ $statusOption->label() }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('completionStatus')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tahun Berakhir Input --}}
            @if ($completionStatus && $completionStatus !== \App\Enums\CompletionStatus::SEDANG_BERJALAN->value)
                <!-- Waktu Berakhir -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm mb-1 text-gray-700">Bulan Selesai<span class="text-red-500 text-sm">*</span></label>
                        <select wire:model.live="monthEnd"
                            class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('monthEnd')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm mb-1 text-gray-700">Tahun Selesai<span class="text-red-500 text-sm">*</span></label>
                        <select wire:model.live="yearEnd"
                            class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('yearEnd')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        @endif


        @if($dataMethod === 'create@survey' || $dataMethod === 'edit@survey')
            <!-- Waktu Pendaftaran -->
            <div>
                <label class="text-sm mb-1 text-gray-700">Tahun Pendaftaran<span class="text-red-500 text-sm">*</span></label>
                <select wire:model.live="yearStart"
                    class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                    <option value="">Pilih Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                @error('yearStart')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endif

        {{-- Jalur Penerimaan Dropdown --}}
        <div>
            <label for="admission_path" class="block text-sm font-medium text-gray-700">
                Jalur Penerimaan<span class="text-red-500 text-sm">*</span>
            </label>
            <select wire:model.live="admissionPath" id="admission_path"
                class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                <option value="">Pilih Jalur</option>
                
                @foreach ($pathOptions as $pathOption)
                    <option value="{{ $pathOption->value }}">
                        {{ $pathOption->label() }}
                    </option>
                @endforeach
            </select>
            @error('admissionPath')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SNBT Score Input --}}
        @if ($admissionPath === \App\Enums\AdmissionPath::SNBT->value)
            <div>
                <label for="snbt_score" class="block text-sm font-medium text-gray-700">
                    SNBT Score<span class="text-red-500 text-sm">*</span>
                </label>
                <input type="number" wire:model="snbtScore" id="snbt_score" step="0.1" min="0"
                    max="1000"
                    class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                    placeholder="Masukkan skor SNBT" required />
                @error('snbtScore')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        @if($dataMethod === 'create@survey' || $dataMethod === 'edit@survey')
            {{-- Apakah Diterima Input --}}
            <div class="space-y-2">
                <label class="text-sm mb-1 text-gray-700">Apakah diterima?<span class="text-red-500 text-sm">*</span></label>
                <div class="flex flex-row items-center justify-start gap-6">
                        <div class="flex items-center">
                            <div class="relative">
                                <input type="radio" name="status" id="is_accepted_no"
                                    value="0" wire:model.live="isAccepted"
                                    class="peer appearance-none w-4 h-4 rounded-full border-2 border-gray-300 text-primary checked:border-primary checked:border-6 transition-all duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <label for="is_accepted_no"
                                    class="ml-1 peer-checked:text-primary cursor-pointer select-none transition-colors duration-200">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="relative">
                                <input type="radio" name="status" id="is_accepted_yes"
                                    value="1" wire:model.live="isAccepted"
                                    class="peer appearance-none w-4 h-4 rounded-full border-2 border-gray-300 text-primary checked:border-primary checked:border-6 transition-all duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <label for="is_accepted_yes"
                                    class="ml-1 peer-checked:text-primary cursor-pointer select-none transition-colors duration-200">
                                    Iya
                                </label>
                            </div>
                        </div>
                </div>
            </div>
        @endif

        {{-- Prioritas Dropdown --}}
        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700">
                Skala Prioritas?<span class="text-red-500 text-sm">*</span>
            </label>
            <select wire:model.live="priority" id="priority"
                class="w-full px-4 py-2 mt-1 rounded-xl bg-white border focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none" required>
                <option value="">Pilih Prioritas</option>
                    <option value="1">Plan A (Rencana Awal. Harapan awal banget)</option>
                    <option value="2">Plan B (Cuma jadi pilihan kedua. Tapi boleh la)</option>
                    <option value="3">Plan C (Ga berharap banget si. Buat cadangan akhir.)</option>
                    <option value="4">Plan D (Opsi terakhir. Pasrah aja deh yang penting kuliah)</option>
            </select>
            @error('priority')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if($dataMethod === 'create@studi' || $dataMethod === 'edit@studi')        
            {{-- Sumber Pendanaan Input --}}
            <div class="space-y-2">
                <label class="text-sm mb-1 text-gray-700">Sumber Pendanaan<span class="text-red-500 text-sm">*</span></label>
                <div class="flex flex-row items-center justify-between">
                    @foreach ($fundingOptions as $fundingOption)
                        <div class="flex items-center">
                            <div class="relative">
                                <input type="radio" name="fundingSource" id="{{ $fundingOption->name }}"
                                    value="{{ $fundingOption->value }}" wire:model.live="fundingSource"
                                    class="peer appearance-none w-4 h-4 rounded-full border-2 border-gray-300 text-primary checked:border-primary checked:border-6 transition-all duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <label for="{{ $fundingOption->name }}"
                                    class="ml-1 peer-checked:text-primary cursor-pointer select-none transition-colors duration-200">
                                    {{ $fundingOption->label() }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    @error('fundingSource')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            {{-- Is_Visible Input --}}
            <div class="pb-1"></div>
            <div class="backdrop-blur-md bg-white/20 border border-white/30 rounded-xl px-4 py-3 shadow-lg">
                <div class="flex items-center gap-3 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-bold text-sm text-primary">Pengaturan Privasi</h3>
                </div>
                
                <label class="flex items-center space-x-4 group cursor-pointer p-2 hover:bg-white/10 rounded-lg transition-all duration-300"> 
                    <div class="relative">
                        <input 
                            type="checkbox"
                            name="is_visible"
                            class="peer hidden"
                            wire:model="isVisible"
                        >
                        <div class="w-14 h-7 bg-gray-400/30 backdrop-blur-sm peer-checked:bg-primary/80 rounded-full transition-all duration-300"></div>
                        <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-all duration-300 peer-checked:translate-x-7 flex items-center justify-center">
                            <!-- Icon Mata Terbuka -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-600 transition-transform duration-300 peer-checked:hidden [.peer:checked~div>&]:hidden" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            <!-- Icon Mata Tertutup -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-primary transition-transform duration-300 hidden [.peer:checked~div>&]:block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 group-hover:text-primary transition-colors duration-300">
                            Sembunyikan dari pencarian
                        </span>
                    </div>
                </label>
            </div>
        @endif
        <!-- Submit Button -->
        <div>
            <x-alumni.submit-button type="submit"> {{ $dataStudiId ? 'Update' : 'Tambah' }}</x-alumni.submit-button>
        </div>
    </form>
    @if($dataStudiId)
        <form wire:submit.prevent="delete" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-block text-center px-4 mt-4 py-2 rounded-xl bg-red-400 w-full hover:opacity-90 transition-all text-white ml-auto"
                data-confirm-delete="true">
                Hapus Data
            </button>
        </form>
    @endif
</div>

@push('script')
    <script>
        $(document).ready(function() {
            // console.log('Data sudah siap');

            // Select2 untuk Provinsi dengan Remote Data
            $('#university').select2({
                placeholder: 'Pilih Universitas',
                minimumInputLength: 4,
                ajax: {
                    url: '{{ route('api.studi.getuniversity') }}',
                    // url: '/api/v1/studi/get-university',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 10) < data.count_filtered
                            }
                        };
                    },
                    cache: true
                }
            }).on('change', function() {
                @this.set('selectedUniversity', $(this).val());
            });

            function initProgramSelect2() {
                $('#program').select2({
                    placeholder: 'Pilih Program',
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ route('api.studi.getprogram') }}',
                        // url: '/api/v1/studi/get-program',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var queryParameters = {
                                q: params.term,
                                university_id: $('#university').val()
                            }

                            return queryParameters;
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data,
                                pagination: {
                                    more: (params.page * 10) < data.count_filtered
                                }
                            };
                        },
                        cache: true
                    }
                }).on('change', function() {
                    @this.set('selectedProgram', $(this).val());
                    //console log selected program
                });
            }

            function toggleProgramSelect() {
                if ($('#university').val()) {
                    $('#program').show(); // Tampilkan #program jika #university terisi
                } else {
                    $('#program').hide(); // Sembunyikan #program jika #university kosong
                }
            }

            initProgramSelect2();
            // toggleProgramSelect();
        });
    </script>
@endpush
