<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('uniqueIndex');

            $table->integer('user');
            $table->tinyInteger('isSession');
            $table->string('tag', 255);

            $table->string('colleague', 255);
            $table->string('reference', 255);
            $table->string('task', 255);

            $table->string('startTime', 255);
            $table->string('endTime', 255);
            $table->tinyInteger('completed');

            $table->tinyInteger('hiddenRow');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
