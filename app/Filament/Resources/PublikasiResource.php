<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublikasiResource\Pages;
use App\Models\Publikasi;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Actions\Action;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PublikasiResource extends Resource
{
    protected static ?string $model = Publikasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Kelola Publikasi';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Publikasi')
                    ->schema([
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->unique(Publikasi::class, 'judul', ignoreRecord: true),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateSlug')
                                    ->icon('heroicon-m-arrow-path')
                                    ->tooltip('Generate Slug dari Judul')
                                    ->action(function (Forms\Set $set, Forms\Get $get) {
                                        $judul = $get('judul');
                                        if ($judul) {
                                            $set('slug', Str::slug($judul) . '-' . time());
                                        }
                                    })
                            ),

                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('kategori')
                            ->options([
                                'peraturan_desa' => 'Peraturan Desa',
                                'keputusan_kepala_desa' => 'Keputusan Kepala Desa',
                                'laporan_keuangan' => 'Laporan Keuangan',
                                'rencana_kerja' => 'Rencana Kerja',
                                'profil_desa' => 'Profil Desa',
                                'monografi' => 'Monografi',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        TextInput::make('tahun')
                            ->numeric()
                            ->default(date('Y'))
                            ->minValue(2000)
                            ->maxValue(date('Y') + 5),
                    ])->columns(2),

                Section::make('Detail Publikasi')
                    ->schema([
                        Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('files')
                            ->label('File Publikasi')
                            ->disk('public')
                            ->directory('publikasi')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->multiple()
                            ->helperText('Upload file PDF atau DOC (Maks 10MB per file)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan Publikasi')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(false),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('desa.nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kategori')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => str_replace('_', ' ', ucwords($state, '_')))
                    ->color(fn(string $state): string => match ($state) {
                        'peraturan_desa' => 'danger',
                        'keputusan_kepala_desa' => 'warning',
                        'laporan_keuangan' => 'success',
                        'rencana_kerja' => 'info',
                        'profil_desa' => 'primary',
                        'monografi' => 'gray',
                        default => 'secondary',
                    }),

                TextColumn::make('tahun')
                    ->sortable(),

                TextColumn::make('download_count')
                    ->label('Unduhan')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Dipublikasikan'),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua Publikasi')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),

                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                SelectFilter::make('kategori')
                    ->options([
                        'peraturan_desa' => 'Peraturan Desa',
                        'keputusan_kepala_desa' => 'Keputusan Kepala Desa',
                        'laporan_keuangan' => 'Laporan Keuangan',
                        'rencana_kerja' => 'Rencana Kerja',
                        'profil_desa' => 'Profil Desa',
                        'monografi' => 'Monografi',
                        'lainnya' => 'Lainnya',
                    ]),

                SelectFilter::make('tahun')
                    ->options(function () {
                        $years = [];
                        $currentYear = (int) date('Y');
                        for ($i = $currentYear; $i >= 2000; $i--) {
                            $years[$i] = (string) $i;
                        }
                        return $years;
                    }),
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
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListPublikasis::route('/'),
            'create' => Pages\CreatePublikasi::route('/create'),
            'edit' => Pages\EditPublikasi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return parent::getEloquentQuery();
        }

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return parent::getEloquentQuery()->whereHas('desa', function ($query) use ($user) {
                $query->where('admin_id', $user->getKey());
            });
        }

        return parent::getEloquentQuery()->where('id', 0); // No access
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin', 'admin_desa', 'operator_desa']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin', 'admin_desa', 'operator_desa']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return $record->desa->admin_id === $user->getKey();
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return $record->desa->admin_id === $user->getKey();
        }

        return false;
    }
}
