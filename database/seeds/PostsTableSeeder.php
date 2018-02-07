<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Post::class,30)->create()->each(function ($u) {
            $u->categories()->saveMany(factory(App\Models\Category::class,2)->make());
        });
    }
}
