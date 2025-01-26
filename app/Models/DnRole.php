<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnRole extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'dn_role_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'role_name',
    ];
}
