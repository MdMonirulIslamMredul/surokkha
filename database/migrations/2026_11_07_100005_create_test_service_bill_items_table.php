<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_service_bill_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_service_bill_id');
            $table->string('item_type'); // pathology, radiology, service
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');
            $table->double('price', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->double('amount', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('test_service_bill_id')->references('id')->on('test_service_bills')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_service_bill_items');
    }
};

