<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Imports\ImportTicket;
use EightyNine\ExcelImport\ExcelImportAction;
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
                            Column::make('customer.customer_name')->heading('customer_name'),
                            Column::make('serviceLocation.service_location_name')->heading('service_location_name'),
                            Column::make('location.location_name')->heading('location_name'),
                            Column::make('remarks.remark_status')->heading('remark_status'),
                            Column::make('remarks.remark_description')->heading('Remark Description')
                            ->formatStateUsing(function ($record) {
                                // Ambil semua remarks dari relasi
                                $remarks = $record->remarks()->get(); // Pastikan ini menjadi koleksi
                        
                                // Format setiap remark menjadi string
                                return $remarks->map(function ($remark) {
                                    return "date:{$remark->remark_date} : status:{$remark->remark_status} : description:{$remark->remark_description}";
                                })->join(' // '); // Gabungkan semua remark dengan `//`
                            }),
                        
                        ]),
                ]),

            ExcelImportAction::make()
                ->slideOver()
                ->color('primary')
                ->use(ImportTicket::class),
        ];
    }
}
