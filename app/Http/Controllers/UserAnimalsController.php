<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Models\UserAnimals;
use App\Models\AnimalKinds;


class UserAnimalsController extends Controller
{
    public function all(Request $request, $userId)
    {
        if ($request->ajax()) {
            try {
                $animals = UserAnimals::where('user_id', $userId)->get();

                return response()->json($animals);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json($ex);
            }
        }
        throw new NotFoundHttpException();
    }

    public function new(Request $request)
    {
        if ($request->ajax()) {
            if (!$animalKind = AnimalKinds::isAvailable($request->kindId)) {
                return response()->json([
                    "error" => "Данный вид животного недоступен",
                    "data" => null
                ]);
            }

            if (UserAnimals::isUserAnimal($request->kindId, $request->userId)) {
                return response()->json([
                    "error" => "У вас уже есть это животное",
                    "data" => null
                ]);
            }

            $animal = new UserAnimals();
            $animal->animal_kind_id = $animalKind->id;
            $animal->user_id = $request->userId;
            $animal->name = $request->name;
            $animal->max_size = $animalKind->max_size;
            $animal->max_age = $animalKind->max_age;
            $animal->growth_factor = $animalKind->growth_factor;
            $animal->image = $animalKind->default_image;

            $animal->save();

            return response()->json([
                "error" => null,
                "data" => $animal
            ]);
        }
        throw new NotFoundHttpException();
    }

    public function grow(Request $request)
    {
        if ($request->ajax()) {
            try {
                $animal = UserAnimals::find($request->animalId);

                if ($animal) {

                    if ($animal->age < $animal->max_age || $animal->size < $animal->max_size) {
                        $animal->age = $animal->age + 1;
                        $animal->size = round($animal->age * $animal->growth_factor, 2);

                        $animal->update(['age' => $animal->age, 'size' => $animal->size]);
                    }

                    return response()->json([
                        "error" => null,
                        "data" => $animal
                    ]);
                }

                return response()->json([
                    "error" => "Такого животного не существует",
                    "data" => null
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
