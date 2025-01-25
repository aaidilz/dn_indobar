<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $primaryKey = 'part_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'part_id',
        'part_name',
        'part_number',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_has_part', 'part_id', 'ticket_id');
    }
}
