<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Abastecimentos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'aditivo_id',
        'fornecedor_id',
        'caminhao_id',
        'data',
        'litros',
        'km',
        'valor',
        'media',
        'valor_litro',
    ];

    public $filters = [
        /*
        'fornecedor' =>
          [
            'column' => 'fornecedores.razao_social',
            'type' => 'like'
          ],
        'aditivo' =>
          [
            'column' => 'aditivos.nome',
            'type' => 'like'
          ],
        'caminhao' =>
          [
            'column' => 'caminhoes.placa',
            'type' => 'like'
          ],
        */
    ];

    public function aditivo()
    {
        return $this->belongsTo(Aditivos::class);
    }

    public function caminhao()
    {
        return $this->belongsTo(Caminhoes::class);
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class);
    }
}
