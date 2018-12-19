<?php namespace Modules\Users\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserElectorTrait
 *
 * @package Modules\Users\Entities\Traits
 * @method Builder elector()
 * @method mixed getElector(string $parameter_name)
 * @method string issetElector(string $parameter_name)
 * @method Builder electorFieldValue($field, $value)
 */
trait UserElectorTrait
{

    /**
     * Removes Developer from the queries, when a non-developer is logged in.
     */
    protected function consistentElectorExcludeDevelopers()
    {
        if (!dev()) {
            $this->elector()->where('id', '!=', $this->getDeveloperId());
        }
    }



    /**
     * Searches for exact email address
     *
     * @param $email
     */
    protected function electorEmail($email)
    {
        $this->electorFieldValue('email', $email);
    }



    /**
     * Searches for similar email addresses
     *
     * @param $email
     */
    protected function electorEmailLike($email)
    {
        $this->electorFieldLike('email', $email);
    }



    /**
     * Searches for exact code_melli
     *
     * @param $code
     */
    protected function electorCodeMelli($code)
    {
        $this->electorFieldValue('code_melli', $code);
    }



    /**
     * Searches for exact mobile number
     *
     * @param $number
     */
    protected function electorMobile($number)
    {
        $this->electorFieldValue('mobile', $number);
    }



    /**
     * Searches in trashed models only
     *
     * @param $value
     */
    protected function electorBin($value)
    {
        if ($value) {
            $this->elector()->onlyTrashed();
        }
    }



    /**
     * Searches the one with unverified_flag set
     *
     * @param $value
     */
    protected function electorUnverified($value)
    {
        $this->electorFieldBoolean('unverified_flag', $value);
    }



    /**
     * Searches for similar full names
     *
     * @param $value
     */
    protected function electorFullName($value)
    {
        $this->electorFieldLike('full_name', $value);
    }



    /**
     * Intentionally left blank.
     * status is handled in $this->electorRole
     */
    protected function electorStatus($status)
    {
    }



    /**
     * Intentionally left blank.
     * min_status is handled in $this->electorRole
     */
    protected function electorMinStatus()
    {
    }



    /**
     * Intentionally left blank.
     * max_status is handled in $this->electorRole
     */
    protected function electorMaxStatus()
    {
    }



    /**
     * Intentionally left blank.
     * baned request is handled in $this->electorRole
     */
    protected function electorBanned()
    {
    }



    /**
     * Intentionally left blank.
     * permits is handled in $this->electorRole
     */
    protected function electorPermits()
    {
    }



    /**
     * Searches in a given role, including 'all', 'admin' and 'auto' wildcards.
     *
     * @param $given_role
     */
    protected function electorRole($given_role)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if (!$given_role or $given_role == 'all') {
            return;
        }

        /*-----------------------------------------------
        | Wild Cards ...
        */
        if ($given_role == 'admin') {
            $given_role = model('Role')->adminRoles();
        } elseif ($given_role == 'auto') {
            $given_role = user()->userRolesArray();
        } elseif ($given_role == 'no') {
            $this->elector()->has('roles', '=', 0);
        } elseif (!is_array($given_role)) {
            $given_role = (array)$given_role;
        }

        /*-----------------------------------------------
        | Safety ...
        */
        if (!is_array($given_role) or !count($given_role)) {
            return;
        }

        /*-----------------------------------------------
        | Final Process ...
        */
        $this->elector()->whereHas('roles', function ($query) use ($given_role) {
            $query->whereIn('roles.slug', $given_role);
            $query = $this->considerStatusInElectorRole($query);
            $query = $this->considerPermissionsInElectorRole($query);
            $query = $this->considerBannedOrderInElectorRole($query);

            return $query;
        })
        ;
    }



    /**
     * Called from $this->electorRole
     *
     * @param Builder $query
     *
     * @return Builder
     */
    private function considerStatusInElectorRole($query)
    {
        if ($this->issetElector('status') and is_numeric($this->getElector('status'))) {
            $query->where('role_user.status', intval($this->getElector('status')));
        }

        if ($this->issetElector('min_status') and is_numeric($this->getElector('min_status') !== false)) {
            $query->where('role_user.status', '>=', intval($this->getElector('min_status')));
        }

        if ($this->issetElector('max_status') and is_numeric($this->getElector('max_status') !== false)) {
            $query->where('role_user.status', '<=', intval($this->getElector('max_status')));
        }

        return $query;
    }



    /**
     * Called from $this->electorRole
     *
     * @param $query
     *
     * @return Builder
     */
    private function considerPermissionsInElectorRole($query)
    {
        if ($this->getElector('permits') !== false) {
            $given_permits = (array)$this->getElector('permits');

            foreach ($given_permits as $permit) {
                $permit = str_replace(config('yasna.permission_wildcards'), '', $permit);
                $query->where('role_user.permissions', 'like', "%$permit%");
            }
        }

        return $query;
    }



    /**
     * Called from $this->electorRole
     *
     * @param Builder $query
     *
     * @return Builder
     */
    private function considerBannedOrderInElectorRole($query)
    {
        if (!$this->issetElector('banned')) {
            return $query;
        }

        $banned_order = $this->getElector('banned');
        if (!$banned_order) {
            $query->whereNull('role_user.deleted_at');
        } elseif ($banned_order !== 'all') {
            $query->whereNotNull('role_user.deleted_at');
        }

        return $query;
    }



    /**
     * @param $role_string
     */
    protected function electorRoleString($role_string)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($role_string === false or str_contains($role_string, 'all.')) {
            return;
        }

        /*-----------------------------------------------
        | String Process ...
        */

        if (!is_array($role_string)) {
            if (str_before($role_string , '.') == 'admin') {
                $additive    = str_replace('admin', null, $role_string);
                $role_string = user()->userRolesArray('browse', [], model("Role")->adminRoles());
                foreach ($role_string as $key => $value) {
                    $role_string[$key] .= $additive;
                }
            } elseif (str_contains($role_string, 'auto')) {
                $additive    = str_replace('auto', null, $role_string);
                $role_string = user()->userRolesArray();
                foreach ($role_string as $key => $value) {
                    $role_string[$key] .= $value . $additive;
                    ;
                }
            }
        }


        /*-----------------------------------------------
        | Final Process ...
        */
        $role_string_array = (array)$role_string;

        $this->elector()->where(function ($query) use ($role_string_array) {
            $query->where('id', '0');

            foreach ($role_string_array as $role_string) {
                $role_string = str_replace('.all', null, $role_string);
                $role_string = $this->deface($role_string);
                $query->orWhere('cache_roles', 'like', "%$role_string%");
            }

            return $query;
        })
        ;
    }



    /**
     * @return array
     */
    protected function mainSearchableFields()
    {
        return [
             'name_first',
             'name_last',
        ];
    }



    /**
     * @param $value
     */
    protected function electorGender($value)
    {
        $this->electorFieldValue('gender', $value);
    }



    /**
     * @param int $value
     */
    protected function electorAgeMin($value)
    {
        $date = carbon()::today()->subYear($value);
        $this->elector()->whereDate('birth_date', '<', $date);
    }



    /**
     * @param int $value
     */
    protected function electorAgeMax($value)
    {
        $date = carbon()::today()->subYear($value);
        $this->elector()->whereDate('birth_date', '>', $date);
    }
}
