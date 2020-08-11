<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientesCategorias extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria'
    ];

    public $filters = [
        'categoria' =>
            [
                'column' => 'categoria',
                'type' => 'like'
            ]
    ];

    public function clientes()
    {
        return $this->hasMany(Clientes::class, 'categoria_id', 'id');
    }

    protected $appends = ['clientesCount'];

    public function getClientesCountAttribute()
    {
        return $this->clientes()->count();
    }
}
