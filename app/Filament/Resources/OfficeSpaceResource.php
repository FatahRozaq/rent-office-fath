<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OfficeSpace;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OfficeSpaceResource\Pages;
use App\Filament\Resources\OfficeSpaceResource\RelationManagers;

class OfficeSpaceResource extends Resource
{
    protected static ?string $model = OfficeSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->helperText('The name of the office space')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('address')
                ->helperText('The address of the office space')
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\TextArea::make('about')
                ->helperText('The description of the office space')
                ->required()
                ->rows(10)
                ->cols(20),

                Forms\Components\Repeater::make('photos')
                ->helperText('The photos of the office space')
                ->relationship('photos')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                    ->required()
                ]),

                Forms\Components\Repeater::make('benefits')
                ->helperText('The benefits of the office space')
                ->relationship('benefits')
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                ]),

                Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\TextInput::make('duration')
                ->required()
                ->numeric()
                ->suffix('Days'),

                Forms\Components\Select::make('is_open')
                ->options([
                    true => 'Open',
                    false => 'Not Open',
                ])
                ->required(),

                Forms\Components\Select::make('is_full_booked')
                ->options([
                    true => 'Not Available',
                    false => 'Available',
                ])
                ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

                Tables\Columns\ImageColumn::make('thumbnail'),

                Tables\Columns\TextColumn::make('city.name'),

                Tables\Columns\IconColumn::make('is_full_booked')
                ->boolean()
                ->trueColor('danger')
                ->falseColor('success')
                ->trueIcon('heroicon-o-x-circle')
                ->falseIcon('heroicon-o-check-circle')
                ->label('Availability'),
            ])
            ->filters([
                SelectFilter::make('city_id')
                ->label('City')
                ->relationship('city', 'name'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficeSpaces::route('/'),
            'create' => Pages\CreateOfficeSpace::route('/create'),
            'edit' => Pages\EditOfficeSpace::route('/{record}/edit'),
        ];
    }
}
