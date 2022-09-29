<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Municipios extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'nome',
        'estado_id',
        'codigo'
    ];

    public $filters = [
        'codigo' =>
            [
                'column' => 'codigo',
                'type' => 'like'
            ],
        'nome' =>
            [
                'column' => 'nome',
                'type' => 'like'
            ],
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class);
    }
}
