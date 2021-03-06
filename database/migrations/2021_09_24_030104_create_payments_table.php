<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('method')->nullable();
            $table->string('payload')->nullable();
            $table->string('receipt_no')->nullable();
            $table->json('log')->nullable();
            $table->json('bank_details')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('adjust', 15, 2)->nullable();
            $table->decimal('dues', 15, 2)->nullable();
            $table->string('status')->default('pending');
            $table->string('created_by')->nullable();
            $table->string('received_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
