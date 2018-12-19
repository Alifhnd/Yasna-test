<?php
namespace Modules\Users\Entities\Traits;

use App\Models\Role;
use App\Models\State;
use Modules\Yasna\Entities\Traits\PermitsTrait;

trait UserModelTrait
{
    use UserElectorTrait;
    use UserCanTrait;
    use UserFormTrait;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    |
    */
    public function getStateAttribute()
    {
        if ($this->city) {
            $state = State::find($this->city);
        }

        if (!isset($state) or !$state) {
            $state = new State();
        }

        return $state;
    }



    /*
    |--------------------------------------------------------------------------
    | Assessors
    |--------------------------------------------------------------------------
    |
    */


    //public function getFullNameAttribute() /* Will Override the original class if uncommented. Do it if you need to. */
    //{
    //}

    public function getAgeAttribute()
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if (!$this->birth_date) {
            return false;
        }

        /*-----------------------------------------------
        | Calculation ...
        */

        return Carbon::now()->diffInYears($this->birth_date);
    }



    public function getProfileLinkAttribute()
    {
        return "manage/users/browse/all/search?id=$this->id&searched=1";
    }



    public function getMobileMaskedAttribute()
    {
        $string = $this->mobile;
        if (strlen($string) == 11) {
            return substr($string, 7) . ' ••• ' . substr($string, 0, 4);
        }

        return $string;
    }



    public function getMobileFormattedAttribute()
    {
        $string = $this->mobile;
        if (strlen($string) == 11) {
            return substr($string, 7) . ' - ' . substr($string, 4, 3) . ' - ' . substr($string, 0, 4);
        }

        return $string;
    }



    public function getMaritalNameAttribute() //TODO: CHECK THIS!  <~~
    {
        switch ($this->marital) {
            case 1:
                return trans('forms.general.married');
            case 2:
                return trans('forms.general.single');
            default:
                return trans("forms.general.unknown");

        }
    }



    public function getEduLevelAttribute($original_value)
    {
        return $original_value + 0;
    }



    public function getEduLevelNameAttribute() //TODO: CHECK THIS!  <~~
    {
        return trans("people.edu_level_full.$this->edu_level");
    }



    public function getEduLevelShortAttribute() //TODO: CHECK THIS!  <~~
    {
        return trans("people.edu_level_short.$this->edu_level");
    }



    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    |
    */
    public function rolesTable()
    {
        return Role::all();
    }



    public function roleStatusCombo()
    {
        return [
             ['', trans('users::permits.without_role')],
             ['active', trans('manage::forms.status_text.active')],
             ['blocked', trans('manage::forms.status_text.blocked')],
        ];
    }
}
