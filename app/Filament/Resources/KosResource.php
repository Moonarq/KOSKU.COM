<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KosResource\Pages;
use App\Models\Kos;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

class KosResource extends Resource
{
    protected static ?string $model = Kos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Properti Saya';
    
    protected static ?string $navigationLabel = 'Kos';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('user_id')
                ->label('User ID')
                ->default(fn () => Filament::auth()->id())
                ->disabled()
                ->dehydrated()
                ->columnSpanFull(),

            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Kos')
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
                ->label('Deskripsi Kos')
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
                ->label('Peraturan Kos')
                ->rows(3)
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('Foto Kos (Maks. 5 Gambar)')
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
        $data['user_id'] = Filament::auth()->id(); // otomatis set user_id pemilik kos
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        // Agar saat update tetap menjaga user_id sesuai owner yang login,
        // atau biarkan kalau tidak perlu overwrite saat update
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
            'index' => Pages\ListKos::route('/'),
            'create' => Pages\CreateKos::route('/create'),
            'edit' => Pages\EditKos::route('/{record}/edit'),
        ];
    }
}
