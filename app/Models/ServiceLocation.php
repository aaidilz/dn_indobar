<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_location_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'service_location_id',
        'service_location_name',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'service_location_id', 'service_location_id');
    }
}
