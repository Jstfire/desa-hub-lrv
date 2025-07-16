<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesaResource\Pages;
use App\Filament\Resources\DesaResource\RelationManagers;
use App\Models\Desa;
use App\Models\User;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn as TextCol;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DesaResource extends Resource
{
    protected static ?string $model = Desa::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Superadmin Only';

    protected static ?string $navigationLabel = 'Kelola Desa';

    protected static ?string $modelLabel = 'Desa';

    protected static ?string $pluralModelLabel = 'Desa';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Desa')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Desa')
                            ->required()
                            ->maxLength(255),
                        Select::make('jenis')
                            ->label('Jenis')
                            ->options([
                                'desa' => 'Desa',
                                'kelurahan' => 'Kelurahan',
                            ])
                            ->required()
                            ->default('desa'),
                        TextInput::make('uri')
                            ->label('URI Desa')
                            ->required()
                            ->maxLength(255)
                            ->unique(Desa::class, 'uri', ignorable: fn($record) => $record)
                            ->helperText('URI yang akan digunakan untuk mengakses situs desa (contoh: bangun untuk /bangun)')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateUri')
                                    ->icon('heroicon-m-arrow-path')
                                    ->tooltip('Generate URI dari Nama Desa')
                                    ->action(function (Forms\Set $set, Forms\Get $get) {
                                        $nama = $get('nama');
                                        if ($nama) {
                                            $set('uri', Str::slug($nama) . '-' . time());
                                        }
                                    })
                            ),
                        TextInput::make('kode_kecamatan')
                            ->label('Kode Kecamatan')
                            ->maxLength(10)
                            ->nullable(),
                        TextInput::make('kode_desa')
                            ->label('Kode Desa')
                            ->maxLength(10)
                            ->nullable(),
                    ])
                    ->columns(2),
                Section::make('Pengelola')
                    ->schema([
                        Select::make('team_id')
                            ->label('Team')
                            ->relationship('team', 'name')
                            ->options(function () {
                                return Team::all()->pluck('name', 'id');
                            })
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Team')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data) {
                                // Create a new team through user for proper setup
                                $user = Auth::user();
                                $team = $user->ownedTeams()->create([
                                    'name' => $data['name'],
                                    'personal_team' => false,
                                ]);
                                return $team->id;
                            }),
                        Select::make('admin_id')
                            ->label('Admin Desa')
                            ->relationship('admin', 'name')
                            ->options(function () {
                                return User::whereHas('roles', function ($query) {
                                    $query->whereIn('name', ['admin_desa', 'operator_desa']);
                                })->pluck('name', 'id');
                            })
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Admin')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),
                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required()
                                    ->minLength(8),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $user = User::create([
                                    'name' => $data['name'],
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                ]);
                                $user->assignRole('admin_desa');
                                return $user->id;
                            })
                            ->nullable(),
                    ])
                    ->columns(2),
                Section::make('Kontak & Alamat')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Section::make('Tampilan & Tema')
                    ->schema([
                        Select::make('font_family')
                            ->label('Font Family')
                            ->options([
                                'Inter' => 'Inter',
                                'Poppins' => 'Poppins',
                                'Roboto' => 'Roboto',
                                'Open Sans' => 'Open Sans',
                                'Nunito' => 'Nunito',
                            ])
                            ->default('Inter')
                            ->required(),
                        ColorPicker::make('color_primary')
                            ->label('Warna Utama')
                            ->required()
                            ->default('#10b981'),
                        ColorPicker::make('color_secondary')
                            ->label('Warna Sekunder')
                            ->required()
                            ->default('#3b82f6'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk menyembunyikan situs desa dari publik'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextCol::make('nama')
                    ->label('Nama Desa')
                    ->searchable()
                    ->sortable(),
                TextCol::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'desa' => 'primary',
                        'kelurahan' => 'success',
                        default => 'gray',
                    }),
                TextCol::make('uri')
                    ->label('URI')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('URI disalin!')
                    ->copyMessageDuration(1500),
                TextCol::make('admin.name')
                    ->label('Admin')
                    ->searchable()
                    ->sortable()
                    ->default('Belum ditentukan'),
                TextCol::make('team.name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextCol::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'desa' => 'Desa',
                        'kelurahan' => 'Kelurahan',
                    ]),
                SelectFilter::make('admin')
                    ->label('Admin')
                    ->relationship('admin', 'name')
                    ->searchable(),
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDesas::route('/'),
            'create' => Pages\CreateDesa::route('/create'),
            'view' => Pages\ViewDesa::route('/{record}'),
            'edit' => Pages\EditDesa::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin', 'admin_desa']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        
        if ($user->hasRole('superadmin')) {
            return true;
        }
        
        if ($user->hasRole('admin_desa')) {
            return $record->admin_id === $user->getKey();
        }
        
        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin']);
    }
}
