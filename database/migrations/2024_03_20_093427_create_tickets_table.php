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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("asset_id");
            $table->foreignId("staff_id")->nullable();
            $table->foreignId("boss_id")->nullable();
            $table->foreignId("technician_boss_id")->nullable();
            $table->foreignId("department_id");
            $table->string('ticket_number');
            $table->enum('type', ['produksi', 'it']);
            $table->string('condition');
            $table->text('description');
            $table->text("problem_analysis")->nullable();
            $table->text("action")->nullable();
            $table->dateTime('damage_time')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('finish_time')->nullable();
            $table->enum("status", ["waiting approval", "rejected", "process", "closed", "waiting process","waiting closed"]);
            $table->foreignId('created_by');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
