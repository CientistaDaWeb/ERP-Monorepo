<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Aditivos extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'nome'
    ];

    public $filters = [
        'nome' =>
            [
                'column' => 'nome',
                'type' => 'like'
            ]
    ];

    public function abastecimentos()
    {
        return $this->hasMany(Abastecimentos::class, 'aditivo_id');
    }

}
