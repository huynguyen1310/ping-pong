<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function __construct(public CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public function addItem(Request $request)
  {
    $product = Product::where('id', $request->get('product_id'))->first();
    $this->cartService->addItem($product);

    return response()->json(['success' => true]);
  }

  public function removeItem(Request $request)
  {
    $product = Product::where('id', $request->get('product_id'))->first();
    $this->cartService->removeItem($product);

    return response()->json(['success' => true]);
  }

  public function updateQuantity(Request $request)
  {
    $this->cartService->updateQuantity($request->get('product_id'), $request->get('quantity'));

    return response()->json(['success' => true]);
  }

  public function getCart()
  {
    $cart = $this->cartService->getCart(request());

    return response()->json(['data' => $cart]);
  }
}
