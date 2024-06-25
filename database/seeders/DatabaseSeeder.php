<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Column;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'parasts lietotājs',
                'email' => 'normal@kanban.test',
                "role" => 0
            ]
        );

        $normalUser = User::query()->latest()->first();

        Board::create([
            "name" => "first board",
            "user_id" => $normalUser->id,
            "privacy" => 0
        ]);

        $firstBoard = Board::query()->latest()->first();

        Column::create([
            "name" => "first column",
            "board_id" => $firstBoard->id,
            "order" => 0
        ]);

        $firstColumn = Column::query()->latest()->first();

        $firstColumn->cards()->createMany([
            ["text" => fake()->sentence(), "order" => 0],
            ["text" => fake()->sentence(), "order" => 1],
            ["text" => fake()->sentence(), "order" => 2],
            ["text" => fake()->sentence(), "order" => 3],
        ]);

        User::factory()->create(
            [
                "name" => "administrators",
                "email" => "admin@kanban.test",
                "role" => 1
            ]
        );
    }
}
