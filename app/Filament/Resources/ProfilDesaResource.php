<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilDesaResource\Pages;
use App\Models\ProfilDesa;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProfilDesaResource extends Resource
{
    protected static ?string $model = ProfilDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Profil Desa';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Profil Desa')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('jenis')
                            ->label('Jenis')
                            ->options([
                                'tentang' => 'Tentang Desa',
                                'visi_misi' => 'Visi & Misi',
                                'struktur' => 'Struktur Organisasi',
                                'monografi' => 'Monografi',
                            ])
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('urutan')
                            ->label('Urutan')
                            ->integer()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true),
                    ])->columns(2),

                Section::make('Konten')
                    ->schema([
                        RichEditor::make('konten')
                            ->label('Konten')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('profil-desa/konten-media')
                            ->required(),
                    ]),

                Section::make('Dokumen Pendukung')
                    ->schema([
                        FileUpload::make('documents')
                            ->label('Dokumen Pendukung (Opsional)')
                            ->disk('public')
                            ->directory('profil-desa/documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->multiple()
                            ->maxSize(5120), // 5 MB
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('desa.nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'tentang' => 'Tentang Desa',
                        'visi_misi' => 'Visi & Misi',
                        'struktur' => 'Struktur Organisasi',
                        'monografi' => 'Monografi',
                        default => ucwords(str_replace('_', ' ', $state)),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'tentang' => 'primary',
                        'visi_misi' => 'success',
                        'struktur' => 'warning',
                        'monografi' => 'info',
                        default => 'gray',
                    }),

                ToggleColumn::make('is_published')
                    ->label('Dipublikasikan'),

                TextColumn::make('urutan')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),

                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                SelectFilter::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'tentang' => 'Tentang Desa',
                        'visi_misi' => 'Visi & Misi',
                        'struktur' => 'Struktur Organisasi',
                        'monografi' => 'Monografi',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan');
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
            'index' => Pages\ListProfilDesas::route('/'),
            'create' => Pages\CreateProfilDesa::route('/create'),
            'edit' => Pages\EditProfilDesa::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        return \App\Helpers\FilamentResourceHelper::getScopedResourceQuery($query);
    }
}
