<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,3) as $key => $value) {
            Topic::FirstOrCreate([
                'name' => "topic{$value}"
            ]);
        }
    }
}
