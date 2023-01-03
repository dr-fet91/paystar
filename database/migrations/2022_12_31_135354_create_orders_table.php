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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('payment_object')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->smallInteger('payment_type')->default(0)->comment('0 => online, 1 => offline, 2 => cash');
            $table->smallInteger('payment_status')->default(0)->comment('0 => not proccess, 1 => in proccess, 2 => fail, 3 => success');
            $table->smallInteger('order_status')->default(0)->comment('0 => not proccess, 1 => in proccess, 2 => fail, 3 => success');
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
        Schema::dropIfExists('orders');
    }
};
