<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'location_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'location_name',
        'city',
        'province',
        'district',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'location_id', 'location_id');
    }
}
