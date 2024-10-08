<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\App\Resources\OrderResource\Pages;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('customer_id')
                ->label('Customer')
                ->required()
                ->options(fn() => Customer::pluck('first_name', 'id')->toArray())
                ->reactive(),

            Forms\Components\DatePicker::make('order_date')
                ->label('Order Date')
                ->required(),

            Forms\Components\TextInput::make('total_amount')
                ->label('Total Amount')
                ->required()
                ->numeric(),

            Forms\Components\Select::make('payment_status')
                ->label('Payment Status')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ]),

            Forms\Components\Select::make('shipping_status')
                ->label('Shipping Status')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'returned' => 'Returned',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('customer.first_name')
                ->label('Customer'),
            Tables\Columns\TextColumn::make('order_date')
                ->label('Order Date'),
            Tables\Columns\TextColumn::make('total_amount')
                ->label('Total Amount'),
            Tables\Columns\TextColumn::make('payment_status')
                ->label('Payment Status'),
            Tables\Columns\TextColumn::make('shipping_status')
                ->label('Shipping Status'),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
