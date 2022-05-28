<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('image', 256)->nullable();
            $table->string('question', 1000);
            $table->string('option_a', 256);
            $table->string('option_b', 256);
            $table->string('option_c', 256);
            $table->string('option_d', 256);
            $table->string('option_e', 256);
            $table->enum('right_option', ['a', 'b', 'c', 'd', 'e']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
