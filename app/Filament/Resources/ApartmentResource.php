<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApartmentResource\Pages;
use App\Filament\Resources\ApartmentResource\RelationManagers;
use App\Models\Apartment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Properti Saya';
    
    protected static ?string $navigationLabel = 'Apartment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label('User ID')
                    ->default(fn () => auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->columnSpanFull(),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Apartment')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Harga per Bulan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                    ]),

                Forms\Components\TextInput::make('contact_person')
                    ->label('Kontak Pemilik')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Apartment')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\CheckboxList::make('facilities')
                    ->label('Fasilitas')
                    ->options([
                        'wifi' => 'Wi-Fi',
                        'ac' => 'AC',
                        'parking' => 'Parkir',
                        'laundry' => 'Laundry',
                        'security' => 'Keamanan 24 Jam',
                        'kitchen' => 'Dapur',
                        'TV' => 'TV',
                    ])
                    ->columns(2)
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('rules')
                    ->label('Peraturan Apartment')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Foto Apartment (Maks. 5 Gambar)')
                    ->image()
                    ->multiple()
                    ->maxFiles(6)
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\Radio::make('gender')
                    ->label('Jenis Kelamin Penghuni')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                        'mixed' => 'Campuran',
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->getStateUsing(fn ($record) => is_array($record->image) ? ($record->image[0] ?? null) : null),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_person')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user && $user->isOwner()) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
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
            'index' => Pages\ListApartments::route('/'),
            'create' => Pages\CreateApartment::route('/create'),
            'edit' => Pages\EditApartment::route('/{record}/edit'),
        ];
    }
}
