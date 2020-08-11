<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Projetos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'construtora_id',
        'arquiteto_id',
        'nome',
        'proprietario',
        'endereco',
        'observacoes',
        'diretorio',
        'numero_protocolo',
        'status_ppci',
        'status_hidro'
    ];

    public $filters = [
        'nome' =>
            [
                'column' => 'nome',
                'type' => 'like'
            ]
    ];

    public function categoria()
    {
        return $this->belongsTo(ProjetosCategorias::class);
    }

    public function construtora()
    {
        return $this->belongsTo(Construtoras::class);
    }

    public function arquiteto()
    {
        return $this->belongsTo(Arquitetos::class);
    }

    public function alteracoes()
    {
        return $this->hasMany(ProjetosAlteracoes::class);
    }

    public function atividades()
    {
        return $this->hasMany(ProjetosAtividades::class);
    }

    public function ultimaInteracao()
    {
        return $this->hasOne(ProjetosCrm::class, 'projeto_id', 'id')->orderBy('data', 'DESC');
    }
}
