<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create(); //membuat data baru based on factory

        Post::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // //DATABASE SEEDER//
        User::create([
            'name' => 'Raka Febrian',
            'username' => 'rkfbrns',
            'email' => 'raka@gmail.com',
            'password' => bcrypt('12345'),
        ]);
        // User::create([
        //     'name' => 'Khadafi',
        //     'email' => 'khadafi@gmail.com',
        //     'password' => bcrypt('111'),
        // ]);
        Category::create([
            'name' => 'Programming',
            'slug' => 'programming'
        ]);
        // ]);
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);
        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);
        // Post::create([
        //     "title"=> "Judul Pertama",
        //     "category_id"=>1,
        //     "user_id"=>2,
        //     "slug"=> "judul-pertama",
        //     "excerpt"=> "Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam vel voluptates quidem, perspiciatis in,",
        //     "body"=>"<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam vel voluptates quidem, perspiciatis in, repudiandae facilis animi modi dolor iure a iste magni pariatur nemo facere eaque saepe odit consequuntur.</p>"
        // ]);
        // Post::create([
        //     "title"=> "Judul Kedua",
        //     "category_id"=>2,
        //     "user_id"=>1,
        //     "slug"=> "judul-kedua",
        //     "excerpt"=> "Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam vel voluptates quidem, perspiciatis in,",
        //     "body"=>"<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam vel voluptates quidem, perspiciatis in, repudiandae facilis animi modi dolor iure a iste magni pariatur nemo facere eaque saepe odit consequuntur.</p>"
        // ]);
    }
}
