<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalDiagnosis extends Model
{
    use HasFactory;

    public $table = 'clinical_diagnoses';

    public $fillable = [
        'category',
        'subcategory',
        'name',
        'code',
        'description',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'category' => 'string',
        'subcategory' => 'string',
        'name' => 'string',
        'code' => 'string',
        'description' => 'string',
        'status' => 'boolean',
    ];

    public static $rules = [
        'category' => 'required|string|max:150',
        'subcategory' => 'nullable|string|max:150',
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const CATEGORIES = [
        'Orthopedic & Musculoskeletal Conditions' => [
            'Spine & Back',
            'Shoulder',
            'Elbow',
            'Wrist & Hand',
            'Hip & Pelvis',
            'Knee',
            'Ankle & Foot',
            'Other Orthopedic Conditions',
        ],
        'Neurological Conditions' => [
            'Brain & Stroke',
            'Spinal Cord',
            'Neurodegenerative Conditions',
            'Peripheral Nerve Conditions',
            'Other Neurological Problems',
        ],
        'Pediatric Physiotherapy Conditions' => [
            'Developmental Conditions',
            'Cerebral Palsy',
            'Neurodevelopmental Conditions',
            'Pediatric Orthopedic Conditions',
            'Pediatric Respiratory & Functional Rehabilitation',
        ],
        'Geriatric Physiotherapy Conditions' => [
            'General Geriatric Rehabilitation',
        ],
        'Sports Injury & Sports Rehabilitation' => [
            'Common Sports Injuries',
            'Overuse Injuries',
            'Sports Rehabilitation',
        ],
        'Women\'s Health & Gynaecological Physiotherapy' => [
            'Pregnancy Rehabilitation',
            'Postpartum',
            'Pelvic Floor Conditions',
            'Gynaecological Rehabilitation',
            'Breast Cancer Rehabilitation',
        ],
        'Cardiopulmonary & Respiratory Physiotherapy' => [
            'Cardiopulmonary & Respiratory Conditions',
        ],
        'Pain & Functional Rehabilitation' => [
            'Pain & Functional Conditions',
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('subcategory', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%");
        });
    }
}

