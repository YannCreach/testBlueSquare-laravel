<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function register(RegisterUser $request){
      try{
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password, [
          'rounds'=> 12
        ]);
        $user->role = 'client';
        $user->save();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'L\'utilisateur à été créé',
          'user' => $user
        ]);
      } catch (Exception $e){
        return response()->json($e);
      }
    }

    public function login(LoginUserRequest $request){
      try{
        
        if(auth()->attempt($request->only(['email', 'password']))){
          
          $user = auth() -> user();
          $token = $user -> createToken('BLUESQUARE_SECRET_KEY_OF_DEATH') -> plainTextToken;
          
          return response()->json([
            'status_code' => 200,
            'status_message' => 'Utilisateur connecté',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
          ]);

        } else {
          return response()->json([
            'status_code' => 403,
            'status_message' => 'Informations non valides',
          ]);
        }

      } catch (Exception $e){
        return response()->json($e);
      }
      

    }

  }