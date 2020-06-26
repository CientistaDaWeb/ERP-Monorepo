<?php

namespace App\Models;

use App\Events\LogCreate;
use App\Events\LogUpdate;
use App\Events\LogDelete;
use Illuminate\Database\Eloquent\Model;

class LogTrait extends Model
{
  protected $dispatchesEvents = [
    /*
    'created' => LogCreate::class,
    'updated' => LogUpdate::class,
    'deleted' => LogDelete::class,
    */
  ];
}
