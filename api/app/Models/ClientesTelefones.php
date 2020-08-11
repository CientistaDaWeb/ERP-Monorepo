<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientesTelefones extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'cliente_id',
        'categoria_id',
        'telefone',
        'informacao',
        'email',
        'contato',
        'padrao'
    ];

    public $filters = [
        'telefone' =>
            [
                'column' => 'telefone',
                'type' => 'like'
            ],
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function categoria()
    {
        return $this->belongsTo(TelefonesCategorias::class);
    }
}
