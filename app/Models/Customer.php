<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_serial_number',
        'customer_uid',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id', 'customer_id');
    }
}
