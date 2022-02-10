<?php

namespace Database\Seeders;

use App\Models\Employment;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'ping-1',
                'flag' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'ping-2',
                'flag' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'ping-3',
                'flag' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('employments')->insert($data);
    }
}
