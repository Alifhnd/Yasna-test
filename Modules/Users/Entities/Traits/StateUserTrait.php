<?php namespace Modules\Users\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class StateUserTrait
 *
 * @package Modules\Users\Entities\Traits
 * @property $id
 */
trait StateUserTrait
{
    /**
     * @return Builder
     */
    public function users()
    {
        return $this->usersRelationQuery('province', 'city');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsersAttribute()
    {
        return $this->users()->get();
    }



    /**
     * @return Builder
     */
    public function usersBornIn()
    {
        return $this->usersRelationQuery(null, 'birth_city');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsersBornInAttribute()
    {
        return $this->usersBornIn()->get();
    }



    /**
     * @return Builder
     */
    public function usersEducatedIn()
    {
        return $this->usersRelationQuery('edu_province', 'edu_city');
    }



    /**
     * @return Builder
     */
    public function getUsersEducatedInAttribute()
    {
        return $this->usersEducatedIn();
    }



    /**
     * gets the field names, corresponding to province and city, and makes the appropriate query, based on the nature
     * of its own row.
     *
     * @param string $field_name_if_province
     * @param string $field_name_if_state
     *
     * @return Builder
     */
    private function usersRelationQuery(string $field_name_if_province, string $field_name_if_state)
    {
        if ($this->isProvince()) {
            $field_name = $field_name_if_province;
        } else {
            $field_name = $field_name_if_state;
        }

        if ($field_name) {
            return user()->where($field_name, $this->id);
        } else {
            return user()->where('id', 0);
        }
    }
}
