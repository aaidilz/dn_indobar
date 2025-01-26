<?php

namespace App\Filament\Resources\TicketRemarkResource\Pages;

use App\Filament\Resources\TicketRemarkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketRemark extends EditRecord
{
    protected static string $resource = TicketRemarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
