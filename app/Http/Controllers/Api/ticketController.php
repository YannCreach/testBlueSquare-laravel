<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\EditTicketRequest;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Mockery\Undefined;

class ticketController extends Controller
{
    public function index(Request $request){
      try{
        $query = Ticket::query();
        $perPage = 10;
        $page = $request->input('page', 1);
        $search = $request->input('search');
  
        if ($search){
          $query->whereRaw("title LIKE '%" . $search . "%'");
        }
  
        $total = $query-> count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return response()->json([
          'status_code' => 200,
          'status_message' => 'Les tickets ont été récupérés',
          'current_page'=>$page,
          'last_page'=>ceil($total /  $perPage),
          'items' => $result
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }

    public function getTicketByProject(Request $request){
      try{
        $query = Ticket::query();
        $perPage = $request->input('perpage', 10);
        $page = $request->input('page', 1);
        $project = $request->input('project');
  
        if (isset($project) && ($project != 'undefined')){
          $query->whereRaw("project_id = " . $project . "");
        }
  
        $total = $query-> count();
        $result = $query->orderBy('id')->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return response()->json([
          'status_code' => 200,
          'status_message' => 'Les tickets ont été récupérés',
          'current_page'=>$page,
          'project_id'=>$project,
          'last_page'=>ceil($total /  $perPage),
          'items' => $result
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }
    
    public function getTicketById(Ticket $ticket){
      try{
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Le ticket a été récupéré',
          'data' => $ticket
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }

    public function createTicket(CreateTicketRequest $request){
      try{
        $ticket = new Ticket();
        $ticket -> title = $request->title;
        $ticket -> type = $request->type;
        $ticket -> priority = $request->priority;
        $ticket -> description = $request->description;
        $ticket -> context = $request->context;
        $ticket -> link = $request->link;
        $ticket -> browser = $request->browser;
        $ticket -> os = $request->os;
        $ticket -> project_id = $request->project_id;
        $ticket -> creator_id = auth()->user()->id;
        $ticket -> status = 'En attente';
        $ticket -> save();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Le ticket a été créé',
          'data' => $ticket
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }

    public function updateTicket(EditTicketRequest $request, Ticket $ticket){
      try{
        $ticket -> title = $request->title;
        $ticket -> type = $request->type;
        $ticket -> priority = $request->priority;
        $ticket -> description = $request->description;
        $ticket -> context = $request->context;
        $ticket -> link = $request->link;
        $ticket -> browser = $request->browser;
        $ticket -> os = $request->os;
        $ticket -> status = $request->status;
        $ticket -> creator_id = $request->creator_id;
        $ticket -> save();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Le ticket a été modifié',
          'data' => $ticket
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }

    public function deleteTicket(Ticket $ticket){
      try{

        $ticket -> delete();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Le ticket a été supprimé',
          'data' => $ticket
        ]);
      }
      catch(Exception $e){
        return response()->json($e);
      }
    }
}
