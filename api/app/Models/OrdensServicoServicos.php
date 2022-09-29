<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrdensServicoServicos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'servico_id',
        'ordem_servico_id',
        'qtde',
        'valor'
    ];

    public $filters = [];

    public function servico()
    {
        return $this->belongsTo(Servicos::class);
    }

    public function ordemServico()
    {
        return $this->belongsTo(OrdensServico::class);
    }
}
