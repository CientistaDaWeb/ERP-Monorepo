<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ContasReceberOrdensServicos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'conta_receber_id',
        'ordem_servico_id'
    ];

    public $filters = [
    ];

    public function contaReceber()
    {
        return $this->belongsTo(ContasReceber::class);
    }

    public function ordemServico()
    {
        return $this->belongsTo(OrdensServico::class);
    }
}
