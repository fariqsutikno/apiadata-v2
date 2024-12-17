<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use App\Enums\AdmissionPath;
use App\Enums\CompletionStatus;
use App\Enums\FundingSource;
use Livewire\Component;
use App\Models\University;
use App\Models\Program;
use App\Models\UniversityAlumni;
use Illuminate\Support\Facades\Auth;

class UniversityAlumniForm extends Component
{
    public $dataMethod;
    public $universities;
    public $programs = null;
    // protected CompletionStatus $completionStatus;
    // protected AdmissionPath $admissionPath;
    
    public $selectedUniversity;
    public $selectedProgram;
    public $selectedUniversityName;
    public $selectedProgramName;
    
    public $monthStart;
    public $yearStart;

    public $completionStatus = null;

    public $monthEnd = null;
    public $yearEnd = null;
    
    public string $admissionPath = '';
    public ?string $snbtScore = null;
    public ?string $endQuestion = null;
    public $fundingSource;
    public $isVisible;
    public $isAccepted;
    public $priority;
    public $dataStudiId = null;

    public function mount($id = null, $method)
    {
        if($id)
        {
            $alumni_id = Auth::user()->alumni->id;
            $dataStudi = UniversityAlumni::findOrFail($id);
            if($alumni_id !== $dataStudi->alumni_id){
                return redirect()->route('settings')->with('error', 'Data dilarang untuk diubah!');
            }

            // dd($dataStudi);
            $this->dataStudiId = $dataStudi->id;
            $this->selectedUniversity = $dataStudi->university_id;
            $this->selectedUniversityName = $dataStudi->university->name;
            $this->selectedProgram = $dataStudi->program_id;
            $this->selectedProgramName = $dataStudi->program->name;
            $this->monthStart = $dataStudi->month_start;
            $this->yearStart = $dataStudi->year_start;
            $this->monthEnd = $dataStudi->month_end;
            $this->yearEnd = $dataStudi->year_end;
            $this->admissionPath = $dataStudi->admission_path->value;
            $this->snbtScore = $dataStudi->snbt_score;
            $this->isVisible = $dataStudi->is_hidden;
            $this->isAccepted = $dataStudi->is_accepted;
            $this->priority = $dataStudi->priority;
        }
        
        if($this->dataMethod === 'create@studi' || $this->dataMethod === 'edit@studi'){
            $this->completionStatus = $dataStudi->completion_status->value;
            $this->fundingSource = $dataStudi->funding_source->value;
        }

        $this->dataMethod = $method;
    }

    public function updatedAdmissionPath($value)
    {
        // Reset SNBT score when admission path changes
        $this->snbtScore = $value === AdmissionPath::SNBT->value ? '' : null;
    } 

    public function updatedCompletionStatus($value)
    {
        // Reset month and year when status changes
        if ($value === CompletionStatus::SEDANG_BERJALAN->value) {
            $this->monthEnd = null;
            $this->yearEnd = null;
        }
    }

    public function studi()
    {
        // Validasi input
        $validatedData = $this->validate([
            'selectedUniversity' => ['required', 'exists:universities,id'],
            'selectedProgram' => ['required', 'exists:programs,id'],
            'monthStart' => ['required', 'integer', 'between:1,12'],
            'yearStart' => ['required', 'integer', 'between:2022,' . date('Y')],
            'completionStatus' => ['required', 'in:' . implode(',', array_keys(CompletionStatus::labels()))],
            
            // Kondisi monthEnd dan yearEnd hanya required jika bukan SEDANG_BERJALAN
            'monthEnd' => [
                'required_if:completionStatus,!=' . CompletionStatus::SEDANG_BERJALAN->value, 
                'nullable', 
                'integer', 
                'between:1,12'
            ],
            'yearEnd' => [
                'required_if:completionStatus,!=' . CompletionStatus::SEDANG_BERJALAN->value, 
                'nullable', 
                'integer', 
                'between:2022,' . date('Y'), 
                function ($attribute, $value, $fail) {
                    if ($value && $value < $this->yearStart) {
                        $fail('Tahun akhir tidak boleh kurang dari tahun mulai.');
                    }
                }
            ],
            'admissionPath' => ['required', 'in:' . implode(',', array_keys(AdmissionPath::labels()))],
            
            // SNBT Score hanya required jika admissionPath adalah SNBT
            'snbtScore' => [
                'required_if:admissionPath,' . AdmissionPath::SNBT->value, 
                'nullable', 
                'numeric', 
                'between:1,1000'
            ],
            'fundingSource' => ['required', 'in:' . implode(',', array_keys(FundingSource::labels()))],
            'priority' => ['required']
        ], [
            // Custom error messages
            'selectedUniversity.exists' => 'Universitas yang dipilih tidak valid.',
            'selectedProgram.exists' => 'Program yang dipilih tidak valid.',
            'monthStart.between' => 'Bulan mulai harus antara 1-12.',
            'yearStart.between' => 'Tahun mulai harus antara 2022-' . date('Y'),
            'completionStatus.in' => 'Status kelulusan tidak valid.',
            'monthEnd.required_if' => 'Bulan akhir harus diisi untuk status kelulusan ini.',
            'monthEnd.between' => 'Bulan akhir harus antara 1-12.',
            'yearEnd.required_if' => 'Tahun akhir harus diisi untuk status kelulusan ini.',
            'yearEnd.between' => 'Tahun akhir harus antara 2022-' . date('Y'),
            'admissionPath.in' => 'Jalur masuk tidak valid.',
            'snbtScore.required_if' => 'Skor SNBT harus diisi untuk jalur masuk SNBT.',
            'snbtScore.between' => 'Skor SNBT harus antara 1-1000.',
            'fundingSource.in' => 'Sumber dana tidak valid.'
        ]);

        // Ambil alumni ID dari user yang sedang login
        $alumni_id = Auth::user()->alumni->id;

        // Toggle visibility
        $is_visible = !$this->isVisible;

        // Persiapkan data untuk disimpan
        $data = [
            'alumni_id' => $alumni_id,
            'university_id' => $this->selectedUniversity,
            'program_id' => $this->selectedProgram,
            'month_start' => $this->monthStart,
            'year_start' => $this->yearStart,
            'completion_status' => $this->completionStatus,
            'month_end' => $this->monthEnd,
            'year_end' => $this->yearEnd,
            'admission_path' => $this->admissionPath,
            'snbt_score' => $this->snbtScore,
            'funding_source' => $this->fundingSource,
            'is_accepted' => 1,
            'is_enrolled' => 1,
            'priority' => $this->priority,
            'is_hidden' => $is_visible
        ];

        if ($this->dataStudiId) {
            try {
                $dataStudi = UniversityAlumni::findOrFail($this->dataStudiId);
                $dataStudi->update($data);
                return redirect()->route('settings')->with('success', 'Berhasil mengubah data!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        } 
        try {
            try {
                UniversityAlumni::create($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
            return redirect()->route('settings')->with('success', 'Berhasil menambahkan data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function survey()
    {
        // Validasi input
        $validatedData = $this->validate([
            'selectedUniversity' => ['required', 'exists:universities,id'],
            'selectedProgram' => ['required', 'exists:programs,id'],
            'yearStart' => ['required', 'integer', 'between:2022,' . date('Y')],
            'admissionPath' => ['required', 'in:' . implode(',', array_keys(AdmissionPath::labels()))],
            
            // SNBT Score hanya required jika admissionPath adalah SNBT
            'snbtScore' => [
                'required_if:admissionPath,' . AdmissionPath::SNBT->value, 
                'nullable', 
                'numeric', 
                'between:1,1000'
            ],
            'priority' => ['required', 'integer'],
        ], [
            // Custom error messages
            'selectedUniversity.exists' => 'Universitas yang dipilih tidak valid.',
            'selectedProgram.exists' => 'Program yang dipilih tidak valid.',
            'yearStart.between' => 'Tahun mulai harus antara 2022-' . date('Y'),
            'admissionPath.in' => 'Jalur masuk tidak valid.',
            'snbtScore.required_if' => 'Skor SNBT harus diisi untuk jalur masuk SNBT.',
            'snbtScore.between' => 'Skor SNBT harus antara 1-1000.',
        ]);

        // Ambil alumni ID dari user yang sedang login
        $alumni_id = Auth::user()->alumni->id;

        // Persiapkan data untuk disimpan
        $data = [
            'alumni_id' => $alumni_id,
            'university_id' => $this->selectedUniversity,
            'program_id' => $this->selectedProgram,
            'year_start' => $this->yearStart,
            'admission_path' => $this->admissionPath,
            'snbt_score' => $this->snbtScore,
            'priority' => $this->priority,
            'is_accepted' => $this->isAccepted,
            'is_enrolled' => 0,
            'is_visible' => 0,
        ];

        if ($this->dataStudiId) {
            try {
                $dataStudi = UniversityAlumni::findOrFail($this->dataStudiId);
                $dataStudi->update($data);
                return redirect()->route('survey.studi.list')->with('success', 'Berhasil mengubah data!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        } 
        try {
            try {
                UniversityAlumni::create($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
            return redirect()->route('survey.studi.list')->with('success', 'Berhasil menambahkan data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function save()
    {
        if($this->dataMethod === 'create@studi' || $this->dataMethod === 'edit@studi'){
            return $this->studi();
        }

        if($this->dataMethod === 'create@survey' || $this->dataMethod === 'edit@survey'){
            return $this->survey();
        }
    }

    public function delete()
    {
        dd('Data dihapus');
    }


    public function render()
    {
        return view('livewire.university-alumni-form', [
            'months' => [
                '1' => 'Januari',
                '2' => 'Februari',
                '3' => 'Maret',
                '4' => 'April',
                '5' => 'Mei',
                '6' => 'Juni',
                '7' => 'Juli',
                '8' => 'Agustus',
                '9' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ],
            'years' => array_combine(range(date('Y'), 2022), range(date('Y'), 2022)),
            'pathOptions' => AdmissionPath::cases(),
            'statusOptions' => CompletionStatus::cases(),
            'fundingOptions' => FundingSource::cases(),
        ]);
    }
}

