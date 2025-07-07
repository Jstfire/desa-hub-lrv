<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorResource\Pages;
use App\Models\Desa;
use App\Models\Visitor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analitik';

    protected static ?string $navigationLabel = 'Pengunjung';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::today()->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Pengunjung hari ini';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->options(Desa::query()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('ip_address')
                    ->label('Alamat IP')
                    ->required()
                    ->maxLength(45),

                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->maxLength(255),

                Forms\Components\TextInput::make('halaman')
                    ->label('Halaman yang Dikunjungi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('referrer')
                    ->label('Referrer')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('desa.nama')
                    ->label('Desa/Kelurahan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('Alamat IP')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('halaman')
                    ->label('Halaman')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('created_at')
                    ->label('Waktu Kunjungan')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('referrer')
                    ->label('Referrer')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
            ])
            ->filters([
                SelectFilter::make('desa_id')
                    ->label('Desa/Kelurahan')
                    ->relationship('desa', 'nama'),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['dari_tanggal'] ?? null) {
                            $indicators['dari_tanggal'] = 'Dari: ' . $data['dari_tanggal'];
                        }

                        if ($data['sampai_tanggal'] ?? null) {
                            $indicators['sampai_tanggal'] = 'Sampai: ' . $data['sampai_tanggal'];
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Bulk actions removed for visitor data to maintain integrity
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
            'index' => Pages\ListVisitors::route('/'),
            'view' => Pages\ViewVisitor::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        try {
            $user = Auth::user();

            // If no user is authenticated, return the base query
            if (!$user) {
                return $query;
            }

            // For IDE static analysis, we'll check using database queries rather than the trait methods
            // Check if user is superadmin
            $isSuperAdmin = Role::where('name', 'superadmin')
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('model_id', $user->id);
                })
                ->exists();

            if ($isSuperAdmin) {
                return $query;
            }

            // Check if user is admin_desa or operator_desa
            $isDesaAdmin = Role::whereIn('name', ['admin_desa', 'operator_desa'])
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('model_id', $user->id);
                })
                ->exists();

            if ($isDesaAdmin) {
                // Get desa IDs for the user
                $desaIds = $user->ownedTeams->pluck('id')->merge(
                    $user->teams->pluck('id')
                )->unique()->toArray();

                // Return query filtered by desa
                return $query->whereIn('desa_id', $desaIds);
            }
        } catch (\Exception $e) {
            // Log the error but don't crash
            Log::error('Error in VisitorResource query: ' . $e->getMessage());
        }

        // Default fallback
        return $query;
    }

    // Widgets for visitor analytics
    public static function getWidgets(): array
    {
        return [
            VisitorResource\Widgets\VisitorStats::class,
        ];
    }
}
