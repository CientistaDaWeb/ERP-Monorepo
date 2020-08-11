<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EnderecosCategorias extends LogTrait
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

    public function enderecos()
    {
        return $this->hasMany(ClientesEnderecos::class, 'categoria_id', 'id');
    }

    protected $appends = ['enderecosCount'];

    public function getEnderecosCountAttribute()
    {
        return $this->enderecos()->count();
    }
}
