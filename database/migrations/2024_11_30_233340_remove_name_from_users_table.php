<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remove the 'name' column from the 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name'); // Remove 'name' column
        });
    }

    public function down()
    {
        // Add the 'name' column back in case of rollback
        Schema::table('users', function (Blueprint $table) {
            $table->string('name'); // Or use other suitable data type
        });
    }
};
