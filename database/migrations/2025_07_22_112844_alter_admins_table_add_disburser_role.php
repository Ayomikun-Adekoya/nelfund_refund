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
    DB::statement("ALTER TABLE admins MODIFY COLUMN role ENUM('viewer', 'approver', 'disburser') DEFAULT 'viewer'");
}

public function down(): void
{
    DB::statement("ALTER TABLE admins MODIFY COLUMN role ENUM('viewer', 'approver') DEFAULT 'viewer'");
}

};
