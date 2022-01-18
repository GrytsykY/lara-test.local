<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 4; $i++) {
            $alerts = new Alert([
                'name' => 'Prod_'.$i,
                'description' => 'Success_'.$i
            ]);
            $alerts->save();
        }

    }
}
