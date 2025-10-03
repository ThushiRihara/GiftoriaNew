<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    // GET /api/admin/offers
    public function index(Request $request)
    {
        // If only one admin exists, show all offers
        $offers = Offer::orderBy('created_at', 'desc')->get();
        return response()->json($offers);
    }

    // GET /api/admin/offers/{id}
    public function show($id)
    {
        $offer = Offer::find($id);
        if (!$offer) return response()->json(['message' => 'Not found'], 404);
        return response()->json($offer);
    }

    // POST /api/admin/offers
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        // If you want to associate with admin from token: $admin = $request->user();
        // For your setup with single admin, set admin_id = 1
        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'admin_id' => 1,
        ]);

        return response()->json($offer, 201);
    }

    // POST /api/admin/offers/{id} with _method=PUT (for multipart or simple)
    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
        if (!$offer) return response()->json(['message'=>'Not found'], 404);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->save();

        return response()->json($offer);
    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        if (!$offer) return response()->json(['message'=>'Not found'], 404);

        $offer->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
