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
    /**
     * Authentifie un utilisateur et retourne un jeton d'authentification.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $creds = $request->only(['email','password']);
        $token = auth()->attempt($creds);

        if (!$token) {
            // L'authentification a échoué, retourne une réponse JSON avec un code d'erreur 401
            return response()->json(['error' => 'Adresse e-mail ou mot de passe incorrect!'], 401);
        }

        // L'authentification a réussi, retourne une réponse JSON avec le jeton d'authentification
        return response()->json(['token' => $token]);
    }


    /**
     * Enregistre un nouvel utilisateur et sa position actuelle.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        // Créer un nouvel utilisateur
        $user = new User;

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        // Créer un nouvel objet de position pour l'utilisateur
        $location = new Location;
        $location->latitude = $request->location['latitude'];
        $location->longitude = $request->location['longitude'];

        // Associer la position à l'utilisateur
        $user->location()->save($location);

        // Retourne une réponse JSON avec un code de succès 201
        return response()->json(['message' => 'Utilisateur enregistré avec succès!', 'user' => $user], 201);
    }


    /**
     * Met à jour la position actuelle de l'utilisateur authentifié.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateLocation(Request $request)
    {
        // Obtenir l'utilisateur authentifié
        $user = auth()->user();

        // Obtenir la position actuelle de l'utilisateur ou créer une nouvelle position si l'utilisateur n'en a pas encore
        $location = $user->location ?? new Location();
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;

        // Associer la nouvelle position à l'utilisateur
        $user->location()->save($location);

        // Retourne une réponse JSON avec un code de succès 200
        return response()->json(['message' => 'Position mise à jour avec succès!', 'user' => $user], 200);
    }


    /**
     * Récupère toutes les positions des utilisateurs enregistrées dans la base de données.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // Récupère toutes les positions des utilisateurs
        $locations = Location::all();

        // Retourne une réponse JSON avec un code de succès 200
        return response()->json(['locations' => $locations], 200);
    }
}
