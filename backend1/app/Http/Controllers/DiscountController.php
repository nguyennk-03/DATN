<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest; // Use request for validation

class DiscountController extends Controller
{
    public function index()
    {
        return response()->json(Discount::all());
    }

    public function store(StoreDiscountRequest $request)
    {
        // Validation is handled by StoreDiscountRequest
        $discount = Discount::create($request->validated());
        return response()->json($discount, 201);
    }

    public function show($id)
    {
        return response()->json(Discount::findOrFail($id));
    }

    public function update(StoreDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->validated());
        return response()->json($discount);
    }

    public function destroy($id)
    {
        Discount::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount_code');
        $discount = Discount::where('code', $discountCode)->first();

        if (!$discount) {
            return response()->json(['message' => 'Invalid discount code'], 400);
        }

        // Check if discount is within valid date range
        if ($discount->start_date > now() || $discount->end_date < now()) {
            return response()->json(['message' => 'Discount code is expired'], 400);
        }

        // Check if max uses have been reached
        if ($discount->max_uses && $discount->used_count >= $discount->max_uses) {
            return response()->json(['message' => 'Discount code has been used the maximum number of times'], 400);
        }

        // Apply discount logic here (e.g., apply to cart or order total)
        // Assuming discount value is applied to the total price
        $discountedAmount = $this->applyDiscountLogic($discount);

        return response()->json(['message' => 'Discount applied successfully', 'discounted_amount' => $discountedAmount]);
    }

    private function applyDiscountLogic(Discount $discount)
    {
        // Example logic to calculate discount value
        // You can implement the logic to apply based on discount_type (percentage, flat amount)
        if ($discount->discount_type == 'percentage') {
            return $discount->value; // Apply percentage discount
        } else {
            return $discount->value; // Apply flat amount discount
        }
    }
}
