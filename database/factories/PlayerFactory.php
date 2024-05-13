<?php
namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;




class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'skill_level' => $this->faker->randomNumber(2, 1, 100),
            'strength' => $this->faker->randomNumber(2, 1, 100),
            'speed' => $this->faker->randomNumber(2, 1, 100),
            'reaction_time' => $this->faker->randomNumber(2, 1, 100),
        ];
    }
}