<?php

namespace App\Http\Controllers\User;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryOption;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Determine user or session
        $userCondition = function ($query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', session()->getId());
            }
        };
    
        // Check if the same product with same color & size already exists
        $cartItem = Cart::where($userCondition)
            ->where('product_id', $request->product_id)
            ->where('size_id', $request->size)
            ->where('color_id', $request->color)
            ->first();
    
        $quantity = (int) ($request->quantity ?? 1);
        $sellPrice = (float) $request->sell_price;
        $totalPrice = $quantity * $sellPrice;
    
        if ($cartItem) {
            // Check stock limit
            if (($cartItem->quantity + $quantity) > availableStock($request->product_id)) {
                return response()->json('stockout');
            }
    
            // Update quantity and total
            $cartItem->quantity += $quantity;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
    
            return response()->json('increased');
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : session()->getId(),
                'product_id' => $request->product_id,
                'quantity' => $quantity,
                'size_id' => $request->size,
                'color_id' => $request->color,
                'price' => $sellPrice,
                'total_price' => $totalPrice,
            ]);
    
            return response()->json('success');
        }
    
        return response()->json('error');
    }
    
    public function increment($id) {
        $cartItem = Cart::findOrFail($id);
    
        // Check if increment is allowed within stock
        if (($cartItem->quantity + 1) <= availableStock($cartItem->product_id)) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
            return response()->json('increased');
        }
    
        return response()->json('stockout');
    }

    public function decrement($id)
    {
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
            return response()->json([
                'status' => 'decreased'
            ]);
        } else {
            $cartItem->delete();
            return response()->json([
                'status' => 'removed'
            ]);
        }
    }

    // Get Cart Items
    public function getCartItems()
    {
        $cartItems = Cart::where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Collect all unique delivery IDs from the cart items
        $deliveryIds = $cartItems->pluck('product.delivery_type')->unique();

        // Find the delivery ID with the highest cost
        $highestCostDeliveryId = null;
        $highestCost = 0;

        // Loop through each delivery ID and check the cost from the DeliveryOption table
        foreach ($deliveryIds as $deliveryId) {
            $deliveryOption = DeliveryOption::find($deliveryId);

            if ($deliveryOption && $deliveryOption->cost > $highestCost) {
                $highestCost = $deliveryOption->cost;
                $highestCostDeliveryId = $deliveryId;
            }
        }
        $highestCostDelivery = DeliveryOption::find($highestCostDeliveryId);
        $formattedDeliveryData = [];
        if($highestCostDelivery) {
            $delId = $highestCostDelivery->id;
            $name = $highestCostDelivery->name ?? '';
            $amount = number_format2($highestCostDelivery->cost) ?? 0;

            $time = null;

            if ($highestCostDelivery->estimated_time == Constant::ESTIMATED_TIME['1 to 3 days']) {
                $today = Carbon::today();
                $threeDaysLater = Carbon::today()->addDays(3);
                $time = 'Guaranteed by ' . $today->format('j M') . ' to ' . $threeDaysLater->format('j M');
                $time2 = Constant::ESTIMATED_TIME['1 to 3 days'];
            } elseif ($highestCostDelivery->estimated_time == Constant::ESTIMATED_TIME['3 to 7 days']) {
                $today = Carbon::today();
                $sevenDaysLater = Carbon::today()->addDays(7);
                $time = 'Guaranteed by ' . $today->format('j M') . ' to ' . $sevenDaysLater->format('j M');
                $time2 = Constant::ESTIMATED_TIME['3 to 7 days'];
            } elseif ($highestCostDelivery->estimated_time == Constant::ESTIMATED_TIME['within 24 hours']) {
                $today = Carbon::today();
                $time = 'Guaranteed by within 24 hours';
                $time2 = Constant::ESTIMATED_TIME['within 24 hours'];
            }

            // shipping details
            $formattedDeliveryData[] = [
                'id' => $delId,
                'name' => $name,
                'amount' => $amount,
                'time' => $time,
                'time2' => $time2,
            ];
        }


        $cartData = $cartItems->map(function ($item) {
            $productUrl = route('product.show', $item->product->slug) . '?itemcode=' . $item->product->item_code . '&pro=' . $item->product->id;
            $imageUrl = asset($item->product->thumbnail);

            // Truncate name if it has more than 10 words
            $name = $item->product->name;
            $name = implode(' ', array_slice(explode(' ', $name), 0, 7)) . (str_word_count($name) > 10 ? '...' : '');

            return [
                'id' => $item->id,
                'name' => $name,
                'product_url' => $productUrl,
                'image_url' => $imageUrl,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'brand' => $item->product->brand->name ?? '',
                'product_id' => $item->product_id,
                'size_id' => $item->size_id,
                'color_id' => $item->color_id,
            ];
        });


        return response()->json([
            'status' => 'success',
            'cart_items' => $cartData,
            'total_items' => $cartItems->count(),
            'total_price' => $totalPrice,
            'delivery' => $formattedDeliveryData,
        ]);
    }

    public function authCheck() {
        return response()->json(['logged_in' => Auth::check()]);
    }


    // Remove Item from Cart
    public function removeItem($id)
    {
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->user_id == Auth::id() || $cartItem->session_id == session()->getId()) {
            $cartItem->delete();
            return response()->json('success');
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
