<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\ArticleSeeder;
use Database\Seeders\RoleSeeder;

use App\Models\Article;
use App\Models\Comment;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        # !Warning NOT working. User factoring
        // User::factory(10)->create();
        
        # Article factoring
        // $this->call([
        //     ArticleSeeder::class,
        // ]);
        # Role factoring
        // $this->call([
        //     RoleSeeder::class,
        // ]);
        // Article with Comments factoring
        Article::factory(10)->has(Comment::factory(3))->create();        


        // $this->call([
        //    ArticleSeeder::class,
        // ]);

        // Delete all rows from tables;
        // User::query()->delete();
        // Article::query()->delete();
        
    }
}
