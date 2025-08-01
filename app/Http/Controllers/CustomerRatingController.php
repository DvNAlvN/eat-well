<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRatingStoreRequest;
use App\Models\Order;
use App\Models\VendorReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRatingController extends Controller
{
    public function store(CustomerRatingStoreRequest $request, $orderId)
    {

        $validated = $request->validated();

        $order = Order::findOrFail($orderId);

        if($order->isCancelled == 0 && Carbon::now()->lessThan($order->endDate)) {
            return response()->json(['message' => 'You can only rate finished orders.'], 403);
        }

        $userId = Auth::user()->userId;
        
        // Prevent duplicate reviews per user/order
        $existing = VendorReview::where('orderId', $orderId)
            ->where('userId', $userId)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already reviewed this order.'], 409);
        }

        $review = VendorReview::create([
            'vendorId' => $order->vendorId,
            'userId' => $userId,
            'orderId' => $orderId,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        logActivity('Successfully', 'Upload', 'Review');
        return response()->json(['success' => true, 'review' => $review]);
    }
}
