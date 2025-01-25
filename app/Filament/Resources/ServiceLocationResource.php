<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceLocationResource\Pages;
use App\Filament\Resources\ServiceLocationResource\RelationManagers;
use App\Models\ServiceLocation;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceLocationResource extends Resource
{
    protected static ?string $model = ServiceLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(('service_location_name'))
                    ->label(('Service Location Name'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_location_name')
                    ->label('Service Location Name')
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
            'index' => Pages\ListServiceLocations::route('/'),
            'create' => Pages\CreateServiceLocation::route('/create'),
            'edit' => Pages\EditServiceLocation::route('/{record}/edit'),
        ];
    }
}
