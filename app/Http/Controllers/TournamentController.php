<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTournamentFemaleRequest;
use App\Http\Requests\CreateTournamentMaleRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    public function createTournamentMale(CreateTournamentMaleRequest $request)
    {
        return $this->handleTournament($request, 'Male');
    }

    public function createTournamentFemale(CreateTournamentFemaleRequest $request)
    {
        return $this->handleTournament($request, 'Female');
    }

    public function handleTournament($request, $gender)
    {
        try{
            $tournamentId = $this->createTournament($request, $gender);
            if(!$tournamentId){
                return response()->json([
                    'message' => 'Tournament creation failed'
                ], 400);
            }

            $winner = $this->runTournament($tournamentId);
            if(!$winner){
                return response()->json([
                    'message' => 'Tournament execution failed'
                ], 400);
            }

            return response()->json([
                'message' => 'Tournament played successfully',
                'id' => $tournamentId,
                'winner' => $winner
            ], 201);

        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Tournament failed'
            ], 400);
        }
    }

    public function createTournament($request, $gender)
    {
        try{
            $countPlayers = count($request->players);
            $rounds = log($countPlayers, 2);
            if($rounds != intval($rounds)){
                return null;
            }
            
            $players = [];
            foreach($request->players as $tournamentPlayer){
                $player = Player::createPlayer($tournamentPlayer);
                if(!$player){
                    return null;
                }
                $players[] = $player;
            }

            // Crea el torneo
            $tournamentId = Tournament::createTournament([
                'name' => $request->name,
                'date' => $request->date,
                'gender' => $gender,
                'rounds' => log(count($players), 2)  
            ]);

            if(!$tournamentId){
                return null;
            }
            
            $newRound = Game::createRound($players, $tournamentId);
            if(!$newRound){
                return null;
            }
            
            return $tournamentId;

        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public function runTournament($tournamentId){
        try{
            $rounds = Tournament::getRounds($tournamentId);
            for($i = 1; $i <= $rounds; $i++){
                $playedRound = Game::playRound($tournamentId, $i);
                if(!$playedRound){
                    return null;
                }
                $nextRound = Game::createNextRound($tournamentId, $i);
                if(!$nextRound){
                    return null;
                }
            }

            $winner = Tournament::getWinner($tournamentId);
            
            return $winner;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }
            
}
