<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedores extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'documento',
        'razao_social',
        'nome_fantasia',
        'inscricao_estadual',
        'inscricao_municipal',
        'email',
        'numero_fepan',
        'estado_id',
        'cep',
        'cidade',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'telefone',
        'telefone2',
        'telefone3',
        'banco',
        'agencia',
        'conta_corrente'
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

    ];

    public function categoria()
    {
        return $this->belongsTo(FornecedoresCategorias::class);
    }

    public function contasPagar()
    {
        return $this->hasMany(ContasPagar::class, 'fornecedor_id', 'id');
    }

    protected $appends = ['contasPagarCount'];

    public function getContasPagarCountAttribute()
    {
        return $this->contasPagar()->count();
    }

}
