<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->withColumns([
                            Column::make('ticket_number')->heading('Ticket Number'),
                            Column::make('ticket_date')->heading('Ticket Date'),
                            Column::make('ticket_type')->heading('Ticket Type'),
                            Column::make('customer.customer_name')->heading('Customer'),
                            Column::make('serviceLocation.service_location_name')->heading('Service Location'),
                            Column::make('location.location_name')->heading('Location'),
                            Column::make('remarks.remark_status')->heading('Status'),
                            Column::make('remarks.remark_description')->heading('Description'),
                        ]),
                ]),
        ];
    }
}
