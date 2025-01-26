<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\ServiceLocation;
use App\Models\Location;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportTicket implements ToModel, WithHeadingRow
{
   public function model(array $row)
{
    // Cari atau buat tiket berdasarkan nomor tiket
    $ticket = Ticket::firstOrCreate(
        ['ticket_number' => trim($row['ticket_number'])], // Kondisi pencarian
        [ // Data baru jika tidak ditemukan
            'ticket_date' => $row['ticket_date'],
            'ticket_type' => $row['ticket_type'],
            'customer_id' => $this->createOrGetCustomer($row['customer_name']),
            'service_location_id' => $this->createOrGetServiceLocation($row['service_location_name']),
            'location_id' => $this->createOrGetLocation($row['location_name']),
        ]
    );

    return $ticket;
}

private function createOrGetCustomer(string $customerName)
{
    $customer = Customer::firstOrCreate(
        ['customer_name' => trim($customerName)]
    );
    return $customer->customer_id;
}

private function createOrGetServiceLocation(string $serviceLocationName)
{
    $serviceLocation = ServiceLocation::firstOrCreate(
        ['service_location_name' => trim($serviceLocationName)]
    );

    return $serviceLocation->service_location_id;
}

private function createOrGetLocation(string $locationName)
{
    $location = Location::firstOrCreate(
        ['location_name' => trim($locationName)],
        ['created_at' => now(), 'updated_at' => now()]
    );

    return $location->location_id;
}

}
