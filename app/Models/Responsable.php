<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Responsable extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'centro_id'
    ];

    public $timestamps = false;

    public static function isRespons(){
         
        $userId = Auth::id();
        return self::where('user_id', $userId)->exists();
   }

   public function centroAsignado(){
    return Centro::find($this->centro_id);
   }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }


}
