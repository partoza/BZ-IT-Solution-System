<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\CartItem;


class InventoryItemController extends Controller
{
    public function validateSerials(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'serials' => 'required|array',
            'serials.*' => 'required|string',
        ]);

        $productId = $request->product_id;
        $serials = $request->serials;

        $invalid = [];
        $alreadySold = [];

        foreach ($serials as $serial) {
            $item = InventoryItem::where('product_id', $productId)
                ->where('serial_number', $serial)
                ->first();

            if (!$item) {
                $invalid[] = $serial;
            } elseif ($item->status !== 'in_stock') {
                $alreadySold[] = $serial;
            }
        }

        if ($invalid || $alreadySold) {
            $msg = '';
            if ($invalid) $msg .= 'Invalid serials: ' . implode(', ', $invalid) . '. ';
            if ($alreadySold) $msg .= 'Already sold: ' . implode(', ', $alreadySold);
            return response()->json(['success' => false, 'message' => $msg]);
        }

        // All serials valid, update cart prices if needed
        // Example: assume each serial has a unit price
        $totalPrice = InventoryItem::where('product_id', $productId)
            ->whereIn('serial_number', $serials)
            ->sum('unit_price');

        // update cart
        $cartItem = CartItem::where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->price = $totalPrice;
            $cartItem->save();
        }

        return response()->json([
            'success' => true,
            'updatedPrice' => $totalPrice
        ]);
    }
}
