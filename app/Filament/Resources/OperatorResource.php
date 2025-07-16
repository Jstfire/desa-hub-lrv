<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatorResource\Pages;
use App\Models\User;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class OperatorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $navigationLabel = 'Kelola Operator';

    protected static ?string $modelLabel = 'Operator';

    protected static ?string $pluralModelLabel = 'Operator';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->whereHas('roles', function ($query) {
            $query->where('name', 'operator_desa');
        });

        // If user is admin_desa, only show operators from their village
        $user = Auth::user();
        if ($user && $user->hasRole('admin_desa')) {
            $query->where('desa_id', $user->desa_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Operator')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'email', ignorable: fn($record) => $record),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->helperText('Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.'),
                    ])
                    ->columns(2),
                Section::make('Penugasan Desa')
                    ->schema([
                        Select::make('desa_id')
                            ->label('Desa')
                            ->relationship('desa', 'nama')
                            ->options(function () {
                                // If user is admin_desa, only show their village
                                $user = Auth::user();
                                if ($user && $user->hasRole('admin_desa')) {
                                    return Desa::where('id', $user->desa_id)->pluck('nama', 'id');
                                }
                                // If superadmin, show all villages
                                return Desa::all()->pluck('nama', 'id');
                            })
                            ->searchable()
                            ->required()
                            ->helperText('Pilih desa tempat operator akan bertugas'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk mencegah operator login'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Aktif' : 'Nonaktif'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('desa')
                    ->label('Desa')
                    ->relationship('desa', 'nama')
                    ->searchable()
                    ->visible(fn() => Auth::user()?->hasRole('superadmin')),
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(User $record) => $record->getKey() !== Auth::id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->getKey() !== Auth::id()) {
                                    $record->delete();
                                }
                            });
                        }),
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
            'index' => Pages\ListOperators::route('/'),
            'create' => Pages\CreateOperator::route('/create'),
            'view' => Pages\ViewOperator::route('/{record}'),
            'edit' => Pages\EditOperator::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->hasAnyRole(['superadmin', 'admin_desa']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && $user->hasAnyRole(['superadmin', 'admin_desa']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user && $user->hasAnyRole(['superadmin', 'admin_desa']);
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && $user->hasAnyRole(['superadmin', 'admin_desa']) &&
            $record->getKey() !== Auth::id();
    }
}
