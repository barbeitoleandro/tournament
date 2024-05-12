<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTournamentRequest;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tests\Feature\CreateTournamentTest;

class TournamentController extends Controller
{
    //
    public function createTournament(CreateTournamentRequest $request)
    {
        try{
            $tournament = new Tournament();
            $tournament->name = $request->name;
            $tournament->date = date('Y-m-d', strtotime($request->date));
            $tournament->gender = $request->gender;
            $tournament->save();
    
            return response()->json([
                'message' => 'Tournament created successfully'
            ], 201);
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Tournament creation failed'
            ], 400);
        }
    }
}
