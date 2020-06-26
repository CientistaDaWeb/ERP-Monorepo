<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class Usuarios extends Authenticatable
{
  use Notifiable, HasApiTokens;
  use SoftDeletes;

  const CREATED_AT = 'created';
  const UPDATED_AT = 'updated';

  protected $table = 'users';

  protected $fillable = [
    'nome',
    'usuario',
    'password',
    'cargo',
    'telefone',
    'email',
    'papel',
    'token_ponto',
    'ponto',
    'ativo',
    'pis',
  ];

  public $filters = [
    'nome' =>
      [
        'column' => 'nome',
        'type' => 'like'
      ],
    'usuario' =>
      [
        'column' => 'usuario',
        'type' => 'like'
      ],
    'cargo' =>
      [
        'column' => 'cargo',
        'type' => 'like'
      ]
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function compromissos()
  {
    return $this->hasMany('App\Models\UsuariosCompromissos');
  }

  public function modulos()
  {
    return $this->hasMany('App\Models\UsuariosModulos');
  }

  public static function boot()
  {
    parent::boot();
    static::saving(function ($model) {
      if (empty($model->usuario)) {
        $model->usuario = str_slug($model->nome);
      }
    });
  }

  protected $appends = ['avatar'];

  public function getAvatarAttribute()
  {
    if (!$this->image) {
      $this->image = 'usuarios/default.png';
    }
    return Storage::temporaryUrl($this->image, now()->addDay(6));
  }

}
