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
    Schema::table('eligible_students', function (Blueprint $table) {
        $table->decimal('levies', 10, 2)->nullable()->after('loanamount');
    });
}

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('eligible_students', function (Blueprint $table) {
        $table->dropColumn('levies');
    });
}
};
