<?php

use App\Models\Book;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description');
            $table->bigInteger('quantity');
            $table->timestamps();
        });

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            Book::create([
                'title' => $faker->sentence,
                'author' => $faker->name,
                'description' => $faker->paragraph,
                'quantity' => $faker->numberBetween(1, 10),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
