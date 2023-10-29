<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToStatusColumnInBorrowDevices extends Migration
{
    public function up()
    {
        Schema::table('borrow_devices', function (Blueprint $table) {
            $table->integer('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('borrow_devices', function (Blueprint $table) {
            $table->integer('status')->change();
        });
    }
}
