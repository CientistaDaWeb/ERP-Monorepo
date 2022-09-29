<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientesEnderecos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'cliente_id',
        'categoria_id',
        'estado_id',
        'municipio_id',
        'cep',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'coordenadas',
        'imagem'
    ];

    public $filters = [
        'endereco' =>
            [
                'column' => 'endereco',
                'type' => 'like'
            ],
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }

    public function categoria()
    {
        return $this->belongsTo(EnderecosCategorias::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipios::class);
    }

    protected $appends = ['position', 'infoText', 'fachada'];

    public function getPositionAttribute()
    {
        if (!empty($this->coordenadas)):
            $position = explode(',', $this->coordenadas);
            return [
                'lat' => (float)$position[0],
                'lng' => (float)$position[1]
            ];
        endif;
    }

    public function getInfoTextAttribute()
    {
        return $this->cliente->razao_social . ' (' . $this->categoria->categoria . ')';
    }

    public function getFachadaAttribute()
    {
        if ($this->imagem) {
            return 'http://acquasana.com.br/storage/imagem/' . $this->imagem . '/clientes-enderecos?w=300&h=300';
        }
    }
}
