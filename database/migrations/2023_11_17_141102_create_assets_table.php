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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('country')->nullable();
            $table->string('year')->nullable();
            $table->integer('quantity');
            $table->string('unit')->nullable();
            $table->string('price')->nullable();
            $table->string('note')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('device_type_id');
            $table->foreign('device_type_id')->references('id')->on('device_types');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->string('type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};