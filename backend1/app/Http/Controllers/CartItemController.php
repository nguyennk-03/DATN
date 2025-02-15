<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CartItem;
use App\Models\Product;

class CartItemController extends Controller
{
    //Xem danh sách giỏ hàng của người dùng
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        return response()->json(['cart_items' => $cartItems]);
    }

    //Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại!'], 404);
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng!', 'cart_item' => $cartItem]);
    }

    //Xóa sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('id', $id)->where('user_id', $user->id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!']);
    }
}
