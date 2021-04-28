<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_balance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->references('id')->on('transaction');
            $table->integer('amount');
            $table->integer('current_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_balance');
    }
}
