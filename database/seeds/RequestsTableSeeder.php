<?php

use Illuminate\Database\Seeder;

class RequestsTableSeeder extends Seeder
{
    // Change these properties to reflect student's use of status fields
    const OPEN_STATE = 0;
    const REFUSE_STATE = 1;
    const COMPLETE_STATE = 2;

    const A3 = 3;
    const A4 = 4;

    const DRAFT = 0;
    const NORMAL = 1;
    const PHOTO = 2;

    private $sizes = [self::A3, self::A4];
    private $types = [self::DRAFT, self::NORMAL, self::PHOTO];


    private $filesPath = 'print-jobs';
    private $numberOfOpenedRequests = 10;
    private $numberOfRefusedRequests = 5;
    private $numberOfCompletedRequests = 15;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->table(['Requests table seeder notice'], [
            ['Printer files will be stored on path '.storage_path('app/'.$this->filesPath)],
            ['Edit this file to change the storage path or the number of requests to generate']
        ]);

        if ($this->command->confirm('Do you wish to delete previous request files from '.storage_path('app/'.$this->filesPath).'?', true)) {
            Storage::deleteDirectory($this->filesPath, true);
        }
        Storage::makeDirectory($this->filesPath);

        // Disclaimer: I'm using faker here because Model classes are developed by students
        $faker = Faker\Factory::create('pt_PT');

        $normalUsers = DB::table('users')->where('admin', false)->pluck('id')->toArray();
        $admins = DB::table('users')->where('admin', true)->pluck('id')->toArray();
        $printers = DB::table('printers')->pluck('id')->toArray();

        $this->command->info('Creating '.$this->numberOfOpenedRequests.' open requests...');
        for ($i = 0; $i < $this->numberOfOpenedRequests; ++$i) {
            DB::table('requests')->insert($this->fakeRequest($faker, $faker->randomElement($normalUsers), self::OPEN_STATE));
        }

        $this->command->info('Creating '.$this->numberOfRefusedRequests.' refused requests...');
        for ($i = 0; $i < $this->numberOfRefusedRequests; ++$i) {
            $request = $this->fakeRequest($faker, $faker->randomElement($normalUsers), self::REFUSE_STATE);
            $request['closed_user_id'] = $faker->randomElement($admins);
            $request['closed_date'] = $faker->dateTimeBetween($request['created_at'], $request['due_date']);
            $request['refused_reason'] = $faker->realText;
            DB::table('requests')->insert($request);
        }

        $this->command->info('Creating '.$this->numberOfCompletedRequests.' completed requests...');
        for ($i = 0; $i < $this->numberOfCompletedRequests; ++$i) {
            $request = $this->fakeRequest($faker, $faker->randomElement($normalUsers), self::COMPLETE_STATE);
            $request['closed_user_id'] = $faker->randomElement($admins);
            $request['closed_date'] = $faker->dateTimeBetween($request['created_at'], $request['due_date']);
            $request['satisfaction_grade'] = $faker->numberBetween(1, 3);
            $request['printer_id'] = $faker->randomElement($printers);
            DB::table('requests')->insert($request);
        }
    }

    private function fakeRequest(Faker\Generator $faker, $ownerId, $status)
    {
        $createdAt = Carbon\Carbon::now()->subDays(20);
        $updatedAt = $faker->dateTimeBetween($createdAt);
        $targetDir = $this->filesPath.'/'.$ownerId;
        Storage::makeDirectory($targetDir);

        return [
            'owner_id' => $ownerId,
            'status' => $status,
            'due_date' => $faker->dateTimeBetween($createdAt->addDays(1), '+30 days'),
            'description' => $faker->randomElement([null, $faker->realText]),
            'quantity' => $faker->numberBetween(1, 40),
            'paper_size' => $faker->randomElement($this->sizes),
            'paper_type' => $faker->randomElement($this->types),
            'file' => $faker->file(database_path('seeds/samples'), storage_path('app/'.$targetDir), false),
            'colored' => $faker->boolean,
            'stapled' => $faker->boolean,
            'front_back' => $faker->boolean,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt
        ];
    }
}
