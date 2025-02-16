<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function index()
    {
        return response()->json(ProductVariant::all());
    }

    public function store(Request $request)
    {
        $variant = ProductVariant::create($request->all());
        return response()->json($variant, 201);
    }

    public function show($id)
    {
        return response()->json(ProductVariant::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->update($request->all());
        return response()->json($variant);
    }

    public function destroy($id)
    {
        ProductVariant::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
