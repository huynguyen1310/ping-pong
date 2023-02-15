<?php

namespace App\Http\Controllers\API;

use App\Data\PongData;
use App\Http\Controllers\Controller;
use App\Models\Pong;
use Illuminate\Support\Facades\Cache;
use App\Models\Site;

class PongController extends Controller
{
  public function index()
  {
    if (Cache::has('pongs')) {
      return PongData::collection(Cache::get('pongs'));
    }

    $pongs = Cache::remember('pongs', 10, function () {
      return Pong::take(10000)->get();
    });

    return PongData::collection($pongs);
  }

  public function show(Pong $pong)
  {
    return PongData::from($pong);
  }
}
