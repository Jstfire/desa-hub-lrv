<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UIManagementResource\Pages;
use App\Models\Desa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Auth;

class UIManagementResource extends Resource
{
    protected static ?string $model = Desa::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationGroup = 'Superadmin Only';

    protected static ?string $navigationLabel = 'Kelola UI Desa';

    protected static ?string $modelLabel = 'UI Desa';

    protected static ?string $pluralModelLabel = 'UI Desa';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Desa')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Desa')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('jenis')
                            ->label('Jenis')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
                Section::make('Pengaturan Font')
                    ->schema([
                        Select::make('font_family')
                            ->label('Font Family')
                            ->options([
                                'Inter' => 'Inter',
                                'Poppins' => 'Poppins', 
                                'Montserrat' => 'Montserrat',
                                'Lato' => 'Lato',
                                'Helvetica' => 'Helvetica',
                            ])
                            ->default('Inter')
                            ->required()
                            ->helperText('Font yang akan digunakan di seluruh halaman desa'),
                    ])
                    ->columns(1),
                Section::make('Pengaturan Warna')
                    ->schema([
                        ColorPicker::make('color_primary')
                            ->label('Warna Utama (Primary)')
                            ->required()
                            ->default('#10b981')
                            ->helperText('Warna utama yang akan digunakan untuk elemen penting'),
                        ColorPicker::make('color_secondary')
                            ->label('Warna Sekunder (Secondary)')
                            ->required()
                            ->default('#3b82f6')
                            ->helperText('Warna sekunder untuk elemen pendukung'),
                    ])
                    ->columns(2)
                    ->description('Catatan: Untuk dark mode, penyesuaian UI/UX akan disesuaikan otomatis oleh sistem'),
                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk menyembunyikan situs desa dari publik'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Desa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'desa' => 'success',
                        'kelurahan' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('font_family')
                    ->label('Font')
                    ->badge()
                    ->color('gray'),
                ColorColumn::make('color_primary')
                    ->label('Warna Utama'),
                ColorColumn::make('color_secondary')
                    ->label('Warna Sekunder'),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'desa' => 'Desa',
                        'kelurahan' => 'Kelurahan',
                    ]),
                Tables\Filters\SelectFilter::make('font_family')
                    ->label('Font Family')
                    ->options([
                        'Inter' => 'Inter',
                        'Poppins' => 'Poppins',
                        'Montserrat' => 'Montserrat', 
                        'Lato' => 'Lato',
                        'Helvetica' => 'Helvetica',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Bulk actions if needed
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
            'index' => Pages\ListUIManagement::route('/'),
            'view' => Pages\ViewUIManagement::route('/{record}'),
            'edit' => Pages\EditUIManagement::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin']);
    }

    public static function canCreate(): bool
    {
        return false; // Disable creation
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole(['superadmin']);
    }

    public static function canDelete($record): bool
    {
        return false; // Cannot delete UI settings
    }
}