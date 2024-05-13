<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'gender' => $this->gender,
            'rounds' => $this->rounds,
            'winner' => $this->winner_id ? [
                'id' => $this->winner->id,
                'name' => $this->winner->name,
                'skill_level' => $this->winner->skill_level,
                'strength' => $this->winner->strength,
                'speed' => $this->winner->speed,
                'reaction_time' => $this->winner->reaction_time,
            ] : 'No winner yet',
        ];
    }
}