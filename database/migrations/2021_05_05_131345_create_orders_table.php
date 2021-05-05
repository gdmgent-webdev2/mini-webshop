<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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

            // also name, street, invoice address, company name, ...
            $table->string('status')->default('created');

            // TODO add user_id

            $table->timestamps();
        });

        Schema::create('order_product', function(Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('order_id')->constrained('orders');

            $table->integer('price');
            $table->integer('quantity');

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
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
}
