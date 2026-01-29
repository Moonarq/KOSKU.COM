<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationGroup = 'Manajemen Properti';
    
    protected static ?string $navigationLabel = 'Penilaian';
    
    protected static ?string $modelLabel = 'Penilaian';
    
    protected static ?string $pluralModelLabel = 'Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kos_id')
                    ->relationship('kos', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengirim')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\Select::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '⭐ 1 Bintang',
                        2 => '⭐⭐ 2 Bintang',
                        3 => '⭐⭐⭐ 3 Bintang',
                        4 => '⭐⭐⭐⭐ 4 Bintang',
                        5 => '⭐⭐⭐⭐⭐ 5 Bintang',
                    ])
                    ->required()
                    ->disabled(),
                Forms\Components\Textarea::make('comment')
                    ->label('Komentar')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\FileUpload::make('images')
                    ->label('Foto (Opsional)')
                    ->image()
                    ->multiple()
                    ->maxFiles(5)
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\Textarea::make('reply')
                    ->label('Balasan Owner')
                    ->rows(4)
                    ->columnSpanFull()
                    ->placeholder('Tulis balasan untuk penyewa...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kos.name')
                    ->label('Nama Properti')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('reply')
                    ->label('Balasan')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Foto')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Filament::auth()->user();

        if ($user && $user->role === 'owner') {
            $query->whereHas('kos', fn (Builder $q) => $q->where('user_id', $user->id));
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'owner';
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
