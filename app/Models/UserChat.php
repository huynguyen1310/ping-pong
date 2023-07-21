<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChat extends Pivot
{
  protected $table = 'user_chat';
  protected $primaryKey = 'null';
  public $incrementing = false;
  public $timestamps = true;
}
