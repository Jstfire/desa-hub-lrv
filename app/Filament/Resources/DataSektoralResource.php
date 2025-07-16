<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataSektoralResource\Pages;
use App\Models\DataSektoral;
use App\Models\Desa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DataSektoralResource extends Resource
{
    protected static ?string $model = DataSektoral::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';
    protected static ?string $navigationLabel = 'Kelola Data Sektoral';
    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'judul';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Data Sektoral')
                    ->schema([
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),

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

                        Select::make('sektor')
                            ->options([
                                'kependudukan' => 'Kependudukan',
                                'kesehatan' => 'Kesehatan',
                                'pendidikan' => 'Pendidikan',
                                'ekonomi' => 'Ekonomi',
                                'pertanian' => 'Pertanian',
                                'infrastruktur' => 'Infrastruktur',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        TextInput::make('tahun')
                            ->numeric()
                            ->default(date('Y'))
                            ->minValue(2000)
                            ->maxValue(date('Y') + 5),
                    ])->columns(2),

                Section::make('Detail Data')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('data-sektoral/thumbnails')
                            ->visibility('public')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->label('Gambar Thumbnail'),

                        Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Tabs::make('Data Sektoral')
                            ->tabs([
                                Tabs\Tab::make('Input Data Manual')
                                    ->schema([
                                        Repeater::make('data')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->required()
                                                    ->label('Label Data'),

                                                TextInput::make('value')
                                                    ->required()
                                                    ->label('Nilai Data'),

                                                TextInput::make('satuan')
                                                    ->label('Satuan'),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->reorderable()
                                    ]),

                                Tabs\Tab::make('Upload File Data')
                                    ->schema([
                                        FileUpload::make('dokumen')
                                            ->label('File Excel/PDF')
                                            ->disk('public')
                                            ->directory('data-sektoral/dokumen')
                                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                                            ->maxSize(10240)
                                            ->helperText('Upload file Excel atau PDF (Maks 10MB)')
                                    ]),
                            ])
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

                TextColumn::make('sektor')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->color(fn(string $state): string => match ($state) {
                        'kependudukan' => 'primary',
                        'kesehatan' => 'success',
                        'pendidikan' => 'info',
                        'ekonomi' => 'warning',
                        'pertanian' => 'danger',
                        'infrastruktur' => 'gray',
                        default => 'secondary',
                    }),

                TextColumn::make('tahun')
                    ->sortable(),

                TextColumn::make('view_count')
                    ->label('Dilihat')
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
                    ->placeholder('Semua Data')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),

                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                SelectFilter::make('sektor')
                    ->options([
                        'kependudukan' => 'Kependudukan',
                        'kesehatan' => 'Kesehatan',
                        'pendidikan' => 'Pendidikan',
                        'ekonomi' => 'Ekonomi',
                        'pertanian' => 'Pertanian',
                        'infrastruktur' => 'Infrastruktur',
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
            'index' => Pages\ListDataSektorals::route('/'),
            'create' => Pages\CreateDataSektoral::route('/create'),
            'edit' => Pages\EditDataSektoral::route('/{record}/edit'),
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
