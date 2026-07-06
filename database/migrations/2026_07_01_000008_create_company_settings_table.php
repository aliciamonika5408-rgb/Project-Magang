<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default statistics values
        DB::table('company_settings')->insert([
            ['key' => 'years_experience', 'value' => '15', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'projects_completed', 'value' => '150', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'experts_count', 'value' => '50', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'work_accidents', 'value' => '0', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
