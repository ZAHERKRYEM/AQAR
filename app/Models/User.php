<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [  
        'username', 'email', 'password', 'verification_code',   
        'is_verified', 'phone', 'user_type',  
    ]; 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->verification_code = mt_rand(100000, 999999);
        });

        static::created(function ($user) {
            $user->sendVerificationEmail(); 
        });
    }

    public function sendVerificationEmail()
    {
        Mail::to($this->email)->send(new Email($this->verification_code));
    }
    public function properties() {  
        return $this->hasMany(Property::class, 'owner');  
    } 

}
