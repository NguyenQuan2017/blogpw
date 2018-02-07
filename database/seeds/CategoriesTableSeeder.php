<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Category::class,10)->create()->each(function ($u) {
            $u->posts()->saveMany(factory(App\Models\Post::class,3)->make());
        });

    }
}
