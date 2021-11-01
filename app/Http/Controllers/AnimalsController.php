<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnimalsController extends Controller
{
    public function animalsAvailable(Request $request)
    {
        if ($request->ajax()) {
            try {
                $animals = DB::table('animal_kinds')
                    ->where('available', 1)
                    ->get();

                return response()->json($animals);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json($ex);
            }
        }
        throw new NotFoundHttpException();
    }

    public function addAnimal(Request $request)
    {
        if ($request->ajax()) {
            // Доступен ли данный тип животного
            if ($animalKind = $this->isAnimalAvailable($request->animalId, $request->userId)) {
                try {
                    $insertId = DB::table('user_animals')->insertGetId([
                        'animal_kind_id' => $animalKind->id,
                        'user_id' => $request->userId,
                        'name' => $request->name,
                        'max_size' => $animalKind->max_size,
                        'max_age' => $animalKind->max_age,
                        'growth_factor' => $animalKind->growth_factor,
                        'image' => $animalKind->default_image
                    ]);

                    $addedAnimal = DB::table('user_animals')
                        ->where('id', $insertId)
                        ->first();

                    return response()->json([
                        "error" => null,
                        "data" => $addedAnimal
                    ]);
                } catch (\Illuminate\Database\QueryException $ex) {
                    return response()->json([
                        "error" => $ex,
                        "data" => null
                    ]);
                }
            }

            return response()->json([
                "error" => "Животное недоступно или уже было добавлено",
                "data" => null
            ]);
        }
        throw new NotFoundHttpException();
    }

    private function isAnimalAvailable($animalId, $userId)
    {
        try {
            $animalKind = DB::table('animal_kinds')
                ->where('id', $animalId)
                ->where('available', 1)
                ->first();

            if ($animalKind) {
                $userAnimal = DB::table('user_animals')
                    ->where('user_id', $userId)
                    ->where('animal_kind_id', $animalId)
                    ->first();

                if (!$userAnimal) {
                    return $animalKind;
                }
            }

            return false;
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    public function userAnimals(Request $request, $userId)
    {
        if ($request->ajax()) {
            try {
                $animals = DB::table('user_animals')
                    ->where('user_id', $userId)
                    ->get();

                return response()->json($animals);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json($ex);
            }
        }
        throw new NotFoundHttpException();
    }

    public function growAnimal(Request $request)
    {
        if ($request->ajax()) {
            try {
                $animal = DB::table('user_animals')
                    ->where('id', $request->animalId)
                    ->first();

                if ($animal->age < $animal->max_age || $animal->size < $animal->max_size) {
                    $animal->age = $animal->age + 1;
                    $animal->size = round($animal->age * $animal->growth_factor, 2);

                    DB::table('user_animals')
                        ->where('id', $request->animalId)
                        ->update(['age' => $animal->age, 'size' => $animal->size]);
                }

                return response()->json([
                    "error" => null,
                    "data" => $animal
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json([
                    "error" => $ex,
                    "data" => null
                ]);
            }
        }
        throw new NotFoundHttpException();
    }
}
