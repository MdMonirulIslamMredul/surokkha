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
        Schema::table('patients', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('patient_unique_id');
            $table->string('height')->nullable()->after('age');
            $table->string('weight')->nullable()->after('height');
            $table->decimal('bmi', 5, 2)->nullable()->after('weight');
            $table->string('occupation')->nullable()->after('bmi');
            $table->unsignedBigInteger('referrer_id')->nullable()->after('occupation');

            $table->foreign('referrer_id')->references('id')->on('referrers')
                ->nullOnDelete()
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['referrer_id']);
            $table->dropColumn(['age', 'height', 'weight', 'bmi', 'occupation', 'referrer_id']);
        });
    }
};

