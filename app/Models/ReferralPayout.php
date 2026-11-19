<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReferralPayout extends Model
{
    public $table = 'referral_payouts';

    public $fillable = [
        'payout_number',
        'referrer_id',
        'amount',
        'payment_method',
        'reference_note',
        'paid_by',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'double',
        'paid_at' => 'datetime',
    ];

    public static $rules = [
        'referrer_id' => 'required|exists:referrers,id',
        'amount' => 'required|numeric|min:1',
        'payment_method' => 'required|string',
        'reference_note' => 'nullable|string',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Referrer::class, 'referrer_id');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public static function generatePayoutNumber(): string
    {
        do {
            $number = 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('payout_number', $number)->exists());

        return $number;
    }
}

