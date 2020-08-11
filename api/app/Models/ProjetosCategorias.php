<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosCategorias extends LogTrait
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
            ],
    ];

    public function projetos()
    {
        return $this->hasMany(Projetos::class, 'categoria_id', 'id');
    }

    protected $appends = ['projetosCount'];

    public function getProjetosCountAttribute()
    {
        return $this->projetos()->count();
    }
}
