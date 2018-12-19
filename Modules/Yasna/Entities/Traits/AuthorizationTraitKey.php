<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait PermitsTrait2Key
 *
 * @property int $id
 * @package Modules\Yasna\Entities\Traits
 */
trait AuthorizationTraitKey
{


    /**
     * Checks if the hash key of a given role_row is matched with its content.
     *
     * @param array $role_row
     *
     * @return bool
     */
    protected function checkKey(array $role_row)
    {
        $lock_string = $this->keyFactory(
             $role_row['id'],
             $role_row['pivot']['permissions'],
             $role_row['pivot']['status'],
             $role_row['pivot']['deleted_at']
        );

        return boolval($lock_string == $role_row['pivot']['key']);
    }



    /**
     * Generates and md5 hash key of all the vital authorization-concerned properties.
     *
     * @param array $array
     *
     * @return string
     */
    protected function makeKey(array $array)
    {
        $array = array_normalize($array, [
             "id"         => 0,
             "permits"    => "",
             "status"     => 1,
             "deleted_at" => null,
        ]);

        return $this->keyFactory($array['id'], $array['permits'], $array['status'], $array['deleted_at']);
    }



    /**
     * Generates and md5 hash key of all the vital authorization-concerned properties.
     *
     * @deprecated
     *
     * @param int         $role_id
     * @param string      $permissions
     * @param int         $status
     * @param string|null $deleted_at
     *
     * @return string
     */
    protected function makeKeyByParams(int $role_id, string $permissions, int $status, $deleted_at)
    {
        return $this->keyFactory($role_id, $permissions, $status, $deleted_at);
    }



    /**
     * @param int         $role_id
     * @param string      $permissions
     * @param int         $status
     * @param string|null $deleted_at
     *
     * @return string
     */
    private function keyFactory(int $role_id, string $permissions, int $status, $deleted_at)
    {
        if (!$this->id or !$role_id) {
            return md5(false);
        }

        $lock_array = [
             "user_id"     => $this->id,
             "role_id"     => $role_id,
             "permissions" => $permissions,
             "status"      => $status,
             "deleted_at"  => $deleted_at,
        ];

        return md5(json_encode($lock_array));
    }
}
