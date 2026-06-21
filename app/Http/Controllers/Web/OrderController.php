<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\OrderItem;

class SellerOrderController
extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = OrderItem::with([

            'product.images',
            'product.store',
            'order.user'

        ])

        ->whereHas(

            'product.store',

            function ($q) use ($user) {

                $q->where(
                    'user_id',
                    $user->id
                );

            }

        )

        ->latest()

        ->get();

        return view(

            'dashboard.seller.orders.index',

            compact('orders')

        );
    }
}