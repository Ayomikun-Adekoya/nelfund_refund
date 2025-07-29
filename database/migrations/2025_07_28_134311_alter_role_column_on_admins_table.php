<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRoleColumnOnAdminsTable extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role', 20)->change(); // Increase from 10 to 20
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role', 10)->change(); // Optional rollback
        });
    }
}
