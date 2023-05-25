<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table-> json('ingredients')->after('image');
            $table-> json('directions')->after('ingredients');
            $table-> string('time_required')->after('directions');
            $table-> bigInteger('servings')->after('time_required');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('ingredients');
            $table->dropColumn('directions');
            $table->dropColumn('time_required');
            $table->dropColumn('servings');
        });
        
    }
};
