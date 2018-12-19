<?php

namespace Modules\Yasna\Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data   = [];
        $data[] = $this->dataArray('superadmin', true);
        $data[] = $this->dataArray('manager', true, $this->defaultAdminModules());
        $data[] = $this->dataArray('member');

        yasna()->seed('roles', $data);
    }



    /**
     * @param       $role_slug
     * @param bool  $is_admin
     * @param array $modules
     *
     * @return array
     */
    private function dataArray($role_slug, $is_admin = false, $modules = [])
    {
        return [
             "slug"         => $role_slug,
             "title"        => trans_safe("yasna::seeders.$role_slug"),
             "plural_title" => trans_safe("yasna::seeders.$role_slug" . 's'),
             "is_admin"     => $is_admin,
             "modules"      => count($modules) ? json_encode($modules) : null,
        ];
    }



    /**
     * @return array
     */
    private function defaultAdminModules()
    {
        $array = [];

        foreach (module('users')->service('role_sample_modules')->paired('value') as $key => $item) {
            $array[$key] = explode_not_empty(',', $item);
        }

        return $array;
    }
}
