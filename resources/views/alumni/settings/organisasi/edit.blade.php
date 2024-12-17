<x-alumni.child-layout>
    <x-alumni.back-button />
    <x-alumni.settings-card title="Tambah Data Majma / JT">

        <form action="{{ route('settings.organisasi.update', $myOrganization['id']) }}" method="post">
            @csrf
            @method('PUT')

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <x-alumni.input-select name="organization_id" label="Nama Majma / JT" :required="true">
                <option value="">Pilih Majma / JT</option>
                @foreach ($organizations as $organization)
                    <option value="{{ $organization->id }}" @if ($organization->id == $myOrganization['organization_id']) selected @endif>
                        {{ $organization->name }}</option>
                @endforeach
            </x-alumni.input-select>

            <div class="flex flex-row gap-4 -mt-3">
                <x-alumni.input-select name="start" label="Tahun Mulai" :required="true">
                    <option value="">Pilih Tahun</option>
                    @for ($year = 2018; $year <= 2024; $year++)
                        <option value="{{ $year }}" @if ($year == $myOrganization['start']) selected @endif>
                            {{ $year }}</option>
                    @endfor

                </x-alumni.input-select>

                <x-alumni.input-select name="end" label="Tahun Berakhir" :required="true">
                    <option value="">Pilih Tahun</option>
                    @for ($year = 2018; $year <= 2024; $year++)
                        <option value="{{ $year }}" @if ($year == $myOrganization['end']) selected @endif>
                            {{ $year }}</option>
                    @endfor
                </x-alumni.input-select>
            </div>
            <x-alumni.input-text label="Posisi / Jabatan" value="{{ $myOrganization['position'] }}"
                placeholder="Contoh: Reporter / Korlap / Qism Tanfidz" name="position" type="text"
                :required="true"></x-alumni.input-text>

            <x-alumni.submit-button style="w-full" type="submit">
                Simpan Perubahan
            </x-alumni.submit-button>
        </form>
        <form action="{{ route('settings.organisasi.destroy', $myOrganization['id']) }}" method="POST" class="inline"
            data-id="{{ $myOrganization['id'] }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-block text-center px-4 mt-4 py-2 rounded-xl bg-red-400 w-full hover:opacity-90 transition-all text-white ml-auto"
                data-confirm-delete="true">
                Hapus Data
            </button>
        </form>
        {{-- <a href="{{ route('settings.organisasi.destroy', $myOrganization['id']) }}" class="inline-block text-center px-4 mt-4 py-2 rounded-xl bg-red-400 w-full hover:opacity-90 transition-all text-white ml-auto" data-confirm-delete="true">Delete</a> --}}


    </x-alumni.settings-card>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll("[data-confirm-delete]").forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest("form");
                const organizationId = form.getAttribute('data-id');

                const deleteUrl = "{{ route('settings.organisasi.destroy', $myOrganization['id']) }}";

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan FormData untuk mengirim form data dengan benar
                        const formData = new FormData(form);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire(
                                        'Terhapus!',
                                        'Data berhasil dihapus.',
                                        'success'
                                    ).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    // Tangkap pesan error dari response
                                    return response.text().then(errorText => {
                                        throw new Error(errorText);
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Gagal menghapus data: ' + error.message,
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>

</x-alumni.child-layout>
