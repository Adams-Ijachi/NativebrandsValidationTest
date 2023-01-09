<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomValidationException;
use App\Http\Controllers\Controller;
use App\Validators\UserValidation;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function create(UserValidation $request)
    {

        try {
                 $request->validate();

                 return response()->json([
                     'status' => true
                 ], 201);
        }
        catch (CustomValidationException $e) {
            return response()->json($e->getErrorResponse(), $e->status);
        }


    }
}
