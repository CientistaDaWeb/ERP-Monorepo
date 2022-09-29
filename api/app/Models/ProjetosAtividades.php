<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosAtividades extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'projeto_id',
        'categoria_id',
        'nome',
        'descricao',
        'pontos',
        'status'
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

    public function projeto()
    {
        return $this->belongTo(Projetos::class);
    }

    public function categoria()
    {
        return $this->belongsTo(ProjetosCategorias::class);
    }
}
