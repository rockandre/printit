<?php

use Illuminate\Database\Seeder;

class PrintersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $printers = [
            'Dell 2145cn Color Laser MFP PS',
            'HP Color LaserJet 3700',
            'HP Color LaserJet 4700',
            'HP Color LaserJet 9500',
            'HP Color LaserJet CM6040 MFP',
            'HP Color LaserJet CP3525',
            'HP Color LaserJet CP4020-CP4520 Series',
            'HP Color LaserJet CP6015',
            'HP Color LaserJet M551',
            'HP Color LaserJet Pro MFP M277',
            'HP LaserJet 4050 Series',
            'HP LaserJet 4350',
            'HP LaserJet 5M',
            'HP LaserJet 9000 Series',
            'HP LaserJet P3005',
            'HP LaserJet P4010 Series',
            'Pharos Controlled Queue',
            'RICOH Aficio MP C6501 PS',
        ];
        $createdAt = Carbon\Carbon::now()->subMonths(2);
        foreach ($printers as $printer) {
            DB::table('printers')->insert([
                'name' => $printer,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
