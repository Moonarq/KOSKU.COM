<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use App\Models\User;
use App\Mail\ReportStatusUpdate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Reports';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getRecordUrl(\Illuminate\Database\Eloquent\Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $pendingCount = static::getModel()::where('status', 'pending')->count();
        return $pendingCount > 0 ? 'warning' : null;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Select::make('category')
                            ->options([
                                'account' => 'Account Issues',
                                'payment' => 'Payment Problems', 
                                'technical' => 'Technical Problems',
                                'other' => 'Other'
                            ])
                            ->required()
                            ->disabled(),
                        Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High'
                            ])
                            ->required()
                            ->disabled(),
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Textarea::make('message')
                            ->required()
                            ->rows(4)
                            ->disabled(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Admin Response')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed'
                            ])
                            ->required(),
                        Textarea::make('admin_notes')
                            ->rows(3)
                            ->placeholder('Add notes about this report...'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn (Report $record): string => static::getUrl('view', ['record' => $record])
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'account' => 'info',
                        'payment' => 'warning',
                        'technical' => 'danger',
                        'other' => 'gray',
                    }),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning', 
                        'high' => 'danger',
                    }),
            
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'resolved' => 'success',
                        'closed' => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress', 
                        'resolved' => 'Resolved',
                        'closed' => 'Closed'
                    ]),
                SelectFilter::make('category')
                    ->options([
                        'account' => 'Account Issues',
                        'payment' => 'Payment Problems',
                        'technical' => 'Technical Problems', 
                        'other' => 'Other'
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High'
                    ]),
            ])
            ->actions([
                Action::make('markAsRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->action(function (Report $record) {
                        $record->markAsRead(Auth::id());
                        Notification::make()
                            ->title('Report marked as read')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Report $record) => is_null($record->read_at)),
                Tables\Actions\EditAction::make(),
                Action::make('quickStatus')
                    ->label('Quick Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->form([
                        Select::make('status')
                            ->label('Change Status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed'
                            ])
                            ->default(fn (Report $record) => $record->status)
                            ->required(),
                    ])
                    ->action(function (array $data, Report $record) {
                        $record->update([
                            'status' => $data['status'],
                            'admin_id' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Status updated successfully')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Quick Status Change')
                    ->modalSubmitActionLabel('Update Status'),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Reports are created from frontend form only
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Report Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Reporter Name')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable()
                            ->icon('heroicon-o-envelope'),
                        TextEntry::make('category')
                            ->label('Category')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'account' => 'info',
                                'payment' => 'warning',
                                'technical' => 'danger',
                                'other' => 'gray',
                            }),
                        TextEntry::make('priority')
                            ->label('Priority')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'low' => 'success',
                                'medium' => 'warning', 
                                'high' => 'danger',
                            }),
                        TextEntry::make('subject')
                            ->label('Subject')
                            ->weight(FontWeight::Medium),
                        TextEntry::make('message')
                            ->label('Message')
                            ->markdown()
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime()
                            ->since(),
                    ])
                    ->columns(2),

                Section::make('Admin Response')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'in_progress' => 'info',
                                'resolved' => 'success',
                                'closed' => 'gray',
                            }),
                        TextEntry::make('admin.name')
                            ->label('Handled By')
                            ->default('Not assigned')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->default('No notes yet')
                            ->markdown()
                            ->columnSpanFull(),
                        TextEntry::make('read_at')
                            ->label('Read At')
                            ->formatStateUsing(fn ($state) => $state ? $state->format('M d, Y H:i') : 'Not read yet')
                            ->color(fn ($state) => $state ? 'success' : 'warning'),
                    ])
                    ->columns(2),
            ]);
    }
}
