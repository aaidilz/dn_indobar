<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'location_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'location_id',
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
