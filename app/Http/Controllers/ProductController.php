<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::select('*')->when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        })->paginate(6);

        return response()->json($products);
    }
}
