<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class ContasPagarCategorias extends LogTrait
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

    public function contasPagar()
    {
        return $this->hasMany(ContasPagar::class, 'categoria_id', 'id');
    }

    protected $appends = ['contasPagarCount'];

    public function getContasPagarCountAttribute()
    {
        return $this->contasPagar()->count();
    }
}
