<?php
namespace Modules\Users\Entities\Traits;

trait RoleModelTrait
{
    /*
    |--------------------------------------------------------------------------
    | Assessors
    |--------------------------------------------------------------------------
    |
    */
    public function getUsersBrowseLinkAttribute()
    {
        return 'manage/users/browse/' . $this->slug;
    }



    public function getSampleModulesAttribute()
    {
        $samples_array = module('users')->service('role_sample_modules')->paired('value');
        $sample_string = null;

        foreach ($samples_array as $key => $sample) {
            $sample_string .= "$key: $sample" . LINE_BREAK;
        }
        return $sample_string;
    }



    public function getSampleRulesAttribute()
    {
        $array = [
             "8 : active",
             //"2 : waiting_for_data_completion",
             "1 : pending",
        ];

        return implode(SPACE . LINE_BREAK, $array);
    }



    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    |
    */
    public function browseTabs($tabs_before_bin = [])
    {
        /*-----------------------------------------------
        | When all roles are being browsed ...
        */
        if ($this->slug == 'all' or $this->slug == 'admin') {
            return [
                 ["all", trans('users::criteria.all')],
                 ['bin', trans('manage::forms.general.bin'), '0'],
                 ['search', trans('manage::forms.button.search')],
            ];
        }

        /*-----------------------------------------------
        | When a particular valid role is being browsed ...
        */
        $array[] = ['all', trans('users::criteria.all')];

        foreach ($this->status_rule_array as $key => $item) {
            $status_text = trans_safe("users::criteria.$item");
            $array[]     = [$key, $status_text];
        }

        foreach ($tabs_before_bin as $tab) {
            $array[] = $tab;
        }

        $array[] = [
             'bin',
             trans('users::criteria.banned'),
             null,
             user()
                  ->as('admin')
                  ->can("users - $this->slug . bin"),
        ];
        $array[] = ['search', trans('manage::forms.button.search')];

        return $array;
    }



    public function statusCombo($include_delete_options = false)
    {
        $array = [];
        foreach ($this->status_rule_array as $key => $item) {
            $status_text = trans_safe("users::criteria.$item");
            $array[]     = [$key, $status_text];
        }
        if (!count($array)) {
            $array[] = [1, trans("users::criteria.active")];
        }
        if ($include_delete_options) {
            $array[] = ['ban', trans("users::criteria.banned")];
            $array[] = ['detach', trans("users::permits.detach_this_role")];
        }

        return $array;
    }



    public static function trans($key = null)
    {
        $trans = trans("dynamic.$key");

        if (!$trans) {
            return $key;
        }

        return $trans;
    }
}
