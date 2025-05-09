<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ClearBuyNowSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();

        // Clear session except on checkout.buy-now and customer.order.store routes
        if ($routeName !== 'checkout.buy-now' && $routeName !== 'customer.order.store') {
            session()->forget('buy_now_item');
        }

        
        return $next($request);
    }
}
