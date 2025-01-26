<?php

namespace App\Filament\Resources\TicketRemarkResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Guava\FilamentModalRelationManagers\Concerns\CanBeEmbeddedInModals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TicketRemarkRelationManager extends RelationManager
{
    use CanBeEmbeddedInModals;
    protected static string $relationship = 'remarks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               DatePicker::make('remark_date')
                    ->label('Remark Date')
                    ->required(),
                TextInput::make('remark_status')
                    ->label('Remark Status')
                    ->required(),
                Textarea::make('remark_description')
                    ->label('Remark Description')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('remark_date')
                    ->label('Remark Date')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark_status')
                    ->label('Remark Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark_description')
                    ->label('Remark Description')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            //     Tables\Actions\DeleteAction::make(),
            // ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            ]);
    }
}
