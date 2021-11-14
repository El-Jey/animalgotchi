<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnimals extends Model
{
    protected $fillable = ['age', 'size'];

    public static function isUserAnimal($kindId, $userId)
    {
        try {
            return self::where('user_id', $userId)
                ->where('animal_kind_id', $kindId)
                ->first();
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }
}
