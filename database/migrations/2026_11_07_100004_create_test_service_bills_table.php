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
        Schema::create('test_service_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_number')->unique()->index();
            $table->unsignedInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->double('total_amount', 10, 2)->default(0);
            $table->string('discount_type')->default('percentage'); // percentage or amount
            $table->double('discount_value', 8, 2)->default(0);
            $table->double('discount_amount', 10, 2)->default(0);
            $table->double('net_amount', 10, 2)->default(0);
            $table->tinyInteger('payment_status')->default(1); // 1 = Paid, 0 = Unpaid
            $table->string('payment_method')->default('Cash');
            $table->double('referral_commission_percent', 5, 2)->default(0);
            $table->double('referral_commission_amount', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->nullOnDelete()
                ->onUpdate('cascade');

            $table->foreign('referrer_id')->references('id')->on('referrers')
                ->nullOnDelete()
                ->onUpdate('cascade');

            $table->foreign('created_by')->references('id')->on('users')
                ->nullOnDelete()
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_service_bills');
    }
};

