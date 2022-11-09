<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('ref_transaction_id', 255)->nullable();
            $table->string('ref_order_id', 255)->nullable();
            $table->string('ref_id', 255)->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('currency', 4);
            $table->enum('payment_option', [10, 20])->default(10);
            $table->enum('status', [10, 20, 30, 40])->default(10);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
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
