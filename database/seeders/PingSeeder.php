<?php

namespace Database\Seeders;

use App\Models\Ping;
use DB;
use Illuminate\Database\Seeder;

class PingSeeder extends Seeder
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
                'flag' => 1
            ],
            [
                'title' => 'ping-2',
                'flag' => 1
            ],
            [
                'title' => 'ping-3',
                'flag' => 1
            ]
        ];
        DB::table('pings')->insert($data);
    }
}
