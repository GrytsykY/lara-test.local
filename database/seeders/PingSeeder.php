<?php

namespace Database\Seeders;

use App\Models\Ping;
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
        $ping = new Ping([
            'start1' => 1,
            'start2' => 1,
            'start3' => 1,
        ]);
        $ping->save();
    }
}
