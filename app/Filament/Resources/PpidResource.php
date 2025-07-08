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
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class PpidResource extends Resource
{
    protected static ?string $model = Ppid::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'PPID';

    protected static ?int $navigationSort = 6;

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
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Ppid::class, 'slug', ignoreRecord: true),

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
            'index' => Pages\ListPpids::route('/'),
            'create' => Pages\CreatePpid::route('/create'),
            'edit' => Pages\EditPpid::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        return \App\Helpers\FilamentResourceHelper::getScopedResourceQuery($query);
    }
}
