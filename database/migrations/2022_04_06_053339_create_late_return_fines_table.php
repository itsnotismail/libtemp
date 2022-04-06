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
        Schema::create('late_return_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained();
            $table->decimal('fine_amount', 8, 2);
            $table->date('payment_date')->nullable();
            $table->enum('payment',['Yes','No'])->default('No');
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
        Schema::dropIfExists('late_return_fines');
    }
};
