<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('assigned_for')->constrained('users');
            $table->foreignId('assigned_by')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(1);
            $table->dateTime('end_date')->nullable();
            $table->enum('priority',[1,2,3,4,5])->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
