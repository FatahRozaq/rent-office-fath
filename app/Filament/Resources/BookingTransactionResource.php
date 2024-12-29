<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->helperText('The name of customer')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('booking_trx_id')
                ->helperText('The booking transaction id')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                ->helperText('The phone number of customer')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('total_amount')
                ->helperText('The total amount of transaction')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\TextInput::make('duration')
                ->helperText('The duration of transaction')
                ->required()
                ->numeric()
                ->prefix('Days'),

                Forms\Components\DatePicker::make('started_at')
                ->helperText('The start date of transaction')
                ->required(),

                Forms\Components\DatePicker::make('ended_at')
                ->helperText('The end date of transaction')
                ->required(),

                Forms\Components\Select::make('is_paid')
                ->helperText('Is the transaction paid?')
                ->required()
                ->options([
                    true => 'Paid',
                    false => 'Not Paid',
                ]),

                Forms\Components\Select::make('office_space_id')
                ->helperText('The office space of transaction')
                ->relationship('officeSpace', 'name')
                ->searchable()
                ->preload()
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

                Tables\Columns\TextColumn::make('booking_trx_id')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('officeSpace.name')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('started_at')
                ->searchable()
                ->sortable(),

                Tables\Columns\IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Sudah Bayar?')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
