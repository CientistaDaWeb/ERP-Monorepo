<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetosAtividadesTempo extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'projeto_atividade_id',
        'data',
        'hora',
        'minutos',
        'usuario_id'
    ];

    public $filters = [
    ];

    public function projetoAtividade()
    {
        return $this->belongsTo(ProjetosAtividades::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
