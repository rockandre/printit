<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    const OPEN_STATE = 0;

    private $numberOfRootComments = 15;
    private $numberOfMultiLevelComments = 25;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disclaimer: I'm using faker here because Model classes are developed by students
        $faker = Faker\Factory::create('pt_PT');

        $users = DB::table('users')->where('admin', false)->pluck('id')->toArray();
        $requests = DB::table('requests')->where('status', self::OPEN_STATE)->get()->toArray();

        $this->command->info('Creating '.$this->numberOfRootComments.' root comments...');
        for ($i = 0; $i < $this->numberOfRootComments; ++$i) {
            DB::table('comments')->insert($this->fakeComment($faker, $faker->randomElement($requests), $faker->randomElement($users)));
        }

        $this->command->info('Creating '.$this->numberOfMultiLevelComments.' multilevel comments...');
        for ($i = 0; $i < $this->numberOfMultiLevelComments; ++$i) {
            $comment = $this->fakeComment($faker, $faker->randomElement($requests), $faker->randomElement($users));
            $comment['parent_id'] = $faker->randomElement(DB::table('comments')->where('parent_id', null)->pluck('id')->toArray());
            DB::table('comments')->insert($comment);
        }
    }

    private function fakeComment(Faker\Generator $faker, $request, $userId)
    {
        $createdAt = $faker->dateTimeBetween($request->created_at, $request->due_date);

        return [
            'comment' => $faker->realText,
            'user_id' => $userId,
            'request_id' => $request->id,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'blocked' => $faker->boolean(25)
        ];
    }
}
