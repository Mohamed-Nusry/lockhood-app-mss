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
            $table->string('order_no')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('customer_name');
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('total')->nullable();
            $table->integer('payment_status')->default(1); //1 = Cash, 2 = Card, 3 = Checkque
            $table->string('reference')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('status')->default(0); //0 = Temporary, 1 = Pending, 2 = Accepted, 3 = Completed, 4 = Rejected
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
