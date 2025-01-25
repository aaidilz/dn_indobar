<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnUser extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'dn_user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_has_dn_user', 'dn_user_id', 'ticket_id')
                    ->withPivot('dn_role_id')
                    ->withTimestamps();
    }
}
