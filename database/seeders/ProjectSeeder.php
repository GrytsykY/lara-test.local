<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alerts = Alert::select('id')->get()->toArray();

        for ($i = 1; $i < 4; $i++) {
            $project = new Project([
                'title' => 'project_' . $i,
                'id_chat' => $alerts[rand(0, count($alerts) - 1)]['id']
            ]);

            $project->save();
        }
    }
}
