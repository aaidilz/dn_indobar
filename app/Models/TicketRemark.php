<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketRemark extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'remark_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ticket_id',
        'remark_date',
        'remark_status',
        'remark_description',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }
}
