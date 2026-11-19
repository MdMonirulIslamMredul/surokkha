<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestServiceBillItem extends Model
{
    public $table = 'test_service_bill_items';

    public $fillable = [
        'test_service_bill_id',
        'item_type',
        'item_id',
        'item_name',
        'price',
        'quantity',
        'amount',
    ];

    protected $casts = [
        'price' => 'double',
        'quantity' => 'integer',
        'amount' => 'double',
    ];

    public function bill(): BelongsTo
    {
        return $this->belongsTo(TestServiceBill::class, 'test_service_bill_id');
    }
}

