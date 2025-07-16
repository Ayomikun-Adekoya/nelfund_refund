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
    Schema::create('loanapproval', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('fullName')->nullable();
        $table->string('matric', 50);
        $table->string('trackingID', 512)->unique();
        $table->integer('level')->nullable();
        $table->string('faculty', 512)->nullable();
        $table->enum('status', ['approved', 'rejected', 'pending', ''])->default('approved');
        $table->string('session', 20)->default('2024/2025');
        $table->integer('batch')->default(2);
        $table->timestamps(); // Adds created_at and updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loanapproval');
    }
};
