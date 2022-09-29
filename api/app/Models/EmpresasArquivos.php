<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresasArquivos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'empresa_id',
        'arquivo',
        'descricao'
    ];

    public $filters = [
    ];

    public function categoria()
    {
        return $this->belongsTo(EmpresasArquivosCategorias::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }
}
