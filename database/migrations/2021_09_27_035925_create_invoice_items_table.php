<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('buyer')->nullable();
            $table->string('style')->nullable();
            $table->string('color')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('area')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
