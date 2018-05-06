<?php

use Illuminate\Database\Seeder;

class ProductsSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('pl_PL');

        for($i = 0; $i < 10; $i++) {
            $product = new \App\Product();
            $product->name = $faker->firstName;
            $product->price = $faker->numberBetween(100,200);
            $product->save();
        }
    }
}
