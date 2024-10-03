<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // Self-referencing for nesting
            $table->string('name_lv');
            $table->string('name_en');
            $table->string('name_ru');
            $table->string('slug_lv')->unique();
            $table->string('slug_en')->unique();
            $table->string('slug_ru')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
