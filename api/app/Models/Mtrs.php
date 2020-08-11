<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Mtrs extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $_dono;
    protected $_certificado;

    public function __construct(array $attributes = [])
    {
        $this->_dono = array(
            'P' => 'Próprio',
            'T' => 'Terceiros'
        );
        $this->_certificado = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        parent::__construct($attributes);
    }

    protected $fillable = [
        'mtr',
        'ordem_servico_id',
        'dono',
        'terceiro',
        'certificado',
        'endereco_id'
    ];

    public $filters = [
        'dono' =>
            [
                'column' => 'dono',
                'type' => 'like'
            ]
    ];

    public function ordemServico()
    {
        return $this->belongsTo(OrdensServico::class);
    }

    public function endereco()
    {
        return $this->belongsTo(ClientesEnderecos::class, 'endereco_id');
    }

    public function certificados()
    {
        return $this->hasOne(Certificados::class, 'mtr_id');
    }

    protected $appends = ['donoHumanized', 'certificadoHumanized'];

    public function getDonoHumanizedAttribute()
    {
        return $this->_dono[$this->dono];
    }

    public function getCertificadoHumanizedAttribute()
    {
        return $this->_certificado[$this->certificado];
    }
}
