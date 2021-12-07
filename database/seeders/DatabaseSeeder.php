<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Bookstore;
use App\Models\Editor;
use App\Models\Company;
use App\Models\Image;
use App\Models\Product;
use App\Models\Range;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(50)
            ->has(
                Product::factory()
                    ->count(3)
                    ->has(Category::factory()->count(3))
            )
            ->create();
        $books = Book::factory(50)->create();
        $ranges = Range::factory(20)->create();

        $faker = Factory::create();
        Book::all()->each(function ($book) use ($faker, $ranges, $users) {
            $book->ranges()->attach(
                $ranges->random(rand(1, 3))->pluck('id')->toArray()
            );
            $book->comments()->saveMany([
                new Comment(['user_id' => $users->find(rand(1, 10))->id, 'body' => $faker->sentence()]),
                new Comment(['user_id' => $users->find(rand(1, 10))->id, 'body' => $faker->sentence()]),
            ]);

            $image = new Image(['name' => $faker->name, 'url' => $faker->url()]);
            $image->imageable()->associate($book);
            $image->save();

            for ($i = 0; $i < 2; $i++) {
                $tag = new Tag(['label' => $faker->name]);
                $tag->taggable()->associate($book);
                $tag->save();
            }
        });

        foreach ($books as $key => $book) {
            for ($i = 0; $i < 2; $i++) {
                $company = Company::create(['name' => $faker->name, 'book_id' => $book->id]);
                Bookstore::create(['label' => $faker->name, 'company_id' => $company->id]);
            }

            $user = $users->find($key + 1);
            $author = Author::create(['book_id' => $book->id]);
            $user->author_id = $author->id;
            $user->save();

            Editor::create(['name' => $faker->name, 'book_id' => $book->id]);
        }
    }
}
