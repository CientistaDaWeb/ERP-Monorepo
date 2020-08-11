<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FornecedoresCategorias extends LogTrait
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

    public function fornecedores()
    {
        return $this->hasMany(Fornecedores::class, 'categoria_id', 'id');
    }

    protected $appends = ['fornecedoresCount'];

    public function getFornecedoresCountAttribute()
    {
        return $this->fornecedores()->count();
    }
}
