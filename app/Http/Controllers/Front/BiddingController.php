<?php

namespace App\Http\Controllers\Front;

use App\Events\PriceUpdated;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BiddingController extends Controller
{
    public function placeBid(Request $request)
    {
        // return response()->json([
        //     'status' => 200,
        //     'data' => $request->all()
        // ]);
        $item = Product::find($request->item_id);
        $item->current_price += 0.01; // Increment the price
        $item->save();

        broadcast(new PriceUpdated($item->id, $item->price));

        return response()->json(['success' => true]);
    }
}
