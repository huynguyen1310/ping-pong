<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->input('page') ?? 1;
    $cacheKey = 'products:page:' . $page;

    if (Redis::get($cacheKey)) {
      $products = Redis::get($cacheKey);
      return response()->json(json_decode($products));
    }

    $products = Product::paginate(6);
    Redis::set($cacheKey, json_encode($products));
    return response()->json($products);
  }

  public function search(Request $request)
  {
    // $products = Product::select('*')->when($request->has('search'), function ($query) use ($request) {
    //   $query->where('name', 'like', '%' . $request->input('search') . '%');
    // })->paginate(6);

    //using melisearch
    $products = Product::search($request->input('search'))->paginate(6);

    return response()->json($products);
  }
}
