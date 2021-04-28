<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_created');
            $table->foreignId('sender_wallet_id')->references('id')->on('wallet');
            $table->foreignId('receiver_wallet_id')->references('id')->on('wallet');
            $table->integer('amount');
            $table->integer('commission_payer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
