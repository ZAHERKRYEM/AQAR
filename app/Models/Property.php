<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [  
        'title', 'description', 'property_type', 'transaction_type',   
        'price', 'area', 'city', 'neighborhood',   
        'latitude', 'longitude', 'bedrooms', 'bathrooms',   
        'floor_number', 'owner', 'image',  
    ];  

    public function user() {  
        return $this->belongsTo(User::class, 'owner');  
    } 
}
