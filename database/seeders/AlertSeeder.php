<?php

namespace Database\Seeders;

use App\Models\Alert;
use Carbon\Carbon;
use DB;
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

        $data = array(
            [
                'name' => 'Success',
                'description' => 'Все нормально',
                'class' => 'success',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Primary',
                'description' => 'Не все  плохо',
                'class' => 'primary',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Warning',
                'description' => 'Предупреждение',
                'class' => 'warning',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Danger',
                'description' => 'Все очень плохо',
                'class' => 'danger',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        );

        DB::table('alerts')->insert($data);

    }
}
