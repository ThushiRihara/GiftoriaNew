<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddOn;
use Illuminate\Support\Facades\Validator;

class AddOnController extends Controller
{
    // public function indexPage()
    // {
    //     return view('admin.manage-addons');
    // }

    public function index() {
        return response()->json(AddOn::all());
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $addon = AddOn::create([
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return response()->json($addon, 201);
    }

    public function update(Request $request, $id) {
        $addon = AddOn::find($id);
        if (!$addon) return response()->json(['message'=>'Addon not found'], 404);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $addon->update([
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return response()->json($addon);
    }

    public function destroy($id) {
        $addon = AddOn::find($id);
        if (!$addon) return response()->json(['message'=>'Addon not found'], 404);

        $addon->delete();
        return response()->json(['message'=>'Deleted successfully']);
    }
}
