<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Survey;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;
use Random\Engine\Secure;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    CheckboxList::make('univ_factor')
                        ->label('Apa faktor yang paling mempengaruhi Anda dalam pemilihan kampus?')
                        ->options([
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
                            'lainnya' => 'Lainnya',
                        ])
                        ->required()
                        ->reactive()
                        ->columns(2),
                    ]),
                    Section::make()
                    ->schema([
                        CheckboxList::make('program_factor')
                            ->label('Apa faktor yang paling mempengaruhi Anda dalam pemilihan prodi?')
                            ->options([
                                'minat_bakat' => 'Minat dan bakat',
                                'prospek_kerja' => 'Prospek kerja',
                                'saran_keluarga_teman' => 'Saran dari keluarga atau teman',
                                'ketersediaan_jurusan' => 'Ketersediaan jurusan di kampus yang diinginkan',
                                'realistis' => 'Realistis',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->reactive()
                            ->columns(2),
                    ]),
                    Section::make()
                    ->schema([
                        CheckboxList::make('activity')
                            ->label('Program apa yang Anda ikuti selama perkuliahan?')
                            ->options([
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
                            ])
                            ->required()
                            ->reactive()
                            ->columns(2),
                    ]),
                    Section::make()
                    ->schema([
                        CheckboxList::make('pia_impact')
                            ->label('Menurut Anda, apa program PIA yang paling berpengaruh bagi kelanjutan studi Anda?')
                            ->options([
                                'info_tim_edu' => 'Informasi dari tim edu',
                                'seminar_studi_lanjut' => 'Seminar studi lanjut dan pengembangan diri',
                                'kerjasama_bimbel' => 'Kerjasama dengan bimbel',
                                'kurikulum_karakter' => 'Kurikulum pembelajaran dan pembentukan karakter',
                                'partisipasi_organisasi' => 'Partisipasi dalam organisasi',
                                'kesaktian_ijazah' => 'Kesaktian Ijazah IM atau berkas tazkiah tertentu',
                                'tidak_ada' => 'Tidak ada',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->reactive()
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->rowIndex()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }

}
