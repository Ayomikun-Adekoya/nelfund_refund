<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('refund_applications', function (Blueprint $table) {
        $table->timestamp('submitted_at')->nullable();
        $table->timestamp('approved_at')->nullable();
        $table->timestamp('disbursed_at')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refund_applications', function (Blueprint $table) {
            //
        });
    }
};
