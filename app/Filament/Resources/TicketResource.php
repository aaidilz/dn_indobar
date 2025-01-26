<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketRemarkResource\RelationManagers\TicketRemarkRelationManager;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Customer;
use App\Models\Location;
use App\Models\ServiceLocation;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Guava\FilamentModalRelationManagers\Actions\Table\RelationManagerAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Response;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ticket_number')
                    ->label('Ticket Number')
                    ->required(),
                DatePicker::make('ticket_date')
                    ->label('Date')
                    ->required(),
                TextInput::make('ticket_type')
                    ->label('Ticket Type')
                    ->required(),
                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'customer_name')
                    ->createOptionForm([
                        TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->required(),
                        TextInput::make('customer_serial_number')
                            ->label('Serial Number')
                            ->required(),
                        TextInput::make('customer_uid')
                            ->label('Customer UID')
                            ->required(),
                    ]),
                Select::make('service_location_id')
                    ->label('Service Location')
                    ->relationship('serviceLocation', 'service_location_name')
                    ->createOptionForm([
                        TextInput::make('service_location_name')
                            ->label('Service Location Name')
                            ->required()
                    ]),
                Select::make('location_id')
                    ->label('Location')
                    ->relationship('location', 'location_name')
                    ->createOptionForm([
                        TextInput::make('location_name')
                            ->label('Location Name')
                            ->required(),
                        TextInput::make('city')
                            ->label('City')
                            ->required(),
                        TextInput::make('province')
                            ->label('Province')
                            ->required(),
                        TextInput::make('district')
                            ->label('District')
                            ->required(),
                    ]),
                Textarea::make('problem_description')
                    ->label('Problem Description')
                    ->columnSpan(2),
                Textarea::make('resolution_description')
                    ->label('Resolution Description')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ticket_date')
                    ->label('Date')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ticket_type')
                    ->label('Ticket Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('servicelocation.service_location_name')
                    ->label('Service Location')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location.location_name')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remarks.remark_status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remarks.remark_date')
                    ->label('Remark Date')
                    ->searchable(),
                TextColumn::make('remarks.remark_description')
                    ->label('Remark')
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('aging')
                    ->label('Aging')
                    ->getStateUsing(function ($record) {
                        // Periksa apakah remarks ada
                        $remarkDate = optional($record->remarks)->remark_date;
                        $ticketDate = $record->ticket_date;
                    
                        // Jika salah satu tanggal tidak ada, kembalikan 'N/A'
                        if (!$remarkDate || !$ticketDate) {
                            return;
                        }
                    
                        // Hitung selisih hari menggunakan Carbon
                        $aging = abs(Carbon::parse($ticketDate)->diffInDays($remarkDate));

                        // remove negative value
                        
                    
                        return $aging . ' days';
                    })
                    
                    ->sortable(),

            ])
            ->filters([
                Filter::make('ticket_type')
                    ->label('Ticket Type')
                    ->form([
                        Select::make('ticket_type')
                            ->placeholder('Any')
                            ->options(
                                Ticket::query()
                                    ->select('ticket_type')
                                    ->distinct()
                                    ->get()
                                    ->pluck('ticket_type', 'ticket_type') // Menggunakan key-value array
                                    ->toArray() // Konversi ke array
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['ticket_type'])) {
                            $query->where('ticket_type', $data['ticket_type']);
                        }
                        return $query;
                    }),

                Filter::make('customer_name')
                    ->label('Customer Name')
                    ->form([
                        Select::make('customer_name')
                            ->placeholder('Any')
                            ->options(
                                Customer::query()
                                    ->select('customer_id', 'customer_name')
                                    ->distinct()
                                    ->get()
                                    ->pluck('customer_name', 'customer_id')
                                    ->toArray()
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['customer_name'])) {
                            $query->whereHas('customer', function (Builder $customerQuery) use ($data) {
                                $customerQuery->where('customer_id', $data['customer_name']);
                            });
                        }
                        return $query;
                    }),
                    Filter::make('location_name')
                    ->label('Location Name')
                    ->form([
                        Select::make('location_name')
                            ->placeholder('Any')
                            ->options(
                                Location::query()
                                    ->select('location_id', 'location_name')
                                    ->distinct()
                                    ->get()
                                    ->pluck('location_name', 'location_id')
                                    ->toArray()
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['location_name'])) {
                            $query->whereHas('location', function (Builder $locationQuery) use ($data) {
                                $locationQuery->where('location_id', $data['location_name']);
                            });
                        }
                        return $query;
                    }),

                    Filter::make('service_location_name')
                    ->label('Service Location Name')
                    ->form([
                        Select::make('service_location_name')
                            ->placeholder('Any')
                            ->options(
                                ServiceLocation::query()
                                    ->select('service_location_id', 'service_location_name')
                                    ->distinct()
                                    ->get()
                                    ->pluck('service_location_name', 'service_location_id')
                                    ->toArray()
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['service_location_name'])) {
                            $query->whereHas('serviceLocation', function (Builder $serviceLocationQuery) use ($data) {
                                $serviceLocationQuery->where('service_location_id', $data['service_location_name']);
                            });
                        }
                        return $query;
                    }),


            ])
            ->actions([
                RelationManagerAction::make('remarks')
                    ->label('edit remark') // This will be shown when clicked or for accessibility
                    ->tooltip(fn($record) => "Remarks for Ticket: {$record->ticket_number}") // Tooltip for context
                    ->relationManager(TicketRemarkRelationManager::class),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->label('Export to Excel')
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TicketRemarkRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
