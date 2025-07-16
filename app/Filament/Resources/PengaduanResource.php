<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Filament\Resources\PengaduanResource\RelationManagers;
use App\Models\Pengaduan;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';
    protected static ?string $navigationLabel = 'Kelola Pengaduan';
    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'Pengaduan';

    protected static ?string $pluralModelLabel = 'Pengaduan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengaduan')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa')
                            ->relationship('desa', 'nama')
                            ->options(function () {
                                $user = Auth::user();
                                if ($user->hasRole('superadmin')) {
                                    return Desa::all()->pluck('nama', 'id');
                                }
                                if ($user->hasRole(['admin_desa', 'operator_desa'])) {
                                    return Desa::where('admin_id', $user->getKey())->pluck('nama', 'id');
                                }
                                return collect();
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                        TextInput::make('nama')
                            ->label('Nama Pengadu')
                            ->required()
                            ->maxLength(255)
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                        TextInput::make('nomor_telepon')
                            ->label('Nomor Telepon/WA')
                            ->required()
                            ->maxLength(20)
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                        Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'Umum' => 'Umum',
                                'Sosial' => 'Sosial',
                                'Keamanan' => 'Keamanan',
                                'Kesehatan' => 'Kesehatan',
                                'Kebersihan' => 'Kebersihan',
                                'Permintaan' => 'Permintaan',
                            ])
                            ->required()
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                    ])
                    ->columns(2),
                Section::make('Detail Pengaduan')
                    ->schema([
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Pengaduan')
                            ->required()
                            ->rows(4)
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                        TextInput::make('lampiran')
                            ->label('Lampiran (Link Google Drive)')
                            ->url()
                            ->nullable()
                            ->disabled(fn(string $context): bool => $context === 'edit'),
                    ]),
                Section::make('Status & Tanggapan')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'Dalam Proses',
                                'resolved' => 'Selesai',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('pending')
                            ->required(),
                        Textarea::make('tanggapan')
                            ->label('Tanggapan')
                            ->rows(4)
                            ->nullable()
                            ->helperText('Tanggapan dari pihak desa'),
                        DateTimePicker::make('tanggal_tanggapan')
                            ->label('Tanggal Tanggapan')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Pengadu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_telepon')
                    ->label('No. Telepon')
                    ->searchable(),
                TextColumn::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Umum' => 'primary',
                        'Sosial' => 'success',
                        'Keamanan' => 'danger',
                        'Kesehatan' => 'warning',
                        'Kebersihan' => 'info',
                        'Permintaan' => 'secondary',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'secondary',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Pengaduan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('tanggal_tanggapan')
                    ->label('Tanggal Tanggapan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('desa')
                    ->label('Desa')
                    ->relationship('desa', 'nama')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Umum' => 'Umum',
                        'Sosial' => 'Sosial',
                        'Keamanan' => 'Keamanan',
                        'Kesehatan' => 'Kesehatan',
                        'Kebersihan' => 'Kebersihan',
                        'Permintaan' => 'Permintaan',
                    ])
                    ->multiple(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'Dalam Proses',
                        'resolved' => 'Selesai',
                        'rejected' => 'Ditolak',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('respond')
                    ->label('Tanggapi')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'in_progress' => 'Dalam Proses',
                                'resolved' => 'Selesai',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Textarea::make('tanggapan')
                            ->label('Tanggapan')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (array $data, Pengaduan $record): void {
                        $record->update([
                            'status' => $data['status'],
                            'tanggapan' => $data['tanggapan'],
                            'tanggal_tanggapan' => now(),
                        ]);
                    })
                    ->visible(fn(Pengaduan $record) => $record->status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPengaduans::route('/'),
            'create' => Pages\CreatePengaduan::route('/create'),
            'view' => Pages\ViewPengaduan::route('/{record}'),
            'edit' => Pages\EditPengaduan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return $query;
        }

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return $query->where('desa_id', $user->desa_id);
        }

        return $query;
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin', 'admin_desa', 'operator_desa']);
    }

    public static function canCreate(): bool
    {
        return false; // Pengaduan dibuat dari frontend
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return $record->desa_id === $user->desa_id;
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        if ($user->hasRole('superadmin')) return true;

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            return $record->desa_id === $user->desa_id;
        }

        return false;
    }
}
