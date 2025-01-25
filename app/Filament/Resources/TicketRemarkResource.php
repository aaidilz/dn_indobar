<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketRemarkResource\Pages;
use App\Filament\Resources\TicketRemarkResource\RelationManagers;
use App\Models\TicketRemark;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketRemarkResource extends Resource
{
    protected static ?string $model = TicketRemark::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'DB';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                    ->label('Ticket')
                    ->relationship('ticket', 'ticket_number')
                    ->required(),
                DatePicker::make('remark_date')
                    ->label('Date')
                    ->required(),
                TextInput::make('remark_status')
                    ->label('Status')
                    ->required(),
                TextInput::make('remark_description')
                    ->label('Description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket.ticket_number')
                    ->label('Ticket')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark_date')
                    ->label('Date')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark_status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark_description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListTicketRemarks::route('/'),
            'create' => Pages\CreateTicketRemark::route('/create'),
            'edit' => Pages\EditTicketRemark::route('/{record}/edit'),
        ];
    }
}
