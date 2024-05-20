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
        Schema::create('m_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->enum('gender', ['laki-laki','perempuan']);
            $table->string('address');
            $table->string('position');
            $table->string('phone')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pegawais');
    }
};
