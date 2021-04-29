<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_created');
            $table->foreignId('sender_wallet_id')->references('id')->on('wallets');
            $table->foreignId('receiver_wallet_id')->references('id')->on('wallets');
            $table->integer('amount');
            $table->integer('commission_payer');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_transactions');
    }
}
