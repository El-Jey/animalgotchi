<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalKinds extends Model
{

    /**
     * @method Check if kind is available
     * @param {number} $animalId
     * @return {AnimalKinds} model
     */
    public static function isAvailable($animalId)
    {
        try {
            return self::where('id', $animalId)
                ->where('available', 1)
                ->first();
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }
}
