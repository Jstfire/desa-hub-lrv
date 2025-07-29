<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataResource\Pages;
use App\Models\Metadata;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
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
                                'demografi' => 'Demografi',
                                'geografis' => 'Geografis',
                                'ekonomi' => 'Ekonomi',
                                'sosial' => 'Sosial',
                                'infrastruktur' => 'Infrastruktur',
                            ])
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->unique(Metadata::class, 'judul', ignoreRecord: true),

                        TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 10)
                            ->placeholder('Contoh: 2024'),

                        TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(1),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),

                Section::make('Deskripsi')
                    ->schema([
                        TinyEditor::make('konten')
                            ->label('Deskripsi')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Dokumen Metadata')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('dokumen')
                            ->collection('dokumen')
                            ->multiple()
                            ->disk('public')
                            ->directory('metadata/dokumen')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            ])
                            ->label('Dokumen (PDF, Word, Excel)'),
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
                        'demografi' => 'primary',
                        'geografis' => 'info',
                        'ekonomi' => 'success',
                        'sosial' => 'warning',
                        'infrastruktur' => 'purple',
                        default => 'gray',
                    }),

                TextColumn::make('tahun')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

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
                        'demografi' => 'Demografi',
                        'geografis' => 'Geografis',
                        'ekonomi' => 'Ekonomi',
                        'sosial' => 'Sosial',
                        'infrastruktur' => 'Infrastruktur',
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
