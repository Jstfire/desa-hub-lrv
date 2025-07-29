<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages;
use App\Models\Desa;
use App\Models\Footer;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
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

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Kelola Footer';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Footer')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('section')
                            ->label('Bagian Footer')
                            ->options([
                                'section1' => 'Section 1 - Logo & Lokasi',
                                'section2' => 'Section 2 - Hubungi Kami',
                                'section3' => 'Section 3 - Nomor Telepon Penting',
                                'section4' => 'Section 4 - Jelajahi',
                                'copyright' => 'Copyright',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('judul', match ($state) {
                                    'section1' => 'Logo & Lokasi',
                                    'section2' => 'Hubungi Kami',
                                    'section3' => 'Nomor Telepon Penting',
                                    'section4' => 'Jelajahi',
                                    'copyright' => 'Copyright',
                                    default => '',
                                })
                            ),

                        TextInput::make('judul')
                            ->label('Judul Section')
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Konten Footer')
                    ->schema([
                        Forms\Components\Placeholder::make('section_info')
                            ->label('Informasi Bagian')
                            ->content(fn(callable $get) => match ($get('section')) {
                                'section1' => 'Bagian ini untuk menampilkan logo dan lokasi desa',
                                'section2' => 'Bagian ini untuk menampilkan kontak dan media sosial',
                                'section3' => 'Bagian ini untuk menampilkan nomor telepon penting',
                                'section4' => 'Bagian ini untuk menampilkan link penting',
                                'copyright' => 'Bagian ini untuk menampilkan copyright',
                                default => 'Pilih bagian footer terlebih dahulu',
                            }),

                        // Konten khusus untuk Section 1 - Logo & Lokasi
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\FileUpload::make('konten.logo')
                                    ->label('Logo Desa/Kabupaten')
                                    ->image()
                                    ->disk('public')
                                    ->directory('footer/logo')
                                    ->visibility('public')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('200')
                                    ->imageResizeTargetHeight('200'),

                                TinyEditor::make('konten.alamat')
                                    ->label('Alamat Desa')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsVisibility('public')
                                    ->fileAttachmentsDirectory('uploads')
                                    ->profile('default')
                                    ->columnSpanFull(),

                                TextInput::make('konten.maps_url')
                                    ->label('URL Google Maps')
                                    ->url()
                                    ->helperText('Masukkan URL embed Google Maps (opsional)'),
                            ])
                            ->visible(fn(callable $get) => $get('section') === 'section1'),

                        // Konten khusus untuk Section 2 - Hubungi Kami
                        Forms\Components\Group::make()
                            ->schema([
                                Repeater::make('konten.kontak')
                                    ->label('Kontak')
                                    ->schema([
                                        Select::make('tipe')
                                            ->label('Tipe Kontak')
                                            ->options([
                                                'telepon' => 'Telepon',
                                                'email' => 'Email',
                                            ])
                                            ->required(),

                                        TextInput::make('nilai')
                                            ->label('Nilai')
                                            ->required(),

                                        Toggle::make('aktif')
                                            ->label('Aktif')
                                            ->default(true),
                                    ])
                                    ->defaultItems(0),

                                Repeater::make('konten.sosmed')
                                    ->label('Media Sosial')
                                    ->schema([
                                        Select::make('tipe')
                                            ->label('Tipe Media Sosial')
                                            ->options([
                                                'instagram' => 'Instagram',
                                                'facebook' => 'Facebook',
                                                'twitter' => 'Twitter/X',
                                                'youtube' => 'YouTube',
                                            ])
                                            ->required(),

                                        TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),

                                        Toggle::make('aktif')
                                            ->label('Aktif')
                                            ->default(true),
                                    ])
                                    ->defaultItems(0),
                            ])
                            ->visible(fn(callable $get) => $get('section') === 'section2'),

                        // Konten khusus untuk Section 3 - Nomor Telepon Penting
                        Forms\Components\Group::make()
                            ->schema([
                                Repeater::make('konten.nomor_penting')
                                    ->label('Nomor Telepon Penting')
                                    ->schema([
                                        TextInput::make('nama')
                                            ->label('Nama Kontak')
                                            ->required(),

                                        TextInput::make('nomor')
                                            ->label('Nomor Telepon')
                                            ->tel()
                                            ->required(),

                                        Toggle::make('aktif')
                                            ->label('Aktif')
                                            ->default(true),
                                    ])
                                    ->defaultItems(0),
                            ])
                            ->visible(fn(callable $get) => $get('section') === 'section3'),

                        // Konten khusus untuk Section 4 - Jelajahi
                        Forms\Components\Group::make()
                            ->schema([
                                Repeater::make('konten.link_penting')
                                    ->label('Link Penting')
                                    ->schema([
                                        TextInput::make('nama')
                                            ->label('Nama Website')
                                            ->required(),

                                        TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),

                                        Toggle::make('aktif')
                                            ->label('Aktif')
                                            ->default(true),
                                    ])
                                    ->defaultItems(0),
                            ])
                            ->visible(fn(callable $get) => $get('section') === 'section4'),

                        // Konten khusus untuk Copyright
                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('konten.text')
                                    ->label('Text Copyright')
                                    ->required()
                                    ->default('© 2025. Made with ☕ by Jstfire.'),
                            ])
                            ->visible(fn(callable $get) => $get('section') === 'copyright'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('desa.nama')
                    ->label('Desa/Kelurahan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('section')
                    ->label('Bagian')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'section1' => 'Logo & Lokasi',
                        'section2' => 'Hubungi Kami',
                        'section3' => 'Nomor Telepon Penting',
                        'section4' => 'Jelajahi',
                        'copyright' => 'Copyright',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'section1' => 'primary',
                        'section2' => 'success',
                        'section3' => 'info',
                        'section4' => 'warning',
                        'copyright' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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

                SelectFilter::make('section')
                    ->label('Bagian')
                    ->options([
                        'section1' => 'Logo & Lokasi',
                        'section2' => 'Hubungi Kami',
                        'section3' => 'Nomor Telepon Penting',
                        'section4' => 'Jelajahi',
                        'copyright' => 'Copyright',
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
            'index' => Pages\ListFooter::route('/'),
            'create' => Pages\CreateFooter::route('/create'),
            'edit' => Pages\EditFooter::route('/{record}/edit'),
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
