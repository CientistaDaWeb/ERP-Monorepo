<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosCrm extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'projetos_crm';

    protected $fillable = [
        'projeto_id',
        'usuario_id',
        'data',
        'descricao',
        'tipo'
    ];

    public $filters = [
        'descricao' =>
            [
                'column' => 'descricao',
                'type' => 'like'
            ]
    ];

    public function projeto()
    {
        return $this->belongsTo(Projetos::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
