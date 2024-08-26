<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Administradore extends Model 
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public static function isAdmin(){
         
         $userId = Auth::id();
         return self::where('user_id', $userId)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
