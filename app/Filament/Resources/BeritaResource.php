<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Filament\Resources\BeritaResource\RelationManagers;
use App\Models\Berita;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Kelola Komponen Desa';

    protected static ?string $navigationLabel = 'Kelola Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Berita')
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
                        TextInput::make('judul')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->unique(Berita::class, 'judul', ignoreRecord: true),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Berita::class, 'slug', ignorable: fn($record) => $record)
                            ->helperText('URL yang akan digunakan untuk mengakses berita')
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
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now())
                            ->required(),
                        Toggle::make('is_highlight')
                            ->label('Berita Utama')
                            ->default(false)
                            ->helperText('Tampilkan di section berita utama'),
                    ])
                    ->columns(2),
                Section::make('Konten')
                    ->schema([
                        FileUpload::make('gambar_utama')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('berita')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Ringkasan singkat yang akan ditampilkan di daftar berita')
                            ->columnSpanFull(),
                        Textarea::make('konten')
                            ->label('Konten')
                            ->rows(8)
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('SEO & Metadata')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Judul untuk SEO (max 60 karakter)'),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Deskripsi untuk SEO (max 160 karakter)'),
                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->helperText('Kata kunci dipisahkan dengan koma'),
                    ])
                    ->columns(2),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar_utama')
                    ->label('Gambar')
                    ->circular()
                    ->size(50),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('desa.nama')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'secondary',
                        'published' => 'success',
                        'archived' => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('is_highlight')
                    ->label('Utama')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('desa')
                    ->label('Desa')
                    ->relationship('desa', 'nama')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->multiple(),
                TernaryFilter::make('is_highlight')
                    ->label('Berita Utama')
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak')
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'view' => Pages\ViewBerita::route('/{record}'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
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
