<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Referrer extends Model
{
    public $table = 'referrers';

    public $fillable = [
        'user_id',
        'refer_code',
        'occupation',
        'address',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'nullable|string|max:100',
        'phone' => 'required|string|max:50',
        'email' => 'nullable|email|max:100',
        'occupation' => 'nullable|string|max:100',
        'address' => 'nullable|string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'referrer_id');
    }

    public function testServiceBills(): HasMany
    {
        return $this->hasMany(TestServiceBill::class, 'referrer_id');
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(ReferralPayout::class, 'referrer_id');
    }

    public function getTotalEarningsAttribute(): float
    {
        return (float) $this->testServiceBills()
            ->where('payment_status', 1)
            ->sum('referral_commission_amount');
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payouts()->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return max(0, round($this->total_earnings - $this->total_paid, 2));
    }

    public static function generateReferCode(): string
    {
        do {
            $code = 'REF-' . strtoupper(Str::random(6));
        } while (self::where('refer_code', $code)->exists());

        return $code;
    }
}

