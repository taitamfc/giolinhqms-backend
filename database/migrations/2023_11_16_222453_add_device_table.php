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
        Schema::table('devices', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('country')->nullable();
            $table->string('year')->nullable();
            $table->string('unit')->nullable();
            $table->string('note')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('year_born');
            $table->dropColumn('unit');
            $table->dropColumn('note');
            $table->dropColumn('classify');
        });
    }
};