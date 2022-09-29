<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Textos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria_id',
        'titulo',
        'descricao',
    ];

    public $filters = [
        'titulo' =>
            [
                'column' => 'titulo',
                'type' => 'like'
            ],
    ];

    public function categoria()
    {
        return $this->belongsTo(TextosCategorias::class);
    }
}
