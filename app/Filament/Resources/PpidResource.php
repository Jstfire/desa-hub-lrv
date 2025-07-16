<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpidResource\Pages;
use App\Models\Ppid;
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
use Filament\Forms\Set;
use Filament\Forms\Get;
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
use Illuminate\Support\Str;

class PpidResource extends Resource
{
    protected static ?string $model = Ppid::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';
    protected static ?string $navigationLabel = 'Kelola PPID';
    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'judul';



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dokumen PPID')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa/Kelurahan')
                            ->options(Desa::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Ppid::class, 'slug', ignoreRecord: true)
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

                        Select::make('kategori')
                            ->options([
                                'informasi_berkala' => 'Informasi Berkala',
                                'informasi_serta_merta' => 'Informasi Serta Merta',
                                'informasi_setiap_saat' => 'Informasi Setiap Saat',
                                'informasi_dikecualikan' => 'Informasi Dikecualikan',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),

                        Textarea::make('deskripsi')
                            ->rows(3)
                            ->required(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        TextInput::make('urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->default(function () {
                                $user = Auth::user();
                                $desaId = $user->desa_id;

                                if ($user->hasRole('superadmin')) {
                                    // For superadmin, get max urutan across all desa
                                    $maxUrutan = Ppid::max('urutan') ?? 0;
                                } else {
                                    // For desa users, get max urutan for their desa
                                    $maxUrutan = Ppid::where('desa_id', $desaId)->max('urutan') ?? 0;
                                }

                                return $maxUrutan + 1;
                            })
                            ->suffixAction(
                                Action::make('generateUrutan')
                                    ->icon('heroicon-m-arrow-path')
                                    ->tooltip('Generate Urutan Otomatis')
                                    ->action(function (Set $set, Get $get) {
                                        $user = Auth::user();
                                        $desaId = $get('desa_id') ?? $user->desa_id;

                                        if ($user->hasRole('superadmin')) {
                                            // For superadmin, get max urutan across all desa or for selected desa
                                            if ($desaId) {
                                                $maxUrutan = Ppid::where('desa_id', $desaId)->max('urutan') ?? 0;
                                            } else {
                                                $maxUrutan = Ppid::max('urutan') ?? 0;
                                            }
                                        } else {
                                            // For desa users, get max urutan for their desa
                                            $maxUrutan = Ppid::where('desa_id', $desaId)->max('urutan') ?? 0;
                                        }

                                        $set('urutan', $maxUrutan + 1);
                                    })
                            )
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now())
                            ->required(),
                    ])->columns(2),

                Section::make('Dokumen')
                    ->schema([
                        FileUpload::make('dokumen')
                            ->label('Upload Dokumen')
                            ->disk('public')
                            ->directory('ppid/dokumen')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240) // 10MB
                            ->required(),

                        FileUpload::make('thumbnail')
                            ->label('Thumbnail (Opsional)')
                            ->image()
                            ->disk('public')
                            ->directory('ppid/thumbnail')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('300'),
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
                    ->limit(50),

                TextColumn::make('desa.nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kategori')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => str_replace('_', ' ', ucwords($state, '_')))
                    ->color(fn(string $state): string => match ($state) {
                        'informasi_berkala' => 'primary',
                        'informasi_serta_merta' => 'warning',
                        'informasi_setiap_saat' => 'success',
                        'informasi_dikecualikan' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('download_count')
                    ->label('Unduhan')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Dipublikasikan'),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                SelectFilter::make('kategori')
                    ->options([
                        'informasi_berkala' => 'Informasi Berkala',
                        'informasi_serta_merta' => 'Informasi Serta Merta',
                        'informasi_setiap_saat' => 'Informasi Setiap Saat',
                        'informasi_dikecualikan' => 'Informasi Dikecualikan',
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
            'index' => Pages\ListPpids::route('/'),
            'create' => Pages\CreatePpid::route('/create'),
            'edit' => Pages\EditPpid::route('/{record}/edit'),
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
