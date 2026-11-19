<?php

namespace Database\Seeders;

use App\Models\ClinicalDiagnosis;
use Illuminate\Database\Seeder;

class ClinicalDiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diagnoses = [
            // 1. Orthopedic & Musculoskeletal Conditions
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Spine & Back',
                'items' => [
                    'Low Back Pain',
                    'Mechanical Back Pain',
                    'Lumbar Spondylosis',
                    'Lumbar Disc Prolapse / PLID',
                    'Sciatica',
                    'Lumbar Radiculopathy',
                    'Spinal Stenosis',
                    'Spondylolisthesis',
                    'Spondylolysis',
                    'Cervical Spondylosis',
                    'Cervical Radiculopathy',
                    'Neck Pain',
                    'Thoracic Spine Pain',
                    'Kyphosis',
                    'Lordosis',
                    'Scoliosis',
                    'Coccyx/Tailbone Pain',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Shoulder',
                'items' => [
                    'Frozen Shoulder / Adhesive Capsulitis',
                    'Rotator Cuff Injury',
                    'Rotator Cuff Tendinopathy',
                    'Shoulder Impingement',
                    'Shoulder Bursitis',
                    'Shoulder Instability',
                    'Shoulder Dislocation Rehabilitation',
                    'Labral Injury',
                    'Post-operative Shoulder Rehabilitation',
                    'Scapular Dyskinesia',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Elbow',
                'items' => [
                    'Tennis Elbow / Lateral Epicondylitis',
                    'Golfer\'s Elbow / Medial Epicondylitis',
                    'Elbow Bursitis',
                    'Elbow Stiffness',
                    'Elbow Instability',
                    'Post-fracture Elbow Rehabilitation',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Wrist & Hand',
                'items' => [
                    'Carpal Tunnel Syndrome',
                    'Wrist Tendinopathy',
                    'De Quervain\'s Tenosynovitis',
                    'Wrist Sprain',
                    'Hand Injury',
                    'Finger Stiffness',
                    'Trigger Finger',
                    'Post-fracture Hand Rehabilitation',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Hip & Pelvis',
                'items' => [
                    'Hip Osteoarthritis',
                    'Hip Pain',
                    'Hip Bursitis',
                    'Greater Trochanteric Pain Syndrome',
                    'Hip Impingement',
                    'Hip Tendinopathy',
                    'Hip Muscle Strain',
                    'Post Hip Replacement Rehabilitation',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Knee',
                'items' => [
                    'Knee Osteoarthritis',
                    'Patellofemoral Pain Syndrome',
                    'Patellar Tendinopathy',
                    'Meniscus Injury',
                    'ACL Injury',
                    'PCL Injury',
                    'MCL/LCL Injury',
                    'Knee Instability',
                    'Knee Stiffness',
                    'Bursitis',
                    'Post ACL Reconstruction Rehabilitation',
                    'Post Knee Replacement Rehabilitation',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Ankle & Foot',
                'items' => [
                    'Ankle Sprain',
                    'Achilles Tendinopathy',
                    'Plantar Fasciitis',
                    'Heel Pain',
                    'Flat Foot',
                    'High Arch',
                    'Shin Splints',
                    'Foot/Ankle Arthritis',
                    'Achilles Rupture Rehabilitation',
                    'Ankle Instability',
                    'Post-fracture Rehabilitation',
                ],
            ],
            [
                'category' => 'Orthopedic & Musculoskeletal Conditions',
                'subcategory' => 'Other Orthopedic Conditions',
                'items' => [
                    'Osteoarthritis',
                    'Rheumatoid Arthritis',
                    'Ankylosing Spondylitis',
                    'Osteoporosis-related Functional Problems',
                    'Fracture Rehabilitation',
                    'Joint Replacement Rehabilitation',
                    'Post-operative Rehabilitation',
                    'Muscle Strains',
                    'Ligament Injuries',
                    'Tendon Injuries',
                    'Soft Tissue Injuries',
                    'Posture-related Pain',
                ],
            ],

            // 2. Neurological Conditions
            [
                'category' => 'Neurological Conditions',
                'subcategory' => 'Brain & Stroke',
                'items' => [
                    'Stroke / Cerebrovascular Accident',
                    'Hemiplegia',
                    'Hemiparesis',
                    'Post-stroke Spasticity',
                    'Post-stroke Balance Problems',
                    'Traumatic Brain Injury',
                    'Concussion Rehabilitation',
                    'Brain Injury Rehabilitation',
                ],
            ],
            [
                'category' => 'Neurological Conditions',
                'subcategory' => 'Spinal Cord',
                'items' => [
                    'Spinal Cord Injury',
                    'Paraplegia',
                    'Quadriplegia / Tetraplegia',
                    'Incomplete Spinal Cord Injury',
                    'Spinal Cord Compression Rehabilitation',
                ],
            ],
            [
                'category' => 'Neurological Conditions',
                'subcategory' => 'Neurodegenerative Conditions',
                'items' => [
                    'Parkinson\'s Disease',
                    'Multiple Sclerosis',
                    'Motor Neuron Disease',
                    'Alzheimer\'s Disease – Functional Rehabilitation',
                    'Huntington\'s Disease',
                ],
            ],
            [
                'category' => 'Neurological Conditions',
                'subcategory' => 'Peripheral Nerve Conditions',
                'items' => [
                    'Peripheral Neuropathy',
                    'Diabetic Neuropathy',
                    'Guillain-Barré Syndrome',
                    'Bell\'s Palsy',
                    'Facial Nerve Palsy',
                    'Radial Nerve Injury',
                    'Median Nerve Injury',
                    'Ulnar Nerve Injury',
                    'Sciatic Nerve Injury',
                ],
            ],
            [
                'category' => 'Neurological Conditions',
                'subcategory' => 'Other Neurological Problems',
                'items' => [
                    'Cerebral Ataxia',
                    'Vestibular Disorders',
                    'Vertigo / BPPV',
                    'Balance Disorders',
                    'Coordination Problems',
                    'Gait Abnormalities',
                    'Neurological Weakness',
                    'Muscle Tone Abnormalities',
                ],
            ],

            // 3. Pediatric Physiotherapy Conditions
            [
                'category' => 'Pediatric Physiotherapy Conditions',
                'subcategory' => 'Developmental Conditions',
                'items' => [
                    'Developmental Delay',
                    'Gross Motor Delay',
                    'Delayed Milestones',
                    'Hypotonia',
                    'Hypertonia',
                    'Abnormal Muscle Tone',
                    'Developmental Coordination Disorder',
                ],
            ],
            [
                'category' => 'Pediatric Physiotherapy Conditions',
                'subcategory' => 'Cerebral Palsy',
                'items' => [
                    'Cerebral Palsy',
                    'Spastic Cerebral Palsy',
                    'Dyskinetic Cerebral Palsy',
                    'Ataxic Cerebral Palsy',
                    'Hemiplegic CP',
                    'Diplegic CP',
                    'Quadriplegic CP',
                    'Gait Problems in CP',
                    'Spasticity Management',
                ],
            ],
            [
                'category' => 'Pediatric Physiotherapy Conditions',
                'subcategory' => 'Neurodevelopmental Conditions',
                'items' => [
                    'Autism Spectrum Disorder – Functional/Motor Rehabilitation',
                    'ADHD – Motor/Coordination Rehabilitation',
                    'Down Syndrome',
                    'Genetic/Chromosomal Conditions with Motor Impairment',
                    'Intellectual Disability with Functional Motor Problems',
                ],
            ],
            [
                'category' => 'Pediatric Physiotherapy Conditions',
                'subcategory' => 'Pediatric Orthopedic Conditions',
                'items' => [
                    'Clubfoot',
                    'Developmental Dysplasia of Hip',
                    'Torticollis',
                    'Flat Foot',
                    'Knock Knees',
                    'Bow Legs',
                    'Scoliosis',
                    'Pediatric Fractures',
                    'Pediatric Sports Injuries',
                ],
            ],
            [
                'category' => 'Pediatric Physiotherapy Conditions',
                'subcategory' => 'Pediatric Respiratory & Functional Rehabilitation',
                'items' => [
                    'Pediatric Respiratory Dysfunction',
                    'Post-operative Pediatric Rehabilitation',
                    'Exercise Intolerance',
                    'Mobility and Balance Problems',
                ],
            ],

            // 4. Geriatric Physiotherapy Conditions
            [
                'category' => 'Geriatric Physiotherapy Conditions',
                'subcategory' => 'General Geriatric Rehabilitation',
                'items' => [
                    'Age-related Muscle Weakness',
                    'Sarcopenia',
                    'Osteoarthritis',
                    'Osteoporosis',
                    'Fall Risk',
                    'Recurrent Falls',
                    'Balance Disorders',
                    'Walking/Gait Problems',
                    'Post-stroke Disability',
                    'Parkinson\'s Disease',
                    'Joint Stiffness',
                    'Chronic Back Pain',
                    'Chronic Neck Pain',
                    'Shoulder Problems',
                    'Knee Problems',
                    'Hip Problems',
                    'Post Hip Replacement Rehabilitation',
                    'Post Knee Replacement Rehabilitation',
                    'Fracture Rehabilitation',
                    'Functional Decline',
                    'Mobility Limitation',
                    'Frailty',
                    'Reduced Cardiopulmonary Endurance',
                    'Post-hospitalization Deconditioning',
                ],
            ],

            // 5. Sports Injury & Sports Rehabilitation
            [
                'category' => 'Sports Injury & Sports Rehabilitation',
                'subcategory' => 'Common Sports Injuries',
                'items' => [
                    'ACL Injury',
                    'PCL Injury',
                    'MCL Injury',
                    'LCL Injury',
                    'Meniscus Injury',
                    'Ankle Sprain',
                    'Achilles Tendon Injury',
                    'Hamstring Strain',
                    'Quadriceps Strain',
                    'Calf Muscle Strain',
                    'Groin Injury',
                    'Hip Flexor Injury',
                    'Shoulder Dislocation',
                    'Shoulder Instability',
                    'Rotator Cuff Injury',
                    'Tennis Elbow',
                    'Wrist Injury',
                ],
            ],
            [
                'category' => 'Sports Injury & Sports Rehabilitation',
                'subcategory' => 'Overuse Injuries',
                'items' => [
                    'Tendinopathy',
                    'Tendinitis',
                    'Shin Splints',
                    'Plantar Fasciitis',
                    'Runner\'s Knee',
                    'Jumper\'s Knee',
                    'IT Band Syndrome',
                    'Stress Injuries',
                    'Repetitive Strain Injuries',
                ],
            ],
            [
                'category' => 'Sports Injury & Sports Rehabilitation',
                'subcategory' => 'Sports Rehabilitation',
                'items' => [
                    'Pre-surgery Rehabilitation',
                    'Post-surgery Rehabilitation',
                    'ACL Reconstruction Rehabilitation',
                    'Return-to-Sport Rehabilitation',
                    'Strength & Conditioning',
                    'Sports Performance Training',
                    'Injury Prevention',
                    'Functional Movement Assessment',
                    'Gait & Running Analysis',
                    'Balance & Proprioception Training',
                ],
            ],

            // 6. Women's Health & Gynaecological Physiotherapy
            [
                'category' => 'Women\'s Health & Gynaecological Physiotherapy',
                'subcategory' => 'Pregnancy Rehabilitation',
                'items' => [
                    'Pregnancy-related Back Pain',
                    'Pregnancy-related Pelvic Pain',
                    'Pelvic Girdle Pain',
                    'Sacroiliac Joint Dysfunction',
                    'Postural Problems During Pregnancy',
                    'Pregnancy-related Musculoskeletal Pain',
                    'Prenatal Exercise & Fitness',
                ],
            ],
            [
                'category' => 'Women\'s Health & Gynaecological Physiotherapy',
                'subcategory' => 'Postpartum',
                'items' => [
                    'Postpartum Rehabilitation',
                    'Post-Cesarean Rehabilitation',
                    'Abdominal Muscle Weakness',
                    'Diastasis Recti',
                    'Postpartum Back Pain',
                    'Pelvic Floor Weakness',
                    'Postpartum Pelvic Pain',
                    'Return-to-Exercise Rehabilitation',
                ],
            ],
            [
                'category' => 'Women\'s Health & Gynaecological Physiotherapy',
                'subcategory' => 'Pelvic Floor Conditions',
                'items' => [
                    'Urinary Incontinence',
                    'Stress Urinary Incontinence',
                    'Urge Incontinence',
                    'Mixed Urinary Incontinence',
                    'Pelvic Floor Dysfunction',
                    'Pelvic Organ Prolapse – Physiotherapy Management',
                    'Pelvic Floor Muscle Weakness',
                    'Pelvic Pain',
                    'Constipation-related Pelvic Floor Dysfunction',
                ],
            ],
            [
                'category' => 'Women\'s Health & Gynaecological Physiotherapy',
                'subcategory' => 'Gynaecological Rehabilitation',
                'items' => [
                    'Chronic Pelvic Pain',
                    'Post-gynaecological Surgery Rehabilitation',
                    'Hysterectomy Rehabilitation',
                    'Pelvic Surgery Rehabilitation',
                    'Endometriosis-related Musculoskeletal/Pelvic Pain',
                    'Vulvodynia-related Pelvic Floor Dysfunction',
                ],
            ],
            [
                'category' => 'Women\'s Health & Gynaecological Physiotherapy',
                'subcategory' => 'Breast Cancer Rehabilitation',
                'items' => [
                    'Post-Mastectomy Rehabilitation',
                    'Shoulder Dysfunction after Breast Surgery',
                    'Lymphedema Management',
                    'Post-radiation Functional Rehabilitation',
                ],
            ],

            // 7. Cardiopulmonary & Respiratory Physiotherapy
            [
                'category' => 'Cardiopulmonary & Respiratory Physiotherapy',
                'subcategory' => 'Cardiopulmonary & Respiratory Conditions',
                'items' => [
                    'COPD',
                    'Asthma – Exercise/Functional Rehabilitation',
                    'Chronic Respiratory Disease',
                    'Post-pneumonia Rehabilitation',
                    'Post-COVID Functional Rehabilitation',
                    'Breathing Pattern Disorders',
                    'Reduced Exercise Tolerance',
                    'Cardiac Rehabilitation',
                    'Post-Cardiac Surgery Rehabilitation',
                    'Post-CABG Rehabilitation',
                    'ICU/critical illness rehabilitation',
                    'Post-hospitalization deconditioning',
                ],
            ],

            // 8. Pain & Functional Rehabilitation
            [
                'category' => 'Pain & Functional Rehabilitation',
                'subcategory' => 'Pain & Functional Conditions',
                'items' => [
                    'Chronic Pain',
                    'Acute Musculoskeletal Pain',
                    'Myofascial Pain',
                    'Fibromyalgia-related Functional Problems',
                    'Headache-associated Neck Dysfunction',
                    'TMJ Dysfunction',
                    'Chronic Fatigue-related Deconditioning',
                    'Postural Dysfunction',
                    'Occupational/Repetitive Strain Problems',
                ],
            ],
        ];

        foreach ($diagnoses as $group) {
            foreach ($group['items'] as $name) {
                ClinicalDiagnosis::firstOrCreate(
                    [
                        'name' => trim($name),
                        'category' => $group['category'],
                    ],
                    [
                        'subcategory' => $group['subcategory'],
                        'status' => true,
                    ]
                );
            }
        }
    }
}

