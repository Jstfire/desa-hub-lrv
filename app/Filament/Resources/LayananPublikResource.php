<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananPublikResource\Pages;
use App\Filament\Resources\LayananPublikResource\RelationManagers;
use App\Models\LayananPublik;
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
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn as TextCol;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Auth;

class LayananPublikResource extends Resource
{
    protected static ?string $model = LayananPublik::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $navigationLabel = 'Kelola Layanan Publik';

    protected static ?string $modelLabel = 'Layanan Publik';

    protected static ?string $pluralModelLabel = 'Layanan Publik';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Layanan')
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
                            ->preload(),
                        TextInput::make('nama')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Penjelasan singkat tentang layanan ini'),
                        TextInput::make('link')
                            ->label('Link Layanan')
                            ->url()
                            ->nullable()
                            ->helperText('URL untuk mengakses layanan (opsional)'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Layanan aktif akan ditampilkan di halaman publik'),
                    ])
                    ->columns(2),
                Section::make('Konten Tambahan')
                    ->schema([
                        FileUpload::make('icon')
                            ->label('Ikon Layanan')
                            ->image()
                            ->directory('layanan-publik')
                            ->maxSize(1024)
                            ->imageEditor()
                            ->nullable(),
                        RichEditor::make('konten')
                            ->label('Konten Detail')
                            ->nullable()
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ]),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')
                    ->label('Ikon')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('/images/default-service.png'),
                TextCol::make('nama')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextCol::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),
                TextCol::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (TextCol $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextCol::make('link')
                    ->label('Link')
                    ->limit(30)
                    ->url(fn($record) => $record->link)
                    ->openUrlInNewTab(),
                TextCol::make('is_active')
                    ->label('Status')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Aktif' : 'Nonaktif'),
                TextCol::make('user.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextCol::make('created_at')
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
                    ->multiple(),
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
            'index' => Pages\ListLayananPubliks::route('/'),
            'create' => Pages\CreateLayananPublik::route('/create'),
            'view' => Pages\ViewLayananPublik::route('/{record}'),
            'edit' => Pages\EditLayananPublik::route('/{record}/edit'),
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
