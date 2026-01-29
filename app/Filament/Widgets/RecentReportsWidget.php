<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentReportsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Reports';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public static function canView(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Report::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'in_progress',
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Report $record): string => "/admin/reports/{$record->id}"),
            ])
            ->emptyStateHeading('No recent reports')
            ->emptyStateDescription('When users submit reports, they will appear here.')
            ->emptyStateIcon('heroicon-o-document-text');
    }
}
