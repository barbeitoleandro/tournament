<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTournamentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_male_tournament_can_be_created():void
    {

        $playersCount = 8;
        $players = Player::factory()->count($playersCount)->create();
        $tournamentData = [
            'name' => $this->faker->name,
            'date' => '2024-12-12',
            'gender' => 'Male',
            'players' => $players->map(function($player){
                return [
                    'name' => $player->name,
                    'gender' => 'Male',
                    'skill_level' => $player->skill_level,
                    'strength' => $player->strength,
                    'speed' => $player->speed,
                    'reaction_time' => $player->reaction_time,
                ];
            })->toArray()
        ];
        
        $response = $this->postJson('/api/tournaments/create/male', $tournamentData);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Tournament played successfully']);
        
        
        $tournament = Tournament::find(1); 
        $this->assertEquals($tournamentData['name'], $tournament->name);
        $this->assertEquals($tournamentData['gender'], $tournament->gender);
        $this->assertEquals($tournamentData['date'], $tournament->date);
        $this->assertEquals(log($playersCount, 2), $tournament->rounds);
        
        $this->assertDatabaseCount('games', $playersCount - 1);

        // assert the players data 
        foreach($players as $player){
            $this->assertDatabaseHas('players', [
                'name' => $player->name,
                'gender' => $player->gender,
                'skill_level' => $player->skill_level,
                'strength' => $player->strength,
                'speed' => $player->speed,
                'reaction_time' => $player->reaction_time,
            ]);
        }



    }

    
    public function test_female_tournament_can_be_created():void
    {

        $playersCount = 8;
        $players = Player::factory()->count($playersCount)->create();
        $tournamentData = [
            'name' => $this->faker->name,
            'date' => '2024-12-12',
            'gender' => 'Female',
            'players' => $players->map(function($player){
                return [
                    'name' => $player->name,
                    'gender' => 'Female',
                    'skill_level' => $player->skill_level,
                    'strength' => $player->strength,
                    'speed' => $player->speed,
                    'reaction_time' => $player->reaction_time,
                ];
            })->toArray()
        ];
        
        $response = $this->postJson('/api/tournaments/create/female', $tournamentData);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Tournament played successfully']);
        
        
        $tournament = Tournament::find(2); 
        $this->assertEquals($tournamentData['name'], $tournament->name);
        $this->assertEquals($tournamentData['gender'], $tournament->gender);
        $this->assertEquals($tournamentData['date'], $tournament->date);
        $this->assertEquals(log($playersCount, 2), $tournament->rounds);
        
        $this->assertDatabaseCount('games', $playersCount - 1);

        // assert the players data 
        foreach($players as $player){
            $this->assertDatabaseHas('players', [
                'name' => $player->name,
                'gender' => $player->gender,
                'skill_level' => $player->skill_level,
                'strength' => $player->strength,
                'speed' => $player->speed,
                'reaction_time' => $player->reaction_time,
            ]);
        }



    }
}
