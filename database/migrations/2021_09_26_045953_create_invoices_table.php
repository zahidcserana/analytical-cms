<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_no')->unique();
            $table->string('receive_no')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('paid', 15, 2)->nullable();
            $table->string('status')->default('pending');
            $table->integer('type')->default('1');
            $table->date('invoice_date')->nullable();

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
        Schema::dropIfExists('invoices');
    }
}
