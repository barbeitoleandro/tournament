<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'skill_level',
        'strength',
        'speed',
        'reaction_time',
        'wins',
        'losses',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function createPlayer($data){
        try{
            $player = new Player();
            $player->name = $data['name'];
            $player->gender = $data['gender'];
            $player->skill_level = $data['skill_level'] ?? 1;
            $player->strength = $data['strength'] ?? 1;
            $player->speed = $data['speed'] ?? 1;
            $player->reaction_time = $data['reaction_time'] ?? 1;
            $player->save();    
    
            return $player->id;
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getPoints(){
        $points = 0;
        if($this->gender == 'Male'){
            $points = $this->skill_level + $this->strength + $this->speed;
        }
        else if($this->gender == 'Female'){
            $points = $this->skill_level + $this->reaction_time;
        }

        return $points;
    }
}
