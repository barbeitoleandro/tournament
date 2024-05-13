<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player1_id',
        'player2_id',
        'winner_id',
        'round',
    ];

    public function player1()
    {
        return $this->belongsTo(Player::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(Player::class, 'player2_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }

    private static function createGame($data)
    {
        try{
            $game = new Game();
            $game->player1()->associate($data['player1_id']);
            $game->player2()->associate($data['player2_id']);
            $game->round = $data['round'];
            $game->tournament()->associate($data['tournament_id']);
            $game->save();

            return true;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function createRound($players, $tournamentId, $round = 1)
    {
        try{
            $matches = count($players) / 2;
            $playerCounter = 0;
            for ($i = 0; $i < $matches; $i++) {
                $game = self::createGame([
                    'player1_id' => $players[$playerCounter],
                    'player2_id' => $players[$playerCounter + 1],
                    'round' => $round,
                    'tournament_id' => $tournamentId
                ]);
                if(!$game){
                    return null;
                }
                $playerCounter += 2;
            }
            return true;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function playRound($tournamentId, $round)
    {
        try{
            $games = self::where('tournament_id', $tournamentId)->where('round', $round)->get();
            foreach ($games as $game) {
                Game::playGame($game);
            }
            return true;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    private static function playGame($game){
        $player1 = $game->player1;
        $player2 = $game->player2;
        $player1Score = $player1->getPoints();
        $player2Score = $player2->getPoints();

        if($player1Score == $player2Score){
            $game->winner()->associate(rand(1, 2) == 1 ? $player1->id : $player2->id);
        }
        else if($player1Score > $player2Score){
            $game->winner()->associate($player1->id);
        }
        else{
            $game->winner()->associate($player2->id);
        }
        $game->save();
    }

    public static function createNextRound($tournamentId, $round)
    {
        try{
            $winners = self::getRoundWinners($tournamentId, $round);
            if(!$winners){
                return null;
            }
            if (count($winners) == 1) {
                return true;
            }
            $newRound = self::createRound($winners, $tournamentId, $round + 1);
            if(!$newRound){
                return null;
            }
            return true;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    private static function getRoundWinners($tournamentId, $round)
    {
        $winners = self::where('tournament_id', $tournamentId)->where('round', $round)->get('winner_id') ?? null;
        if(!$winners){
            return null;
        }
        $winners = $winners->pluck('winner_id')->toArray();
        return $winners;
    }
}
