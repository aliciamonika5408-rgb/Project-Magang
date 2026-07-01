<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('whatsapp');
            $table->string('project_type'); // e.g. Konstruksi Baja, Gudang, dll
            $table->string('location');
            $table->string('building_area')->nullable();
            $table->string('budget')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Quotation dynamic docs/blueprints
            $table->string('status')->default('pending'); // pending, reviewed, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_quotations');
    }
};
