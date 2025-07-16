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
        $table->string('tracking_id')->unique()->after('status');
    });
}

public function down()
{
    Schema::table('refund_applications', function (Blueprint $table) {
        $table->dropColumn('tracking_id');
    });
}

};
