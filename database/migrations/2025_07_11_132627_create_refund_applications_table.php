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
    Schema::create('refund_applications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('eligible_student_id'); // foreign key to eligible_students
        $table->string('account_name');
        $table->string('account_number');
        $table->string('bank_name');
        $table->string('proof_file'); // path to uploaded file
        $table->enum('status', ['submitted', 'approved', 'declined'])->default('submitted');
        $table->timestamps();

        $table->foreign('eligible_student_id')->references('id')->on('eligible_students')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('refund_applications');
}

};
