<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePongRequest;
use App\Http\Requests\UpdatePongRequest;
use App\Models\Pong;
use Illuminate\Support\Facades\Cache;

class PongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cache::has('pongs')) {
            return view('pongs', ['pongs' => Cache::get('pongs')]);
        }

        Cache::forever('hereForever', 'forever');

        $pongs = Cache::remember('pongs', 3000, function () {
            return Pong::all()->toArray();
        });

        return view('pongs', ['pongs' => $pongs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePongRequest $request)
    {
    //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Pong $pong)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Pong $pong)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePongRequest $request, Pong $pong)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pong $pong)
    {
    //
    }
}
