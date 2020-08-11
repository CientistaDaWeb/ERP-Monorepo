<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FornecedoresArquivos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'fornecedor_id',
        'arquivo',
        'descricao'
    ];
    public $filters = [
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class);
    }
}
