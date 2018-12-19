<?php

namespace Modules\Yasna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class YasnaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(SettingsTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(DeveloperTableSeeder::class);
    }
}
