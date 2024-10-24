<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'consentimiento',
        'condicion_especial',
        'fecha_nacimiento'
    ];

    public $timestamps = false;

    public static function isClient(){
         
        $userId = Auth::id();
        return self::where('user_id', $userId)->exists();
   }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }
}
