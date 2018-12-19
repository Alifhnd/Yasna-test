<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitUsers
{
    /**
     * Gets an array of roles the user has access to.
     *
     * @param string $permit
     * @param array  $exceptions
     * @param array  $only_these
     *
     * @return array
     */
    public function userRolesArray($permit = 'browse', array $exceptions = [], array $only_these = [])
    {
        $roles = role()->all();
        $array = [];

        foreach ($roles as $role) {
            $slug = $role->slug;
            if ($this->as('admin')->can("users-$slug.$permit")) {
                if ($this->as('admin')->can("users-$slug.$permit")) {
                    if (!in_array($slug, $exceptions)) {
                        if (!count($only_these) or in_array($slug, $only_these)) {
                            $array[] = $slug;
                        }
                    }
                }
            }
        }

        return $array;
    }



    /**
     * Checks the privileges with single-string, useful when checking Auth in app boot sequence.
     * Patterns: is:role_slug / can:permit@role_slug
     * The above patterns, can be combined with &. ex: "is:admin & can:create@manager"
     *
     * @deprecated
     *
     * @param string $string
     *
     * @return bool
     */
    public function stringCheck($string)
    {
        $array     = explode('&', $string);
        $condition = true;

        foreach ($array as $item) {
            if (str_contains($item, 'is:')) {
                $item      = str_after($item, 'is:');
                $condition = boolval($condition and $this->hasRole($item));
            } elseif (str_contains($item, 'as:')) {
            } elseif (str_contains($item, 'can:')) {
                $item      = trim(str_replace('can:', null, $item));
                $items     = explode('@', $item);
                $permit    = trim($items[0]);
                $as        = isset($items[1]) ? trim($items[1]) : "admin";
                $condition = boolval($condition and $this->as($as)->can($permit));
            }
        }

        return $condition;
    }



    /**
     * @deprecated
     *
     * @param string $text
     *
     * @return string
     */
    public static function deface($text)
    {
        return role()->defaceString($text);
    }



    /**
     * @deprecated
     *
     * @param string $text
     *
     * @return string
     */
    public static function adorn($text)
    {
        return role()->adornString($text);
    }
}
