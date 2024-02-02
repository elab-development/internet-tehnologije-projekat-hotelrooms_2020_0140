<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'city',
        'address',
        'rating',
        'description'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public static function getAllHotels()
    {
        $result = DB::table('hotels')
            ->select('id', 'name', 'type', 'description', 'city', 'address', 'rating')->get()->toArray();
        return $result;
    }
}
