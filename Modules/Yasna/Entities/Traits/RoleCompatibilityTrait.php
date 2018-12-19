<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait RoleCompatibilityTraits, attached to Role
 * A collection of deprecated methods
 *
 * @property $slug
 */
trait RoleCompatibilityTrait
{
    /**
     * check if the online user can access a specific action.
     *
     * @param string $permit
     * @param string $as
     *
     * @deprecated (97/05/10) because it's not a good idea to check permissions like this.
     * @return bool
     */
    public function can($permit = '*', $as = 'admin')
    {
        return user()->as($as)->can("users-" . $this->slug . '.' . $permit);
    }



    /**
     * check if the online user cannot access a specific action.
     *
     * @param  string $permit
     * @param string  $as
     *
     * @deprecated (97/05/10) because it's not a good idea to check permissions like this.
     * @return bool
     */
    public function cannot($permit, $as = 'admin')
    {
        return !$this->can($permit, $as);
    }



    /**
     * gets the status of the current record.
     *
     * @deprecated (97/05/10)
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->isTrashed()) {
            return 'inactive';
        } else {
            return 'active';
        }
    }



    /**
     * check manage permission.
     *
     * @param string $role_slug
     * @param string $criteria
     *
     * @deprecated (97/05/10)
     * @return bool
     */
    public static function checkManagePermission($role_slug, $criteria)
    {
        if ($role_slug == 'all') {
            $role_slug = 'all'; //@TODO: Check in operation
        } elseif ($role_slug == 'auto') {
            return true;
        } elseif ($role_slug == 'admin') {
            return true; //just like 'auto'
        }


        switch ($criteria) {
            case 'bin':
            case 'banned':
                $permit = 'bin';
                break;

            default:
                $permit = '*';
        }

        return user()->as('admin')->can("users-$role_slug.$permit");
    }



    /**
     * make an accessor to get fields array
     *
     * @deprecated (97/05/10)
     * @return array
     */
    public function getFieldsArrayAttribute()
    {
        $string = str_replace(' ', null, $this->spreadMeta()->fields);
        $result = [];

        $array = explode(',', $string);
        foreach ($array as $item) {
            if (str_contains($item, '*')) {
                $required = true;
                $item     = str_replace('*', null, $item);
            } else {
                $required = false;
            }

            $field = explode(':', $item);
            if (!$field[0]) {
                continue;
            }

            array_push($result, [
                 'name'     => $field[0],
                 'type'     => isset($field[1]) ? $field[1] : 'text',
                 'required' => $required,
            ]);
        }

        return $result;
    }



    /**
     * return a suitable text for any status rule
     *
     * @param      $key
     * @param bool $in_full
     *
     * @deprecated (97/05/10)
     * @return string
     */
    public function statusRule($key, $in_full = false)
    {
        if ($this->slug == 'admin') {
            $record = role()::where('is_admin', 1)->first();
        } else {
            $record = $this;
        }

        if (!$record->has_status_rules) {
            return $key;
        }
        if (is_numeric($key)) {
            $record->spreadMeta();
            if (isset($record->status_rule[$key])) {
                $string = $record->status_rule[$key];
            } else {
                $string = "!";
            }

            if ($in_full) {
                return trans_safe("users::criteria.$string");
            } else {
                return $string;
            }
        } else {
            return $key;
        }
    }
}
