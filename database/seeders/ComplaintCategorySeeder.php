<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComplaintCategory;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Noise Disturbance',
                'description' => 'Excessive noise that disturbs peace and order in the community',
                'republic_act' => 'RA 386 (Civil Code)',
                'is_active' => true,
            ],
            [
                'name' => 'Illegal Parking',
                'description' => 'Vehicles parked in unauthorized areas or blocking pathways',
                'republic_act' => 'RA 4136 (Land Transportation Code)',
                'is_active' => true,
            ],
            [
                'name' => 'Domestic Violence',
                'description' => 'Violence against women and children within households',
                'republic_act' => 'RA 9262 (Anti-VAWC)',
                'is_active' => true,
            ],
            [
                'name' => 'Property Dispute',
                'description' => 'Disputes over property boundaries, ownership, or usage',
                'republic_act' => 'RA 386 (Civil Code)',
                'is_active' => true,
            ],
            [
                'name' => 'Illegal Gambling',
                'description' => 'Unauthorized gambling activities in the barangay',
                'republic_act' => 'PD 1602 (Anti-Gambling)',
                'is_active' => true,
            ],
            [
                'name' => 'Waste Disposal Violation',
                'description' => 'Improper disposal of garbage and waste materials',
                'republic_act' => 'RA 9003 (Ecological Solid Waste Management)',
                'is_active' => true,
            ],
            [
                'name' => 'Stray Animals',
                'description' => 'Concerns about stray or dangerous animals in the community',
                'republic_act' => 'RA 8485 (Animal Welfare Act)',
                'is_active' => true,
            ],
            [
                'name' => 'Child Abuse',
                'description' => 'Any form of abuse or neglect towards children',
                'republic_act' => 'RA 7610 (Special Protection of Children)',
                'is_active' => true,
            ],
            [
                'name' => 'Public Safety Hazard',
                'description' => 'Conditions that pose danger to public safety',
                'republic_act' => 'Local Government Code',
                'is_active' => true,
            ],
            [
                'name' => 'Illegal Construction',
                'description' => 'Construction without proper permits or violating building codes',
                'republic_act' => 'PD 1096 (National Building Code)',
                'is_active' => true,
            ],
            [
                'name' => 'Other',
                'description' => 'Other complaints not covered by specific categories',
                'republic_act' => null,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ComplaintCategory::create($category);
        }
    }
}
