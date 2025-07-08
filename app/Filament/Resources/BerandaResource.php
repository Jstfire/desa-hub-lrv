<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BerandaResource\Pages;
use App\Filament\Resources\BerandaResource\RelationManagers;
use App\Models\Beranda;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BerandaResource extends Resource
{
    protected static ?string $model = Beranda::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Manajemen Desa';

    protected static ?string $navigationLabel = 'Kelola Beranda';

    protected static ?string $modelLabel = 'Beranda';

    protected static ?string $pluralModelLabel = 'Beranda';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('desa_id')
                    ->label('Desa')
                    ->relationship('desa', 'nama')
                    ->options(function () {
                        $user = Auth::user();

                        if ($user->hasRole('superadmin')) {
                            return Desa::all()->pluck('nama', 'id');
                        }

                        if ($user->hasRole('admin_desa')) {
                            return Desa::where('admin_id', $user->getKey())->pluck('nama', 'id');
                        }

                        if ($user->hasRole('operator_desa')) {
                            return Desa::where('operator_id', $user->getKey())->pluck('nama', 'id');
                        }

                        return [];
                    })
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Section::make('Section 1: Selamat Datang')
                    ->schema([
                        Forms\Components\TextInput::make('judul_welcome')
                            ->label('Judul')
                            ->default('Selamat Datang di Situs Resmi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('deskripsi_welcome')
                            ->label('Deskripsi')
                            ->required()
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Banner')
                            ->image()
                            ->directory('beranda/banner')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9'),
                    ]),

                Forms\Components\Section::make('Section 2: Berita Terbaru')
                    ->schema([
                        Forms\Components\Toggle::make('show_berita')
                            ->label('Tampilkan Section Berita Terbaru')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_berita')
                            ->label('Judul Section Berita')
                            ->default('Berita Terbaru')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jumlah_berita')
                            ->label('Jumlah Berita yang Ditampilkan')
                            ->numeric()
                            ->default(6)
                            ->minValue(3)
                            ->maxValue(12)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Section 3: Lokasi Desa')
                    ->schema([
                        Forms\Components\Toggle::make('show_lokasi')
                            ->label('Tampilkan Section Lokasi Desa')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_lokasi')
                            ->label('Judul Section Lokasi')
                            ->default('Lokasi Desa')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('embed_map')
                            ->label('Embed Google Maps')
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Section 4: Struktur Organisasi')
                    ->schema([
                        Forms\Components\Toggle::make('show_struktur')
                            ->label('Tampilkan Section Struktur Organisasi')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_struktur')
                            ->label('Judul Section Struktur')
                            ->default('Struktur Organisasi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('gambar_struktur')
                            ->label('Gambar Struktur Organisasi')
                            ->image()
                            ->directory('beranda/struktur')
                            ->maxSize(2048),
                    ]),

                Forms\Components\Section::make('Section 5: Jumlah Penduduk')
                    ->schema([
                        Forms\Components\Toggle::make('show_penduduk')
                            ->label('Tampilkan Section Jumlah Penduduk')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_penduduk')
                            ->label('Judul Section Penduduk')
                            ->default('Jumlah Penduduk')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('total_penduduk')
                            ->label('Total Penduduk')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('penduduk_laki')
                            ->label('Jumlah Penduduk Laki-laki')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('penduduk_perempuan')
                            ->label('Jumlah Penduduk Perempuan')
                            ->numeric()
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_data_penduduk')
                            ->label('Tanggal Data Penduduk')
                            ->required()
                            ->default(now()),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Section 6: APBDesa 2025')
                    ->schema([
                        Forms\Components\Toggle::make('show_apbdes')
                            ->label('Tampilkan Section APBDesa')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_apbdes')
                            ->label('Judul Section APBDesa')
                            ->default('APBDesa 2025')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pendapatan_desa')
                            ->label('Pendapatan Desa (dalam Rupiah)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('belanja_desa')
                            ->label('Belanja Desa (dalam Rupiah)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('target_pendapatan')
                            ->label('Target Pendapatan (dalam Rupiah)')
                            ->numeric()
                            ->required()
                            ->helperText('Digunakan untuk menghitung persentase pendapatan'),
                        Forms\Components\TextInput::make('target_belanja')
                            ->label('Target Belanja (dalam Rupiah)')
                            ->numeric()
                            ->required()
                            ->helperText('Digunakan untuk menghitung persentase belanja'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Section 7: Galeri Desa')
                    ->schema([
                        Forms\Components\Toggle::make('show_galeri')
                            ->label('Tampilkan Section Galeri')
                            ->default(true),
                        Forms\Components\TextInput::make('judul_galeri')
                            ->label('Judul Section Galeri')
                            ->default('Galeri Desa')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jumlah_galeri')
                            ->label('Jumlah Foto yang Ditampilkan')
                            ->numeric()
                            ->default(6)
                            ->minValue(3)
                            ->maxValue(12)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('show_berita')
                    ->label('Berita')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('show_lokasi')
                    ->label('Lokasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('show_struktur')
                    ->label('Struktur')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('show_penduduk')
                    ->label('Penduduk')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('show_apbdes')
                    ->label('APBDesa')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('show_galeri')
                    ->label('Galeri')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListBerandas::route('/'),
            'create' => Pages\CreateBeranda::route('/create'),
            'view' => Pages\ViewBeranda::route('/{record}'),
            'edit' => Pages\EditBeranda::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return parent::getEloquentQuery();
        }

        if ($user->hasRole('admin_desa')) {
            return parent::getEloquentQuery()->whereHas('desa', function ($query) use ($user) {
                $query->where('admin_id', $user->getKey());
            });
        }

        if ($user->hasRole('operator_desa')) {
            return parent::getEloquentQuery()->whereHas('desa', function ($query) use ($user) {
                $query->where('operator_id', $user->getKey());
            });
        }

        return parent::getEloquentQuery()->where('id', 0); // No access
    }

    public static function canViewAny(): bool
    {
        return Auth::user() && Auth::user()->hasRole(['superadmin', 'admin_desa', 'operator_desa']);
    }

    public static function canCreate(): bool
    {
        return Auth::user() && Auth::user()->hasRole(['superadmin', 'admin_desa']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        if ($user->hasRole('admin_desa')) {
            return $record->desa->admin_id === $user->getKey();
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        return false;
    }
}
