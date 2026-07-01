<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // e.g. Gudang, Baja, Industri, Steel Erection, dll
            $table->text('description');
            $table->string('location');
            $table->integer('year');
            $table->string('client_name')->nullable();
            $table->string('budget')->nullable();
            $table->string('image')->nullable(); // Primary project image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
