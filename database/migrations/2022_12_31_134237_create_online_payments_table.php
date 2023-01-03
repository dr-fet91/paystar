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
        Schema::create('online_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('order_id');
            $table->bigInteger('amount')->nullable();
            $table->string('gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('card_number')->nullable();
            $table->json('bank_first_response')->nullable();
            $table->json('bank_second_response')->nullable();
            $table->smallInteger('status')->default(0)->comment('0 => not proccess, 1 => in proccess, 2 => fail, 3 => success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_payments');
    }
};
