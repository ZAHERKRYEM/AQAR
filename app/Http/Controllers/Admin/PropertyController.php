<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Property::all(),
            'message' => 'Properties retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'property_type' => 'required|string',
            'transaction_type' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
            'owner' => 'required|exists:users,id',
        ]);

        $property = Property::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property created successfully',
            'status_code' => 201
        ], 201);
    }

    public function show(Property $property)
    {
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'string',
            'property_type' => 'string',
            'transaction_type' => 'string',
            'price' => 'numeric',
            'area' => 'numeric',
            'city' => 'string',
            'neighborhood' => 'string',
        ]);

        $property->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property updated successfully',
            'status_code' => 200
        ]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Property deleted successfully',
            'status_code' => 200
        ]);
    }
}
