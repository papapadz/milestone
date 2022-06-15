<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained('products');
            $table->enum('type', ['rice', 'darak']);
            $table->bigInteger('type_id')->comment('rice_id : darak_id');
            $table->integer('quantity');
            $table->enum('unit', ['kilogram', 'sacks', 'tons'])->nullable();
            $table->float('amount', 8, 2)->commen('sale price');
            $table->float('total_amount', 8, 2);
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('sales');
    }
}
