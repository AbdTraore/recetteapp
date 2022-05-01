<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContribuableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codecontribuable' => rand(10000000,99999999),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'telephone' => $this->faker->phoneNumber(),
            'zone' => $this->faker->city(),
            'activites_id' => rand(1,6)
        ];
    }
}
