<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosArquitetonicos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'projeto_id',
        'data_recebimento',
        'descricao'
    ];

    public $filters = [];

    public function projeto()
    {
        return $this->belongsTo(Projetos::class);
    }
}
