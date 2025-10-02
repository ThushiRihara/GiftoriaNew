<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gift;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GiftController extends Controller
{
    public function index() {
        $gifts = Gift::with(['category','addOns', 'admin'])->get();
        return response()->json($gifts);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'add_ons' => 'sometimes|array',
            'add_ons.*' => 'integer|exists:add_ons,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gifts','public');
        }

        $gift = Gift::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'stock_quantity'=>$request->stock_quantity,
            'category_id'=>$request->category_id,
            'admin_id'=>1,
            'image'=>$imagePath
        ]);

        if ($request->has('add_ons')) {
            $gift->addOns()->sync($request->add_ons);
        }

        return response()->json($gift->load(['category','addOns']), 201);
    }

    public function update(Request $request,$id) {
        $gift = Gift::find($id);
        if (!$gift) return response()->json(['message'=>'Gift not found'],404);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'add_ons' => 'sometimes|array',
            'add_ons.*' => 'integer|exists:add_ons,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()],422);

        if ($request->hasFile('image')) {
            if ($gift->image) Storage::disk('public')->delete($gift->image);
            $gift->image = $request->file('image')->store('gifts','public');
        }

        $gift->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'stock_quantity'=>$request->stock_quantity,
            'category_id'=>$request->category_id,
            'admin_id'=>1
        ]);

        $gift->addOns()->sync($request->add_ons ?? []);

        return response()->json($gift->load(['category','addOns']));
    }

    public function destroy($id) {
        $gift = Gift::find($id);
        if (!$gift) return response()->json(['message'=>'Gift not found'],404);

        if ($gift->image) Storage::disk('public')->delete($gift->image);

        $gift->delete();

        return response()->json(['message'=>'Deleted']);
    }

    // Get all categories and add-ons for form
    public function categoriesAndAddOns() {
        $categories = \App\Models\Category::all();
        $addOns = \App\Models\AddOn::all();
        return response()->json([
            'categories' => $categories,
            'addOns' => $addOns
        ]);
    }

}
