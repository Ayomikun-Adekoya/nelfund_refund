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
        Schema::create('eligible_students', function (Blueprint $table) {
            $table->id();
            $table->string('matric_number')->unique();
            $table->string('full_name');
            $table->decimal('loanamount', 10, 2)->nullable();
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->string('faculty')->nullable();
            $table->decimal('amountpaid', 10, 2)->nullable();
            $table->string('paymentmode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligible_students');
    }
};
