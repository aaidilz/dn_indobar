<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class DnRole extends Model
{
    use HasFactory;

    protected $primaryKey = 'dn_role_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dn_role_id',
        'role_name',
    ];
}
