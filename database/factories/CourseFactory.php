<?php

namespace Database\Factories;


use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Avant le lancement de la commande pour les seeders, allez commenter la fonction
     * booted dans le model : Course.php. Décommentez la fonction, une fois les seeders effectués.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(),
            'description'=>$this->faker->paragraphs(3,true),
            'user_id'=>User::all()->random()->id, 
        ];
    }
}
