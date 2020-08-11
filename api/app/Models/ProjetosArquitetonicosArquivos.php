<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosArquitetonicosArquivos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'arquitetonico_id',
        'arquivo',
        'descricao'
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

    public function arquitetonico()
    {
        return $this->belongsTo(ProjetosArquitetonicos::class);
    }
}
