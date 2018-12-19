<?php

namespace Modules\Users\Database\Seeders;

use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Yasna\Providers\DummyServiceProvider;

class DummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->usersTable();
        $this->rolesTable();
        $this->roleAttachment();
    }



    public function usersTable($total = 200)
    {
        $counter = 0;

        while ($counter < $total) {
            $counter++;

            $deleted = boolval(rand(1, 20) > 18);
            $state   = State::getCities(0)->inRandomOrder()->first();

            User::store([
                 'code_melli'    => rand(1111111111, min(9999999999, getrandmax())),
                 'email'         => DummyServiceProvider::email(),
                 'name_first'    => DummyServiceProvider::persianName(),
                 'name_last'     => DummyServiceProvider::persianFamily(),
                 'name_father'   => DummyServiceProvider::persianName(),
                 'gender'        => rand(1, 2),
                 'mobile'        => "09" . rand(111111111, min(399999999, getrandmax())),
                 'tel_emergency' => "09" . rand(111111111, min(399999999, getrandmax())),
                 'tel'           => "0" . rand(2111111111, min(7999999999, getrandmax())),
                 'province'      => $state->province()->id,
                 'city'          => $state->id,
                 'home_address'  => DummyServiceProvider::persianText(1),
                 'postal_code'   => rand(1111111111, min(9999999999, getrandmax())),
                 'deleted_at'    => $deleted ? Carbon::now()->toDateTimeString() : null,
                 'deleted_by'    => $deleted ? User::inRandomOrder()->first()->id : 0,
                 'created_by'    => User::inRandomOrder()->first()->id,

            ]);
        }
    }



    public function rolesTable()
    {
        $this->supportiveRoles();
        $this->domainRoles();
    }



    public function supportiveRoles($total = 5)
    {
        $array = [];
        for ($i = 1; $i <= $total; $i++) {
            $array[] = [
                 "slug"         => "support-" . DummyServiceProvider::slug(),
                 "title"        => "پشتیبانی " . $title = DummyServiceProvider::persianWord(),
                 "plural_title" => "پشتیبان‌های " . $title,
                 "meta-icon"    => "life-ring",
            ];
        }

        yasna()->seed('roles', $array);
    }



    public function domainRoles($total = 5)
    {
        if (model('domain')->count() < 2) {
            $this->domainsTable($total);
        }

        $data = [];
        foreach (model('domain')->all() as $domain) {
            $data[] = [
                 "slug"         => "domain-$domain->slug",
                 "title"        => "سرپرست " . $domain->title,
                 "plural_title" => "سرپرست‌های " . $domain->title,
                 "meta-icon"    => "code-branch",
                 "is_admin"     => true,
                 'modules'      => json_encode([
                      'posts' => ['create', 'edit', 'publish', 'report', 'delete', 'bin'],
                 ]),

            ];
        }

        yasna()->seed('roles', $data);
    }



    public function domainsTable($total = 5)
    {
        $array = [];
        for ($i = 1; $i <= $total; $i++) {
            $array[] = [
                 "slug"  => DummyServiceProvider::slug(),
                 "title" => DummyServiceProvider::persianWord(),
            ];
        }

        yasna()->seed('domains', $array);
    }



    public function roleAttachment($total = 100)
    {
        for ($i = 1; $i <= $total; $i++) {
            $random_user = model('user')->inRandomOrder()->first();
            $random_role = model('role')->inRandomOrder()->first();

            $random_user->attach($random_role->slug, array_random([1, 2, 8]));
        }
    }
}
