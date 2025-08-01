<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $busNames = [
            'DAMRI AC 01',
            'DAMRI AC 02',
            'DAMRI AC 03',
            'DAMRI AC 04',
            'DAMRI AC 05',
            'DAMRI AC 06',
            'DAMRI AC 07',
            'DAMRI AC 08',
            'DAMRI AC 09',
            'DAMRI AC 10',
            'DAMRI AC 11',
            'DAMRI AC 12',
            'DAMRI AC 13',
            'DAMRI AC 14',
            'DAMRI AC 15',
            'DAMRI AC 16',
            'DAMRI AC 17',
            'DAMRI AC 18',
            'DAMRI AC 19'
        ];

        $statuses = ['active', 'maintenance', 'inactive'];
        $usedPlateNumbers = [];

        for ($i = 0; $i < 19; $i++) {
            // Generate unique plate number with PA prefix
            do {
                $plateNumber = $this->generatePlateNumber();
            } while (in_array($plateNumber, $usedPlateNumbers));

            $usedPlateNumbers[] = $plateNumber;

            DB::table('buses')->insert([
                'name' => $busNames[$i],
                'plate_number' => $plateNumber,
                'total_seats' => 19,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Generate plate number with PA prefix, 4-digit number, and AI suffix
     */
    private function generatePlateNumber(): string
    {
        // PA prefix (Palu, Central Sulawesi)
        $prefix = 'PA';

        // Random 4-digit number (1000-9999)
        $number = rand(1000, 9999);

        // Fixed AI suffix
        $suffix = 'AI';

        return $prefix . ' ' . $number . ' ' . $suffix;
    }
}
