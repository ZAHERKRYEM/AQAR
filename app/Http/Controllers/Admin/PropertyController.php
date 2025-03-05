<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
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

    public function store(StorePropertyRequest $request)
    {
     

        $property = Property::create($request->validated());
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

    public function update(UpdatePropertyRequest $request, Property $property)
    {
    

        $property->update($request->validated());
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
