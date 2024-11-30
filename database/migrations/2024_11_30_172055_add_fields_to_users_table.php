<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('behance')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('specialization')->nullable();
            $table->text('cv')->nullable();
            $table->string('college')->nullable();
            $table->string('university')->nullable();
            $table->string('level')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('account_type', ['user', 'company'])->default('user');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'linkedin',
                'github',
                'behance',
                'birthdate',
                'specialization',
                'cv',
                'college',
                'university',
                'level',
                'first_name',
                'last_name',
                'account_type'
            ]);
        });
    }
};
