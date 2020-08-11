<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosPpci extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'projeto_id',
        'usuario_id',
        'data',
        'hora_inicial',
        'hora_final',
        'descricao',
        'arquivo'
    ];

    public $filters = [
        'arquivo' =>
            [
                'column' => 'arquivo',
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
        return $this->belongsTo(Projetos::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
