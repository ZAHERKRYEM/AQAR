<?php
namespace App\Http\Controllers;  

use App\Models\Property;  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth;
class PropertyController extends Controller  
{  
    public function store(Request $request) {  
        $request->validate([  
            'title' => 'required',  
            'description' => 'required',  
            'property_type' => 'required',  
            'transaction_type' => 'required',  
            'price' => 'required|numeric',  
            'area' => 'required|numeric',  
            'city' => 'required',  
            'neighborhood' => 'required',  
            'latitude' => 'required|numeric',  
            'longitude' => 'required|numeric',  
            'bedrooms' => 'required|integer',  
            'bathrooms' => 'required|integer'
              
        ]);  

        $property = Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'property_type' => $request->property_type,
            'transaction_type' => $request->transaction_type,
            'price' => $request->price,
            'area' => $request->area,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'owner_id' => Auth::id(),
        ]);
      
        return response()->json(['property' => $property], 201);  
    }  

    public function index() {  
        return Property::with('user')->get();  
    }  

    public function show($id) {  
        $property = Property::with('user')->findOrFail($id);  
        return response()->json(['property' => $property], 200);  
    }  
}  