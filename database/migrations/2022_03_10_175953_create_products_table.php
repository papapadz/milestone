<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('supplier_id')->constrained('suppliers')->nullable();
            $table->string('name', 4096);
            $table->integer('quantity')->nullable();
            $table->enum('unit', ['kilogram', 'sacks', 'tons'])->nullable();
            $table->date('date_ordered')->nullable();
            $table->date('date_delivered')->nullable();
            $table->enum('moving', ['fast', 'slow']);
            $table->smallInteger('active')->default(1);
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
        Schema::dropIfExists('products');
    }
}
