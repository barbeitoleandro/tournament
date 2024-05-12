<?php

namespace Tests\Feature;

use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTournamentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_tournament_can_be_created():void
    {
        $tournamentData = [
            'name' => $this->faker->name,
            'date' => '2021-12-12',
            'gender' => $this->faker->randomElement(['Male', 'Female']),
        ];

        $response = $this->postJson('api/tournaments/create', $tournamentData);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Tournament created successfully']);

        $tournament = Tournament::find(1); 
        $this->assertEquals($tournamentData['name'], $tournament->name);
        $this->assertEquals($tournamentData['gender'], $tournament->gender);
        $this->assertEquals($tournamentData['date'], $tournament->date);
    }
}
