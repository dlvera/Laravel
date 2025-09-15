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
    Schema::table('users', function (Blueprint $table) {
        $table->integer('identifier')->unique()->after('id');
        $table->string('phone', 10)->nullable()->after('email');
        $table->string('document', 11)->after('phone');
        $table->date('birthdate')->after('document');
        $table->foreignId('city_id')->constrained()->after('birthdate');
        $table->boolean('is_admin')->default(false)->after('remember_token');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
