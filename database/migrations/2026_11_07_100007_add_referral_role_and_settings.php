<?php

use App\Models\Department;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add Referral Role / Department if not present
        if (! Department::where('name', 'Referral')->exists()) {
            Department::create([
                'name' => 'Referral',
                'is_active' => true,
                'guard_name' => 'web',
            ]);
        }

        // Add default referral commission percentage setting
        if (! Setting::where('key', 'referral_commission_percentage')->exists()) {
            Setting::create([
                'key' => 'referral_commission_percentage',
                'value' => '10',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Department::where('name', 'Referral')->delete();
        Setting::where('key', 'referral_commission_percentage')->delete();
    }
};

