<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class NotasProjetos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'numero',
        'cliente',
        'data_emissao',
        'valor',
        'valor_retido'
    ];

    public $filters = [
    ];
}
