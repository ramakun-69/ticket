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
        Schema::create('m_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->enum("type",["produksi","it"]);
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('category', ['mesin', 'utilities', 'sipil','non-mesin','hardware','software','service']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_assets');
    }
};
