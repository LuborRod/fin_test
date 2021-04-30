<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_transaction_id')->references('id')->on('users_transactions');
            $table->bigInteger('amount');
            $table->bigInteger('current_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_transactions');
    }
}
