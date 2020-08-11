<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Servicos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'servico',
        'valor_unitario',
        'descricao',
        'certificado',
        'tipo',
        'unidade'
    ];

    public $filters = [
        'servico' =>
            [
                'column' => 'servico',
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
        return $this->belongsTo(ServicosCategorias::class);
    }
}
