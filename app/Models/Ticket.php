<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'ticket_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'service_location_id',
        'location_id',
        'ticket_date',
        'ticket_type',
        'problem_description',
        'resolution_description',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function serviceLocation()
    {
        return $this->belongsTo(ServiceLocation::class, 'service_location_id', 'service_location_id');
    }

    public function remarks()
    {
        return $this->hasMany(TicketRemark::class, 'ticket_id', 'ticket_id');
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'ticket_has_part', 'ticket_id', 'part_id');
    }

    public function dnUsers()
    {
        return $this->belongsToMany(DnUser::class, 'ticket_has_dn_user', 'ticket_id', 'dn_user_id')
                    ->withPivot('dn_role_id')
                    ->withTimestamps();
    }
}
