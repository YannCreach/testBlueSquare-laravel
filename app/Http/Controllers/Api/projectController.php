<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Exception;

class projectController extends Controller
{
  // public function index(){
  //   try{
  //     return response()->json([
  //       'status_code' => 200,
  //       'status_message' => 'Les projets ont été récupérés',
  //       'data' => Project::all()
  //     ]);
  //   }
  //   catch(Exception $e){
  //     return response()->json($e);
  //   }
  // }

  public function index(Request $request)
  {
    try{
      $user = auth() -> user();

      if($user->role === 'admin') {
          $projects = Project::all();
      }
      elseif($user->role === 'client') {
          $projects = Project::where('user_id', $user->id)->get();
      }
      else {
          return response()->json(['message' => 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette ressource.'], 403);
      }

      return response()->json([
        'status_code' => 200,
        'status_message' => 'Le ticket a été créé',
        'data' => $projects
      ]);
    }
    catch(Exception $e){
      return response()->json($e);
    }

  }
}
