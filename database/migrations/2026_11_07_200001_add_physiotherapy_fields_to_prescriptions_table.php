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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('prescription_type')->default('physiotherapy')->after('doctor_id');
            $table->text('c_c')->nullable()->after('problem_description');
            $table->text('h_o')->nullable()->after('c_c');
            $table->text('s_s')->nullable()->after('h_o');
            $table->text('investigation')->nullable()->after('s_s');
            $table->unsignedTinyInteger('vas')->nullable()->after('investigation');
            $table->text('dx')->nullable()->after('vas');
            $table->text('pt_rx')->nullable()->after('dx');
            $table->text('medication_other_support')->nullable()->after('pt_rx');
            $table->integer('patient_age')->nullable()->after('medication_other_support');
            $table->string('patient_height')->nullable()->after('patient_age');
            $table->string('patient_weight')->nullable()->after('patient_height');
            $table->string('patient_bmi')->nullable()->after('patient_weight');
            $table->string('patient_occupation')->nullable()->after('patient_bmi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn([
                'prescription_type',
                'c_c',
                'h_o',
                's_s',
                'investigation',
                'vas',
                'dx',
                'pt_rx',
                'medication_other_support',
                'patient_age',
                'patient_height',
                'patient_weight',
                'patient_bmi',
                'patient_occupation',
            ]);
        });
    }
};

