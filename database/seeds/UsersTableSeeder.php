<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $photoPath = 'public/profiles';
    private $numberOfActivatedUsers = 20;
    private $numberOfActivatedAdmins = 5;
    private $numberOfBlockedUsers = 5;
    private $numberOfNonActivatedUsers = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->table(['Users table seeder notice'], [
            ['Profile photos will be stored on path '.storage_path('app/'.$this->photoPath)],
            ['A progress bar is displayed because photos will be downloaded from lorempixel'],
            ['Edit this file to change the storage path or the number of users']
        ]);


        if ($this->command->confirm('Do you wish to delete photos from '.storage_path('app/'.$this->photoPath).'?', true)) {
            Storage::deleteDirectory($this->photoPath);
        }
        Storage::makeDirectory($this->photoPath);

        // Disclaimer: I'm using faker here because Model classes are developed by students
        $faker = Faker\Factory::create('pt_PT');

        $departments = DB::table('departments')->pluck('id')->toArray();

        $this->command->info('Creating '.$this->numberOfActivatedUsers.' active users...');
        $bar = $this->command->getOutput()->createProgressBar($this->numberOfActivatedUsers);
        for ($i = 0; $i < $this->numberOfActivatedUsers; ++$i) {
            DB::table('users')->insert($this->fakeUser($faker, $faker->randomElement($departments)));
            $bar->advance();
        }
        $bar->finish();
        $this->command->info('');

        $this->command->info('Creating '.$this->numberOfActivatedAdmins.' active admins...');
        $bar = $this->command->getOutput()->createProgressBar($this->numberOfActivatedAdmins);
        for ($i = 0; $i < $this->numberOfActivatedAdmins; ++$i) {
            $user = $this->fakeUser($faker, $faker->randomElement($departments));
            $user['admin'] = true;
            DB::table('users')->insert($user);
            $bar->advance();
        }
        $bar->finish();
        $this->command->info('');

        $this->command->info('Creating '.$this->numberOfBlockedUsers.' blocked users...');
        $bar = $this->command->getOutput()->createProgressBar($this->numberOfBlockedUsers);
        for ($i = 0; $i < $this->numberOfBlockedUsers; ++$i) {
            $user = $this->fakeUser($faker, $faker->randomElement($departments));
            $user['blocked'] = true;
            DB::table('users')->insert($user);
            $bar->advance();
        }
        $bar->finish();
        $this->command->info('');

        $this->command->info('Creating '.$this->numberOfNonActivatedUsers.' non activated users...');
        $bar = $this->command->getOutput()->createProgressBar($this->numberOfNonActivatedUsers);
        for ($i = 0; $i < $this->numberOfNonActivatedUsers; ++$i) {
            $user = $this->fakeUser($faker, $faker->randomElement($departments));
            $user['activated'] = false;
            DB::table('users')->insert($user);
            $bar->advance();
        }
        $bar->finish();
        $this->command->info('');

        // Creates the requested users from Rules
        $user = $this->fakeUser($faker, $faker->randomElement($departments));
        $user['name'] = 'User';
        $user['email'] = 'user@mail.pt';
        $user['password'] = bcrypt('user123');
        DB::table('users')->insert($user);

        $user = $this->fakeUser($faker, $faker->randomElement($departments));
        $user['name'] = 'Administrator';
        $user['email'] = 'admin@mail.pt';
        $user['password'] = bcrypt('admin123');
        $user['admin'] = true;
        DB::table('users')->insert($user);
    }

    private function fakeUser(Faker\Generator $faker, $departmentId)
    {
        static $password;
        $createdAt = Carbon\Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => str_random(10),
            'phone' => $faker->randomElement([null, $faker->phoneNumber]),
            'presentation' => $faker->randomElement([null, $faker->realText]),
            'profile_url' => $faker->randomElement([null, $faker->url]),
            'profile_photo' => $faker->randomElement([null, $faker->image(storage_path('app/'.$this->photoPath), 180, 180, 'people', false)]),
            'department_id' => $departmentId,
            'activated' => true,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'print_evals' => $faker->numberBetween(1, 3),
            'print_counts' => $faker->numberBetween(1, 500)
        ];
    }
}
