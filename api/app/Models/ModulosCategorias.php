<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ModulosCategorias extends LogTrait
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'categoria',
        'ordem',
        'icon'
    ];

    public $filters = [
        'categoria' =>
            [
                'column' => 'categoria',
                'type' => 'like'
            ]
    ];

    public function modulos()
    {
        return $this->hasMany(Modulos::class, 'categoria_id', 'id');
    }

    protected $appends = ['modulosCount'];

    public function getModulosCountAttribute()
    {
        return $this->modulos()->count();
    }
}
