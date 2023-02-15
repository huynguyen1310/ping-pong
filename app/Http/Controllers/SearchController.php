<?php

namespace App\Http\Controllers;

class SearchController extends Controller
{
    public function __invoke()
    {
        return view('search.search');
    }
}
