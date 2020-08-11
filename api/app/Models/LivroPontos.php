<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class LivroPontos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'usuario_id',
        'data',
        'hora'
    ];

    protected $filter = [
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
