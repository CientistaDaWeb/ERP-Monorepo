<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'documento',
        'razao_social',
        'nome_fantasia',
        'inscricao_estadual',
        'inscricao_municipal',
        'email',
        'site',
        'numero_fepan',
        'estado_id',
        'cep',
        'cidade',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'logomarca',
        'telefone',
        'telefone_2',
        'telefone_3',
        'website',
        'municipio_id'
    ];

    public $filters = [
        'razao_social' =>
            [
                'column' => 'razao_social',
                'type' => 'like'
            ],
        'nome_fantasia' =>
            [
                'column' => 'nome_fantasia',
                'type' => 'like'
            ],
        'documento' =>
            [
                'column' => 'documento',
                'type' => 'like'
            ],
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipios::class);
    }
}
