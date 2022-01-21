<?php

namespace Database\Seeders;

use App\Models\Alert;
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
//        for ($i = 1; $i < 4; $i++) {
//            $alerts = new Alert([
//                'name' => 'Prod_' . $i,
//                'description' => 'Success_' . $i
//            ]);
//            $alerts->save();
//        }

        $data = array(
            [
                'name' => 'Success',
                'description' => 'Все нормально',
                'class' => 'success'
            ],
            [
                'name' => 'Primary',
                'description' => 'Не все  плохо',
                'class' => 'primary'
            ],
            [
                'name' => 'Warning',
                'description' => 'Предупреждение',
                'class' => 'warning'
            ],
            [
                'name' => 'Danger',
                'description' => 'Все очень плохо',
                'class' => 'danger'
            ],
        );

        DB::table('alerts')->insert($data);

    }
}
