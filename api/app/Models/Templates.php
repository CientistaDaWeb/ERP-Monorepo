<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Templates extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'nome',
        'descricao',
        'pontos',
    ];

    public $filters = [
        'nome' =>
            [
                'column' => 'nome',
                'type' => 'like'
            ],
        'descricao' =>
            [
                'column' => 'descricao',
                'type' => 'like'
            ]
    ];

    public function categoria()
    {
        return $this->belongsTo(ProjetosCategorias::class);
    }
}
