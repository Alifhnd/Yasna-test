<?php

namespace Modules\Yasna\Entities\Traits;

trait UserUsernameTrait
{
    /**
     * get the username field name
     *
     * @return string
     */
    public function usernameField()
    {
        return config('auth.providers.users.field_name');
    }



    /**
     * get the username, considering the dynamic username field
     *
     * @return string
     */
    public function getUsernameAttribute()
    {
        $property = $this->usernameField();

        return $this->$property;
    }



    /**
     * find a user by their username, considering the dynamic username field
     *
     * @param string $username
     * @param bool   $with_trashed
     *
     * @return \App\Models\User
     */
    public function findByUsername($username, $with_trashed = false)
    {
        $builder = user()->where($this->usernameField(), $username);

        if ($with_trashed) {
            $builder = $builder->withTrashed();
        }

        $model = $builder->first();

        if (!$model) {
            $model = model("user");
        }

        return $model;
    }
}
