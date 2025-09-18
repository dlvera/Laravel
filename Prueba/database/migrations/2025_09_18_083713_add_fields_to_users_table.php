<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identifier')->unique()->after('id');
            $table->string('phone', 15)->nullable()->after('email');
            $table->string('cedula', 11)->after('phone');
            $table->date('birth_date')->after('cedula');
            $table->foreignId('city_id')->nullable()->after('birth_date')->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['identifier', 'phone', 'cedula', 'birth_date', 'city_id']);
        });
    }
};