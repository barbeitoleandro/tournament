<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'gender',
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }

    public static function createTournament($data)
    {
        try{
            $tournament = new Tournament();
            $tournament->name = $data['name'];
            $tournament->date = date('Y-m-d', strtotime($data['date']));
            $tournament->gender = $data['gender'];
            $tournament->rounds = $data['rounds'];
            $tournament->save();

            return $tournament->id;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function getRounds($tournamentId){
        $tournament = Tournament::find($tournamentId);
        return $tournament->rounds ?? null;
    }

    public static function getWinner($tournamentId){
        $tournament = Tournament::find($tournamentId);
        if(!$tournament){
            return null;
        }
        $game = $tournament->games()->where('round', $tournament->rounds)->where('winner_id', '!=', null)->first();
        if(!$game){
            return null;
        }

        $tournament->winner()->associate(Player::find($game->winner_id));
        $tournament->save();
        
        return Player::find($game->winner_id) ?? null;
    }
}
