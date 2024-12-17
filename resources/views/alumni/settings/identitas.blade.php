<x-alumni.child-layout>
    <x-alumni.header href="{{ route('settings') }}" title="Identitas Diri" subtitle="Pusat Profil"></x-alumni.header>

    <!-- Tab Navigation -->
    <div class="px-4 pt-2">
        <div class="flex flex-wrap gap-2 mb-4">
            <a href="#tab1" id="tab1-btn"
                class="tab-button py-2 px-4 text-sm font-medium rounded-full bg-primary text-white hover:bg-secondary hover:text-white transition-colors">Data
                Pribadi</a>
            <a href="#tab2" id="tab2-btn"
                class="tab-button py-2 px-4 text-sm font-medium rounded-full bg-white text-primary hover:bg-secondary hover:text-white transition-colors">Nomor
                Identitas</a>
            <a href="#tab3" id="tab3-btn"
                class="tab-button py-2 px-4 text-sm font-medium rounded-full bg-white text-primary hover:bg-secondary hover:text-white transition-colors">Data
                Orang Tua</a>
            <a href="#tab4" id="tab4-btn"
                class="tab-button py-2 px-4 text-sm font-medium rounded-full bg-white text-primary hover:bg-secondary hover:text-white transition-colors">Alamat</a>
            <a href="#tab5" id="tab5-btn"
                class="tab-button py-2 px-4 text-sm font-medium rounded-full bg-white text-primary hover:bg-secondary hover:text-white transition-colors">Kontak</a>
        </div>


        <div id="tab1" class="tab-content">
            <div class="bg-white border-2 border-gray-700/30 rounded-3xl p-6 backdrop-blur-xl shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 text-primary">Identitas</h2>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <form action="{{ route('settings.identitas.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="tab" value="tab1">
                    <!-- Tab Content -->
                    <x-alumni.input-text label="Nama Lengkap (Latin)" value="{{ $alumni->full_name }}" name="full_name"
                        type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Nama Lengkap (Arab)" value="{{ $alumni->arabic_name }}"
                        name="arabic_name" type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Nama Panggilan" value="{{ $alumni->alias }}" name="alias"
                        type="text"></x-alumni.input-text>

                    <x-alumni.input-text label="Tempat Lahir" value="{{ $alumni->birth_place }}" name="birth_place"
                        type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Tanggal Lahir" value="{{ $alumni->birth_date }}" name="birth_date"
                        type="date" :required="true"></x-alumni.input-text>

                    <div class="flex justify-between">
                        <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
                    </div>
                </form>
            </div>
        </div>
        <div id="tab2" class="tab-content hidden">
            <div class="bg-white border-2 border-gray-700/30 rounded-3xl p-6 backdrop-blur-xl shadow-lg">
                <!-- Tab Content -->
                <h2 class="text-2xl font-semibold mb-4 text-primary">Nomor Identitas</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('settings.identitas.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="tab" value="tab2">


                    <x-alumni.input-text label="NISN" value="{{ $alumni->nisn }}" name="nisn" type="text"
                        :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="NIS Mahad" value="{{ $alumni->nism }}" name="nism" type="text"
                        :disabled="true"></x-alumni.input-text>

                    {{-- <div class="bg-teal-100 border-t-4 border-teal-500 rounded-xl text-teal-900 px-4 py-3 my-4 shadow-md"
                        role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path
                                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                </svg></div>
                            <div>
                                <p class="font-bold text-sm">Data NIK dan No Paspor buat apa?</p>
                                <ul>
                                    <li class="text-xs">Simpan NIK dan nomor paspormu di profil agar proses pengajuan
                                        berkas lebih cepat. Data ini akan otomatis terisi saat kamu melakukan pengajuan
                                        berkas. Data ini terlindungi dengan enkripsi.</li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <x-alumni.input-text label="NIK" value="{{ $alumni->nik }}" name="nik"
                        type="text"></x-alumni.input-text>

                    <x-alumni.input-text label="Nomor Paspor" value="{{ $alumni->passport_number }}"
                        name="passport_number" type="text"></x-alumni.input-text>

                    <div class="flex justify-between">
                        <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
                    </div>
                </form>
            </div>
        </div>
        <div id="tab3" class="tab-content hidden">
            <div class="bg-white border-2 border-gray-700/30 rounded-3xl p-6 backdrop-blur-xl shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 text-primary">Data Orang Tua</h2>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <form action="{{ route('settings.identitas.update') }}" method="post">

                    @csrf
                    <input type="hidden" name="tab" value="tab3">

                    <x-alumni.input-text label="Nama Ayah" value="{{ $alumni->father_name }}" name="father_name"
                        type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-select name="father_status" label="Status Ayah" :required="true">
                        <option value="" disabled>Pilih Status</option>
                        <option value="1"
                            {{ old('father_status', $alumni->father_status ?? '') == 1 ? 'selected' : '' }}>Hidup
                        </option>
                        <option value="0"
                            {{ old('father_status', $alumni->father_status ?? '') == 0 ? 'selected' : '' }}>Wafat
                        </option>
                    </x-alumni.input-select>

                    <x-alumni.input-text label="Nama Ibu" value="{{ $alumni->mother_name }}" name="mother_name"
                        type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-select name="mother_status" label="Status Ibu" :required="true">
                        <option value="" disabled>Pilih Status</option>
                        <option value="1"
                            {{ old('mother_status', $alumni->mother_status ?? '') == 1 ? 'selected' : '' }}>Hidup
                        </option>
                        <option value="0"
                            {{ old('mother_status', $alumni->mother_status ?? '') == 0 ? 'selected' : '' }}>Wafat
                        </option>
                    </x-alumni.input-select>

                    <div class="flex justify-between">
                        <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
                    </div>
                </form>

            </div>
        </div>
        <div id="tab4" class="tab-content hidden">
            <livewire:alumni.address-form />
        </div>

        <div id="tab5" class="tab-content hidden">
            <div class="bg-white border-2 border-gray-700/30 rounded-3xl p-6 backdrop-blur-xl mb-4 shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 text-primary">Kontak</h2>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-xl text-teal-900 px-4 py-3 mb-4 shadow-md"
                    role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div>
                            <p class="font-bold text-sm">Kontak darurat buat apa?</p>
                            <ul>
                                <li class="text-xs">Kontak darurat penting biar kita bisa cepat hubungi orang
                                    terdekatmu kalau ada kondisi darurat. Pastikan nomornya aktif di WhatsApp biar
                                    lancar komunikasinya.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('settings.identitas.update') }}" method="post">

                    @csrf
                    <input type="hidden" name="tab" value="tab5">
                    <!-- Tab Content -->
                    <x-alumni.input-text label="Whatsapp" value="{{ $alumni->whatsapp }}" name="whatsapp"
                        type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Kontak Darurat" value="{{ $alumni->emergency_contact }}"
                        name="emergency_contact" type="text" :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Email" value="{{ $alumni->email }}" name="email" type="email"
                        :required="true"></x-alumni.input-text>

                    <x-alumni.input-text label="Profil Linkedin" value="{{ $alumni->linkedin }}" name="linkedin"
                        type="url"></x-alumni.input-text>

                    <div class="flex justify-between">
                        <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menangani perubahan hash URL
        function handleHashChange() {
            const hash = window.location.hash;
            if (hash) {
                // Hapus tanda # dari hash
                const tabId = hash.substring(1);
                showTab(tabId);
            } else {
                // Jika tidak ada hash, tampilkan tab1 sebagai default
                showTab('tab1');
            }
        }

        function showTab(tabId) {
            // Sembunyikan semua konten tab
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');

            // Update style button
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => {
                button.classList.remove('bg-primary');
                button.classList.add('bg-white');
                button.classList.remove('text-white');
                button.classList.add('text-primary');
            });

            // Set style untuk button aktif
            const activeBtn = document.getElementById(tabId + '-btn');
            activeBtn.classList.remove('bg-white');
            activeBtn.classList.add('bg-primary');
            activeBtn.classList.remove('text-primary');
            activeBtn.classList.add('text-white');
        }

        // Tambahkan event listener untuk hash change
        window.addEventListener('hashchange', handleHashChange);

        // Jalankan saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', handleHashChange);
    </script>

</x-alumni.child-layout>
