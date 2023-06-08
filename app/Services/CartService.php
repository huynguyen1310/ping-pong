<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartService
{
  public function addItem(Product $product)
  {
    $userId = '1';
    $cartKey = "cart:$userId";

    $cartData = Redis::get($cartKey);
    $cart = $cartData ? json_decode($cartData, true) : [];

    if (array_search($product->id, array_column($cart, 'id')) === false) {
      $cart[] = [
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => 1
      ];
    } else {
      foreach ($cart as $index => $element) {
        if ($element['id'] == $product->id) {
          $element['quantity'] += 1;
          $cart[$index] = $element;
        }
      };
    }

    // Store the updated cart data in Redis
    Redis::set($cartKey, json_encode($cart));

    return true;
  }

  public function removeItem(Product $product)
  {
    $userId = '1';
    $cartKey = "cart:$userId";

    $cartData = Redis::get($cartKey);
    $cart = $cartData ? json_decode($cartData, true) : [];

    // Remove the item with the specified ID from the cart
    $itemId = $product->id;

    $cart = array_filter($cart, function ($item) use ($itemId) {
      return $item['id'] !== $itemId;
    });

    $cart = array_values($cart);

    // Store the updated cart data in Redis
    Redis::set($cartKey, json_encode($cart));

    return true;
  }

  public function updateQuantity(String $id, Int $quantity)
  {
    $userId = '1';
    $cartKey = "cart:$userId";
    $cartData = Redis::get($cartKey);
    $cart = $cartData ? json_decode($cartData, true) : [];

    // Update the quantity of the item with the specified ID in the cart
    foreach ($cart as &$item) {
      if ($item['id'] == $id) {
        $item['quantity'] = $quantity;
        break;
      }
    }

    // Store the updated cart data in Redis
    Redis::set($cartKey, json_encode($cart));

    return true;
  }

  public function getCart(Request $request)
  {
    $userId = '1';
    $cartKey = "cart:$userId";

    $cartData = Redis::get($cartKey);
    $cart = $cartData ? json_decode($cartData, true) : [];

    return $cart;
  }
}
