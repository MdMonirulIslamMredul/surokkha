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
        Schema::create('referral_payouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payout_number')->unique()->index();
            $table->unsignedBigInteger('referrer_id');
            $table->double('amount', 10, 2);
            $table->string('payment_method')->default('Cash'); // Cash, Bank, bKash, Nagad
            $table->text('reference_note')->nullable();
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->dateTime('paid_at');
            $table->timestamps();

            $table->foreign('referrer_id')->references('id')->on('referrers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('paid_by')->references('id')->on('users')
                ->nullOnDelete()
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_payouts');
    }
};

