<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientesCrm extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'clientes_crm';

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'data',
        'descricao',
        'status'
    ];

    public $filters = [
        'descricao' =>
            [
                'column' => 'descricao',
                'type' => 'like'
            ],
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
