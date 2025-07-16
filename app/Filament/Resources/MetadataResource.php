<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataResource\Pages;
use App\Models\Metadata;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class MetadataResource extends Resource
{
    protected static ?string $model = Metadata::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';
    protected static ?string $navigationLabel = 'Kelola Metadata';
    protected static ?int $navigationSort = 9;

    protected static ?string $recordTitleAttribute = 'judul';



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Metadata')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('jenis')
                            ->options([
                                'profil' => 'Profil Desa',
                                'struktur_organisasi' => 'Struktur Organisasi',
                                'visi_misi' => 'Visi & Misi',
                                'sejarah' => 'Sejarah',
                                'demografi' => 'Demografi',
                                'potensi' => 'Potensi',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(1),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),

                Section::make('Konten')
                    ->schema([
                        FileUpload::make('gambar')
                            ->image()
                            ->disk('public')
                            ->directory('metadata/gambar')
                            ->visibility('public')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('800')
                            ->label('Gambar Utama')
                            ->afterStateHydrated(function ($component, ?Model $record) {
                                if ($record && $record->getFirstMediaUrl('gambar')) {
                                    $component->state($record->getFirstMediaUrl('gambar'));
                                }
                            }),

                        RichEditor::make('konten')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('metadata/attachments')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'heading',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',
                            ]),
                    ])->columns(1),

                Section::make('Dokumen Pendukung')
                    ->schema([
                        FileUpload::make('lampiran')
                            ->multiple()
                            ->disk('public')
                            ->directory('metadata/lampiran')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg'])
                            ->label('Lampiran (PDF, Word, Image)')
                            ->afterStateHydrated(function ($component, ?Model $record) {
                                if ($record) {
                                    $files = [];
                                    foreach ($record->getMedia('lampiran') as $media) {
                                        $files[] = $media->getUrl();
                                    }
                                    if (count($files) > 0) {
                                        $component->state($files);
                                    }
                                }
                            }),
                    ])->collapsed(),
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
                    ->formatStateUsing(fn(string $state): string => str_replace('_', ' ', ucfirst($state)))
                    ->color(fn(string $state): string => match ($state) {
                        'profil' => 'primary',
                        'struktur_organisasi' => 'info',
                        'visi_misi' => 'success',
                        'sejarah' => 'danger',
                        'demografi' => 'warning',
                        'potensi' => 'purple',
                        default => 'gray',
                    }),

                TextColumn::make('urutan')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                SelectFilter::make('jenis')
                    ->options([
                        'profil' => 'Profil Desa',
                        'struktur_organisasi' => 'Struktur Organisasi',
                        'visi_misi' => 'Visi & Misi',
                        'sejarah' => 'Sejarah',
                        'demografi' => 'Demografi',
                        'potensi' => 'Potensi',
                        'lainnya' => 'Lainnya',
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
            ->defaultSort('urutan', 'asc');
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
            'index' => Pages\ListMetadata::route('/'),
            'create' => Pages\CreateMetadata::route('/create'),
            'edit' => Pages\EditMetadata::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            return $query;
        }
        
        if ($user->hasAnyRole(['admin_desa', 'operator_desa'])) {
            return $query->where('desa_id', $user->desa_id);
        }
        
        return $query;
    }
    
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user->hasAnyRole(['superadmin', 'admin_desa', 'operator_desa']);
    }
    
    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user->hasAnyRole(['superadmin', 'admin_desa', 'operator_desa']);
    }
    
    public static function canEdit(Model $record): bool
    {
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            return true;
        }
        
        if ($user->hasAnyRole(['admin_desa', 'operator_desa'])) {
            return $record->desa_id === $user->desa_id;
        }
        
        return false;
    }
    
    public static function canDelete(Model $record): bool
    {
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            return true;
        }
        
        if ($user->hasAnyRole(['admin_desa', 'operator_desa'])) {
            return $record->desa_id === $user->desa_id;
        }
        
        return false;
    }
}
