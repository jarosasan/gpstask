<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0;$i< 2;$i++) {
            User ::create( [
                'name' => $faker->name,
                'password' => bcrypt('admin'),
                'email'=> $faker->email,
            ] );
        }
    }
}
