<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriResource\Pages;
use App\Models\Galeri;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class GaleriResource extends Resource
{
    protected static ?string $model = Galeri::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Kelola Galeri';

    protected static ?int $navigationSort = 12;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Galeri')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->unique(Galeri::class, 'judul', ignoreRecord: true),

                        Textarea::make('deskripsi')
                            ->rows(3),

                        Select::make('jenis')
                            ->options([
                                'foto' => 'Foto',
                                'video' => 'Video',
                            ])
                            ->default('foto')
                            ->required(),

                        TextInput::make('kategori')
                            ->datalist([
                                'Kegiatan Desa',
                                'Potensi Desa',
                                'Wisata Desa',
                                'Infrastruktur',
                                'Sosial Budaya',
                                'Lainnya'
                            ])
                            ->placeholder('Pilih atau ketik kategori')
                            ->required(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now())
                            ->required(),
                    ])->columns(2),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('foto')
                            ->label(fn(callable $get) => $get('jenis') === 'foto' ? 'Upload Foto' : 'Upload Video (MP4)')
                            ->image(fn(callable $get) => $get('jenis') === 'foto')
                            ->acceptedFileTypes(fn(callable $get) => $get('jenis') === 'foto'
                                ? ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']
                                : ['video/mp4'])
                            ->disk('public')
                            ->directory('galeri/foto')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->required()
                            ->helperText(fn(callable $get) => $get('jenis') === 'foto'
                                ? 'Format yang didukung: JPG, PNG, GIF'
                                : 'Format yang didukung: MP4. Maksimal 20MB'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular(false)
                    ->square()
                    ->state(function (Galeri $record): ?string {
                        if ($record->jenis === 'foto' && $record->getFirstMedia('foto')) {
                            return $record->getFirstMediaUrl('foto');
                        } elseif ($record->jenis === 'video' && $record->getFirstMedia('foto')) {
                            return $record->getFirstMedia('foto')->getUrl();
                        }
                        return null;
                    }),

                TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('desa.nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'foto' => 'primary',
                        'video' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('kategori')
                    ->searchable(),

                TextColumn::make('view_count')
                    ->label('Dilihat')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Dipublikasikan'),

                TextColumn::make('published_at')
                    ->dateTime('d M Y')
                    ->sortable(),
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
                    ->options([
                        'foto' => 'Foto',
                        'video' => 'Video',
                    ]),

                SelectFilter::make('kategori')
                    ->options(function () {
                        return Galeri::distinct()->pluck('kategori', 'kategori')->toArray();
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
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
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
