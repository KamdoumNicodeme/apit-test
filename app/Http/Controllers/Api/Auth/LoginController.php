<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use http\Env\Response;use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->only(['email','password']);
        $token = auth()->attempt($creds);

        if (!$token) {
            return response()->json(['error' => 'Incorrect email/password!'], 401);
        }

        return response()->json(['token' => $token]);
    }



    /**
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {


        $user = new User;

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();


        $location = new Location;
        $location->latitude = $request->location['latitude'];
        $location->longitude = $request->location['longitude'];


        //dd($user, $location);


        $user->location()->save($location);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }


    public function updateLocation(Request $request)
    {


        $user = auth()->user();

        $location = $user->location ?? new Location();
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;

        $user->location()->save($location);

        return response()->json(['message' => 'Location updated successfully!', 'user' => $user], 200);
    }


    public function index()
    {

        $locations = Location::all();

        return response()->json(['locations' => $locations], 200);
    }


}
