<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TestServiceBill extends Model
{
    public $table = 'test_service_bills';

    const STATUS_PAID = 1;
    const STATUS_UNPAID = 0;

    public $fillable = [
        'bill_number',
        'patient_id',
        'doctor_id',
        'referrer_id',
        'total_amount',
        'discount_type',
        'discount_value',
        'discount_amount',
        'net_amount',
        'payment_status',
        'payment_method',
        'referral_commission_percent',
        'referral_commission_amount',
        'note',
        'created_by',
    ];

    protected $casts = [
        'total_amount' => 'double',
        'discount_value' => 'double',
        'discount_amount' => 'double',
        'net_amount' => 'double',
        'payment_status' => 'integer',
        'referral_commission_percent' => 'double',
        'referral_commission_amount' => 'double',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Referrer::class, 'referrer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TestServiceBillItem::class, 'test_service_bill_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateBillNumber(): string
    {
        do {
            $number = 'TSB-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('bill_number', $number)->exists());

        return $number;
    }
}

