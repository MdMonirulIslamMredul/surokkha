<?php

namespace Database\Seeders;

use App\Models\ClinicDepartment;
use Illuminate\Database\Seeder;

class ClinicDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'title' => 'Orthopedic Physiotherapy',
                'slug' => 'orthopedic-physiotherapy',
                'image' => 'uploads/clinic_departments/WhatsApp Image 2026-10-13 at 11.16.26 PM.jpeg',
                'short_description' => 'Comprehensive evaluation, rehabilitation, and management of bone, joint, ligament, tendon, and muscular conditions for rapid functional recovery.',
                'details' => '<h3>Restoring Mobility, Strength, and Joint Function</h3>
<p>Orthopedic Physiotherapy focuses on the diagnosis, management, and treatment of disorders and injuries of the musculoskeletal system. At <strong>Surokkha Physiotherapy & Autism Care</strong>, our licensed orthopedic physical therapists design personalized rehabilitation programs to reduce pain, increase range of motion, and rebuild functional strength.</p>
<h4>Key Conditions Treated:</h4>
<ul>
    <li><strong>Joint Osteoarthritis & Arthritis:</strong> Knee, hip, shoulder, and spinal joint degeneration management.</li>
    <li><strong>Post-Surgical Rehabilitation:</strong> Total knee/hip replacement (TKR/THR), ligament reconstruction (ACL/PCL), and fracture post-fixation recovery.</li>
    <li><strong>Spinal Disorders:</strong> Cervical spondylosis, lumbar disc herniation, sciatica, and chronic lower back pain.</li>
    <li><strong>Tendinopathies & Sprains:</strong> Frozen shoulder (adhesive capsulitis), tennis elbow, rotator cuff injuries, and ankle sprains.</li>
</ul>
<h4>Our Evidence-Based Treatment Techniques:</h4>
<ul>
    <li>Joint mobilization and manipulation therapy</li>
    <li>Therapeutic stretching and progressive resistance strengthening exercises</li>
    <li>Electrotherapy modalities (TENS, Ultrasound Therapy, Shortwave Diathermy)</li>
    <li>Postural alignment retraining and ergonomic counseling</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Neurological Physiotherapy',
                'slug' => 'neurological-physiotherapy',
                'image' => 'uploads/clinic_departments/Neurological Physiotherapy 1.jpeg',
                'short_description' => 'Targeted neuro-rehabilitation helping patients suffering from stroke, paralysis, spinal trauma, and neuromuscular disorders regain functional independence.',
                'details' => '<h3>Neuroplasticity-Driven Recovery & Motor Retraining</h3>
<p>Neurological physiotherapy is dedicated to the assessment and rehabilitation of patients with physical impairments caused by neurological conditions. Our goal is to promote neuroplasticity—the brain and nervous system’s natural ability to reorganize pathways and restore lost muscle control and coordination.</p>
<h4>Neurological Conditions We Treat:</h4>
<ul>
    <li><strong>Stroke & Hemiplegia:</strong> Paralysis recovery, upper and lower extremity motor control re-education.</li>
    <li><strong>Spinal Cord Injuries (SCI):</strong> Paraplegia, quadriplegia mobility training, and wheelchair independence.</li>
    <li><strong>Parkinson\'s Disease & Tremors:</strong> Gait training, rigidity reduction, and balance optimization.</li>
    <li><strong>Bell\'s Palsy & Facial Nerve Palsy:</strong> Neuromuscular facial re-education and stimulation.</li>
    <li><strong>Neuropathies & Motor Neuron Disease:</strong> Peripheral neuropathy, Guillain-Barré Syndrome (GBS), and multiple sclerosis.</li>
</ul>
<h4>Specialized Neurological Rehabilitation:</h4>
<ul>
    <li>Bobath / Neuro-Developmental Treatment (NDT) approaches</li>
    <li>Functional electrical stimulation (FES) and gait laboratory training</li>
    <li>Balance, proprioception, and coordination rehabilitation</li>
    <li>Activities of Daily Living (ADL) retraining for independent living</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Pediatric Physiotherapy',
                'slug' => 'pediatric-physiotherapy',
                'image' => 'uploads/clinic_departments/Pediatric Physiotherapy 1.jpeg',
                'short_description' => 'Gentle, play-based physical therapy designed to assist infants, toddlers, and adolescents in reaching vital developmental milestones.',
                'details' => '<h3>Helping Children Grow, Move, and Thrive Confidently</h3>
<p>Children have unique anatomical, physiological, and emotional needs. Our Pediatric Physiotherapy department provides compassionate, family-centered therapy in a warm, friendly environment equipped with specialized child-friendly rehabilitation equipment.</p>
<h4>Pediatric Conditions Managed:</h4>
<ul>
    <li><strong>Developmental Milestone Delays:</strong> Late head holding, sitting, crawling, or unassisted walking.</li>
    <li><strong>Cerebral Palsy (CP):</strong> Spastic, athetoid, and ataxic motor management, postural control, and deformity prevention.</li>
    <li><strong>Congenital Musculoskeletal Conditions:</strong> Clubfoot (CTEV), congenital muscular torticollis (wry neck), and arthrogryposis.</li>
    <li><strong>Hypotonia & Hypertonia:</strong> Abnormal muscle tone balance and functional stability exercises.</li>
    <li><strong>Genetic & Neuromuscular Disorders:</strong> Down Syndrome, Spinal Muscular Atrophy (SMA), and Muscular Dystrophies.</li>
</ul>
<h4>Therapeutic Interventions:</h4>
<ul>
    <li>Play-oriented developmental movement therapy</li>
    <li>Sensory-motor integration and vestibular stimulation</li>
    <li>Postural management, orthotic recommendation, and assistive device training</li>
    <li>Parent education and guided home exercise routines</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Autism Care',
                'slug' => 'autism-care',
                'image' => 'uploads/clinic_departments/Special Child Care  4.jpg',
                'short_description' => 'Holistic, specialized intervention programs focusing on sensory integration, communication, motor planning, and behavioral adaptation for autistic individuals.',
                'details' => '<h3>Empowering Children on the Autism Spectrum</h3>
<p>At <strong>Surokkha Autism Care Center</strong>, we embrace neurodiversity and empower children with Autism Spectrum Disorder (ASD) to reach their highest personal potential. We offer multidisciplinary sensory integration and motor coordination programs tailored to each child\'s individual sensory profile.</p>
<h4>Key Intervention Pillars:</h4>
<ul>
    <li><strong>Sensory Integration Therapy:</strong> Providing structured sensory input to address tactile defensiveness, vestibular imbalances, and proprioceptive regulation.</li>
    <li><strong>Motor Planning & Dyspraxia Management:</strong> Enhancing gross motor and fine motor planning, spatial awareness, and bilateral coordination.</li>
    <li><strong>Daily Life Functional Skills:</strong> Teaching self-care tasks including dressing, eating, grooming, and classroom posture endurance.</li>
    <li><strong>Social Engagement & Play Therapy:</strong> Fostering joint attention, turn-taking, and peer interaction in small therapeutic groups.</li>
</ul>
<h4>Our Center Amenities & Approaches:</h4>
<ul>
    <li>Custom-built sensory integration gyms with therapeutic swings, ball pools, and crash mats</li>
    <li>Calm, sensory-soothing treatment suites to prevent sensory overload</li>
    <li>Close collaboration between physical therapists, speech experts, and occupational specialists</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Special Child Care',
                'slug' => 'special-child-care',
                'image' => 'uploads/clinic_departments/Special Child Care 1.jpg',
                'short_description' => 'Compassionate care and therapeutic excellence for children with special physical, cognitive, and intellectual challenges.',
                'details' => '<h3>Nurturing Every Unique Child with Dedicated Love & Expertise</h3>
<p>Every child is gifted with boundless possibilities. The Special Child Care department at Surokkha provides individualized rehabilitation plans for children with diverse physical, intellectual, and behavioral challenges.</p>
<h4>Special Needs Addressed:</h4>
<ul>
    <li>Down Syndrome and chromosome-related developmental anomalies</li>
    <li>Attention Deficit Hyperactivity Disorder (ADHD) and behavioral regulation challenges</li>
    <li>Global Developmental Delay (GDD) and intellectual disabilities</li>
    <li>Physical disabilities, limb deficiencies, and mobility restrictions</li>
</ul>
<h4>Holistic Care Features:</h4>
<ul>
    <li>Comprehensive developmental assessments and milestone tracking</li>
    <li>Adaptive motor therapy, strength conditioning, and gait training</li>
    <li>Assistive devices selection (wheelchairs, walkers, customized splints/AFOs)</li>
    <li>Parental counseling and psychological support programs</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Women\'s Health Physiotherapy',
                'slug' => 'womens-health-physiotherapy',
                'image' => 'uploads/clinic_departments/Women’s Heath Physiotherapy 1.jpeg',
                'short_description' => 'Dedicated therapy for women at all stages of life, covering antenatal, postnatal, pelvic floor health, and bone wellness.',
                'details' => '<h3>Comprehensive Healthcare for Every Stage of Womanhood</h3>
<p>Women go through unique physiological transformations throughout their lives, including pregnancy, childbirth, and menopause. Our Women\'s Health Physiotherapy team provides evidence-based therapies in a confidential, comfortable, and dignified setting.</p>
<h4>Clinical Areas of Focus:</h4>
<ul>
    <li><strong>Prenatal Physiotherapy:</strong> Relieving pregnancy backache, pelvic girdle pain (PGP), sacroiliac joint dysfunction, and preparing for safe labor.</li>
    <li><strong>Postnatal Rehabilitation:</strong> Diastasis Recti (abdominal muscle separation) correction, pelvic floor retraining, and core rebuilding.</li>
    <li><strong>Pelvic Floor Dysfunction:</strong> Stress and urge urinary incontinence, pelvic organ prolapse management, and pelvic floor weakness.</li>
    <li><strong>Bone & Joint Health:</strong> Prevention and treatment of osteopenia, osteoporosis, and post-menopausal musculoskeletal stiffness.</li>
</ul>
<h4>Therapeutic Modalities:</h4>
<ul>
    <li>Biofeedback and pelvic floor muscle training (Kegel exercises)</li>
    <li>Safe prenatal and postnatal therapeutic exercise regimens</li>
    <li>Manual therapy for pelvic alignment and lower back decompression</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Geriatric Physiotherapy',
                'slug' => 'geriatric-physiotherapy',
                'image' => 'uploads/clinic_departments/Geriatric Physiotherapy 1.jpeg',
                'short_description' => 'Specialized therapeutic interventions for senior citizens to maintain active mobility, prevent fall risks, and preserve independent living.',
                'details' => '<h3>Promoting Graceful Aging, Safety, and Independence</h3>
<p>Aging naturally brings changes to bone density, muscle mass, joint elasticity, and balance. Our Geriatric Physiotherapy department helps senior patients stay mobile, active, and self-reliant while safely preventing falls and relieving chronic pain.</p>
<h4>Key Senior Health Conditions:</h4>
<ul>
    <li><strong>Fall Risk & Balance Disorders:</strong> Vestibular degradation, gait instability, and fear of falling.</li>
    <li><strong>Severe Osteoarthritis:</strong> Degenerative joint disease of knees, hips, and spine.</li>
    <li><strong>Osteoporosis:</strong> Postural deformities (kyphosis), fracture prevention, and bone-strengthening exercises.</li>
    <li><strong>Post-Surgical Frailty:</strong> Recovery following hip fractures, joint replacements, and cardiac interventions.</li>
</ul>
<h4>Rehabilitation Strategy:</h4>
<ul>
    <li>Balance, proprioception, and coordinated gait training</li>
    <li>Safe low-impact strength and flexibility conditioning</li>
    <li>Joint protection techniques and energy conservation coaching</li>
    <li>Mobility aids fitting (canes, quadripods, walkers) and home hazard assessments</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Sports Physiotherapy',
                'slug' => 'sports-physiotherapy',
                'image' => 'uploads/clinic_departments/Sports Physiotherapy 1.jpeg',
                'short_description' => 'Fast-track sports injury rehabilitation, athletic performance enhancement, and proactive biomechanical injury prevention.',
                'details' => '<h3>Accelerate Recovery & Return to Peak Performance</h3>
<p>Whether you are a professional athlete, weekend runner, or fitness enthusiast, our Sports Physiotherapy specialists diagnose, treat, and rehabilitate acute and overuse athletic injuries using elite sports medicine methodologies.</p>
<h4>Common Sports Injuries Treated:</h4>
<ul>
    <li><strong>Ligament Tears:</strong> Anterior cruciate ligament (ACL), MCL, PCL, and ankle syndesmosis sprains.</li>
    <li><strong>Muscle Strains:</strong> Hamstring tears, groin strains, quadriceps pulls, and calf muscle strains.</li>
    <li><strong>Overuse Injuries:</strong> Patellofemoral pain syndrome (Runner\'s knee), shin splints, plantar fasciitis, and Achilles tendinitis.</li>
    <li><strong>Shoulder & Upper Limb:</strong> Rotator cuff impingement, shoulder dislocation rehab, and tennis/golfer\'s elbow.</li>
</ul>
<h4>Sports Medicine Techniques:</h4>
<ul>
    <li>Functional movement screening (FMS) and biomechanical analysis</li>
    <li>Kinesiology taping and sports strapping</li>
    <li>Plyometric retraining, agility drills, and sport-specific return-to-play conditioning</li>
    <li>Cryotherapy, contrast therapy, and sports manual therapy</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Hand and Foot Reflexology',
                'slug' => 'hand-and-foot-reflexology',
                'image' => 'uploads/clinic_departments/Hand and Foot Reflexology 1.jpg',
                'short_description' => 'Therapeutic reflex zone stimulation restoring systemic equilibrium, improving vascular circulation, and alleviating chronic stress.',
                'details' => '<h3>Holistic Healing Through Targeted Pressure Point Therapy</h3>
<p>Hand and Foot Reflexology is an ancient, therapeutic modality based on the clinical principle that specific reflex points on the hands and feet correspond directly to different organs, glands, and biological systems throughout the body.</p>
<h4>Key Health Benefits:</h4>
<ul>
    <li><strong>Circulatory Enhancement:</strong> Stimulates blood and lymphatic flow, accelerating the elimination of metabolic toxins.</li>
    <li><strong>Neurological Calming:</strong> Triggers the parasympathetic nervous system to eliminate anxiety, tension, and chronic stress.</li>
    <li><strong>Chronic Pain Relief:</strong> Highly effective for peripheral neuropathy symptoms, plantar fasciitis, headaches, and fibromyalgia.</li>
    <li><strong>Immune System Support:</strong> Balances energy meridians and reinforces immune vitality.</li>
</ul>
<h4>Ideal Candidates For Reflexology:</h4>
<ul>
    <li>Individuals with chronic fatigue, insomnia, or restless leg syndrome</li>
    <li>Patients suffering from diabetes-related foot numbness and circulation challenges</li>
    <li>Anyone seeking deep physical relaxation and holistic wellness</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Sports and Therapeutic Massage',
                'slug' => 'sports-and-therapeutic-massage',
                'image' => 'uploads/clinic_departments/Sports and Therapeutic Massage 1.jpg',
                'short_description' => 'Deep tissue therapy, myofascial release, and neuromuscular massage relieving muscular tension, knots, and joint stiffness.',
                'details' => '<h3>Release Muscle Tightness & Restore Natural Flexibility</h3>
<p>Our Therapeutic Massage sessions are performed by trained clinical therapists who understand human anatomy and muscular biomechanics. We target deep fascia and muscle groups to eliminate chronic trigger points, loosen tight bands, and revitalize stiff muscles.</p>
<h4>Types of Therapeutic Massage:</h4>
<ul>
    <li><strong>Deep Tissue Massage:</strong> Targets deeper layers of muscle tissue to alleviate persistent spasms, postural stiffness, and back strain.</li>
    <li><strong>Myofascial Release (MFR):</strong> Applies sustained gentle pressure into the myofascial connective tissue restrictions to eliminate pain and restore motion.</li>
    <li><strong>Sports Recovery Massage:</strong> Reduces post-exercise delayed onset muscle soreness (DOMS) and flushes lactic acid buildup.</li>
    <li><strong>Trigger Point Therapy:</strong> Deactivates painful hyper-irritable spots within taut bands of skeletal muscle fibers.</li>
</ul>
<h4>Therapeutic Benefits:</h4>
<ul>
    <li>Immediate relief from neck, shoulder, and lower back tightness</li>
    <li>Enhanced muscle elasticity, joint range of motion, and tissue oxygenation</li>
    <li>Accelerated recovery between intense training sessions or hard work days</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Dry Needling and Acupuncture',
                'slug' => 'dry-needling-and-acupuncture',
                'image' => 'uploads/clinic_departments/Dry Needling and Acupuncture 1.jpg',
                'short_description' => 'Modern western trigger point dry needling and acupuncture techniques for rapid pain relief and neuromuscular stimulation.',
                'details' => '<h3>Targeted Trigger Point Deactivation & Pain Elimination</h3>
<p>Dry Needling is an innovative, highly effective western medical technique utilizing sterile, ultra-fine filiform needles to penetrate deep myofascial trigger points, release chronic tension, and reset nerve receptors for lasting pain relief.</p>
<h4>How It Works:</h4>
<p>When a specialized micro-needle is precisely inserted into a myofascial trigger point, it elicits a Local Twitch Response (LTR). This mechanical stimulation releases locked muscle fibers, encourages immediate microcirculation, and alters biochemical pain neurotransmitters.</p>
<h4>Conditions Benefiting from Dry Needling:</h4>
<ul>
    <li>Chronic neck pain, tension headaches, and temporomandibular joint (TMJ) dysfunction</li>
    <li>Lower back spasms, piriformis syndrome, and sciatica pain</li>
    <li>Fibromyalgia, chronic myofascial pain syndrome, and chronic shoulder impingement</li>
    <li>Tennis elbow, golfer\'s elbow, and recalcitrant plantar fasciitis</li>
</ul>
<h4>Patient Safety & Hygiene:</h4>
<p>All procedures are performed by certified clinicians using single-use, gamma-sterilized needles following strict universal antiseptic protocols.</p>',
                'is_active' => true,
            ],
            [
                'title' => 'Food and Nutrition',
                'slug' => 'food-and-nutrition',
                'image' => 'uploads/clinic_departments/Food and Nutrition 1.jpg',
                'short_description' => 'Scientific nutritional guidance, therapeutic meal planning, and metabolic dietary care for sustainable lifelong wellness.',
                'details' => '<h3>Fueling Your Body for Peak Health & Healing</h3>
<p>Proper clinical nutrition is the cornerstone of healing and longevity. At Surokkha, our registered nutritionists and clinical dietitians design personalized, evidence-based nutrition plans tailored to your health goals, medical conditions, and lifestyle.</p>
<h4>Clinical Nutrition Specializations:</h4>
<ul>
    <li><strong>Therapeutic Recovery Diet:</strong> Anti-inflammatory nutrition to accelerate tissue repair after orthopedic surgery and sports trauma.</li>
    <li><strong>Pediatric & Autism Nutrition:</strong> Specialized dietary plans for autistic children, focusing on gut health, food sensitivities, and sensory-friendly textures.</li>
    <li><strong>Weight & Metabolic Management:</strong> Sustainable fat loss, metabolic syndrome reversal, insulin resistance, and cholesterol control.</li>
    <li><strong>Chronic Disease Management:</strong> Diabetic meal planning, renal health, hypertension management, and gastrointestinal care (IBS/GERD).</li>
    <li><strong>Elderly Nutrition:</strong> Nutrient-dense plans preventing muscle sarcopenia and bone mineral density loss.</li>
</ul>
<h4>What Our Consultations Include:</h4>
<ul>
    <li>Comprehensive Body Composition Analysis (BCA) and metabolic rate assessment</li>
    <li>Customized weekly meal plans with practical, locally accessible food choices</li>
    <li>Nutritional supplement guidance and continuous progress monitoring</li>
</ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Home Care',
                'slug' => 'home-care',
                'image' => 'uploads/clinic_departments/Home Care 1.jpg',
                'short_description' => 'Professional, compassionate physiotherapy and medical nursing services delivered in the safety and comfort of your home.',
                'details' => '<h3>Hospital-Quality Physiotherapy at Your Doorstep</h3>
<p>For patients who are bedridden, recovering from major surgery, elderly, or unable to travel to our clinic, Surokkha offers comprehensive Home Care services. Our licensed physiotherapists bring professional clinical care and portable rehabilitation equipment directly to your residence.</p>
<h4>Who Benefits From Home Care Services?</h4>
<ul>
    <li><strong>Post-Surgical Patients:</strong> Safe rehabilitation right after joint replacement or fracture surgery without the stress of clinic commutes.</li>
    <li><strong>Stroke & Paralysis Patients:</strong> Bedside neuro-rehabilitation, transfer training, and bedside mobility exercises.</li>
    <li><strong>Elderly & Frail Seniors:</strong> Gentle balance exercises, fall-prevention training, and assisted walking in familiar surroundings.</li>
    <li><strong>Palliative & Bedbound Patients:</strong> Chest physiotherapy, contracture prevention, and position-changing protocols to prevent pressure ulcers (bedsores).</li>
</ul>
<h4>What We Bring To Your Home:</h4>
<ul>
    <li>Portable electrotherapy equipment (TENS, Muscle Stimulators, Ultrasound)</li>
    <li>Therapeutic exercise bands, weights, and mobilization devices</li>
    <li>Family/caregiver training for ongoing daily patient support</li>
</ul>',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $data) {
            ClinicDepartment::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
