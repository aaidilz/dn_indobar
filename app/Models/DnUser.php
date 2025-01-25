<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'dn_user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dn_user_id',
        'username',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_has_dn_user', 'dn_user_id', 'ticket_id')
                    ->withPivot('dn_role_id')
                    ->withTimestamps();
    }
}
