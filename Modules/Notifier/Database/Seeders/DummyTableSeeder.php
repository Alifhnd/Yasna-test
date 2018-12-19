<?php

namespace Modules\Notifier\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fillNotifiersTable();
    }



    /**
     * fill notifiers table with dummy data
     *
     * @param int $total
     */
    public function fillNotifiersTable($total = 20)
    {
        $sample_channels = ['sms', 'mail', 'web', 'push', 'fax'];
        $data            = [];

        for ($i = 1; $i <= $total; $i++) {
            $data[] = [
                 "driver"               => $driver = dummy()::slug(),
                 "channel"              => $channel = array_random($sample_channels),
                 "slug"                 => notifier()::generateSlug($channel, $driver),
                 "title"                => notifier()::generateTitle($channel, $driver),
                 "available_for_admins" => rand(0, 1),
                 "meta-data"            => [
                      dummy()::slug() => str_slug(dummy()::englishWord(4)),
                      dummy()::slug() => str_slug(dummy()::englishWord(4)),
                      dummy()::slug() => str_slug(dummy()::englishWord(4)),
                 ],
            ];
        }

        yasna()::seed('notifiers', $data);
    }
}
