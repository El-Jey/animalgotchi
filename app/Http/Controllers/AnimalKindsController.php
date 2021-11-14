<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Models\AnimalKinds;

class AnimalKindsController extends Controller
{
    public function allAvailable(Request $request)
    {
        if ($request->ajax()) {
            try {
                $animals = AnimalKinds::where('available', 1)->get();

                return response()->json($animals);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json($ex);
            }
        }
        throw new NotFoundHttpException();
    }
}
