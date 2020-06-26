<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clientes extends Authenticatable
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
    ];

}
