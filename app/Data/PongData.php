<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PongData extends Data
{
  public function __construct(
    public string $name
  ) {
  }
}
