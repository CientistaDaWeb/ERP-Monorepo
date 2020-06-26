<?php

namespace App\Events;

use App\Change;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class logCreate
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(Model $model)
  {
    $data = [
      'action' => 'C',
      'app_id' => env('HOS_API_CLIENT_ID'),
      'options' => json_encode($model->attributesToArray()),
      'module' => get_class($model),
      'user_id' => '' //Auth()::user_id
    ];

    return Change::save($data);
  }

}
