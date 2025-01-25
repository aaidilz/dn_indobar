<?php

namespace App\Filament\Resources\TicketRemarkResource\Pages;

use App\Filament\Resources\TicketRemarkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketRemarks extends ListRecords
{
    protected static string $resource = TicketRemarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
