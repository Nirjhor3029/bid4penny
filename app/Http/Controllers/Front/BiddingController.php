<?php

namespace App\Http\Controllers\Front;

use App\Events\PriceUpdated;
use App\Http\Controllers\Controller;
use App\Models\Bidding;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BiddingController extends Controller
{
    public function placeBid(Request $request)
    {
        $item = Product::find($request->item_id);
        if (isset($item->current_price)) {
            $item->current_price += $item->price_increase_by; // Increment the price
        }else{
            $item->current_price = $item->auction_starting_price + $item->price_increase_by;
        }
        
        $item->save();

        $bidding = new Bidding();
        $bidding->user_id = auth()->id();
        $bidding->product_id = $item->id;
        $bidding->bid_price = $item->current_price;
        $bidding->bidding_time = Carbon::now();
        $bidding->save();

        $user = auth()->user();

        $total_bids = 0;
        $last_bidder = '';
        if (isset($item->biddings) && $item->biddings->count() > 0) {
            $total_bids = $item->biddings->count();

            $last_bidder = $item->biddings->last()->user->name ?? '';
        }
        
        


        // Log::info('PriceUpdated: ', [
        //     'item_id' => $item->id,
        //     'new_price' => $item->current_price,
        // ]);

        broadcast(new PriceUpdated(
            $item->id,
            $item->current_price,
            $last_bidder,
            $total_bids
        ));

        return response()->json(['success' => true]);
    }
}
