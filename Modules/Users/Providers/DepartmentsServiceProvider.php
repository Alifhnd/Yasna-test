<?php

namespace Modules\Users\Providers;

use App\Models\Role;
use Illuminate\Support\ServiceProvider;

class DepartmentsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    /**
     * return the link to reload a row in the grid view.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function browseRowLink(Role $model)
    {
        return route('users.departments.single-action', [
             'act'      => 'browse-row',
             'model_id' => $model->hashid,
        ]);
    }



    /**
     * return a link to edit the specified role.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function editLink(Role $model)
    {
        return 'modal:' . route('users.departments.single-action', [
                  'act'      => 'edit',
                  'model_id' => $model->hashid,
             ], false);
    }



    /**
     * return the link to delete an item in the grid view.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function deleteLink(Role $model)
    {
        return 'modal:' . route('users.departments.single-action', [
                  'model_id' => $model->hashid,
                  'action'   => 'delete',
                  'option0'  => 'delete',
             ], false);
    }



    /**
     * return the link to undelete an item in the grid view.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function undeleteLink(Role $model)
    {
        return 'modal:' . route('users.departments.single-action', [
                  'model_id' => $model->hashid,
                  'action'   => 'delete',
                  'option0'  => 'undelete',
             ], false);
    }



    /**
     * return the link to manage members in the grid.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function membersLink(Role $model)
    {
        return 'modal:' . route('users.departments.single-action', [
                  'model_id' => $model->hashid,
                  'action'   => 'members',
             ], false);
    }



    /**
     * return a link to create a new department
     *
     * @return string
     */
    public static function createLink()
    {
        return 'modal:' . route('users.departments.single-action', [
                  'act'      => 'create',
                  'model_id' => hashid(0),
             ], false);
    }



    /**
     * return the prefix of supportive roles which can be omitted.
     *
     * @return string
     */
    public static function omissibleSlugPrefix()
    {
        return Role::$support_role_prefix . '-';
    }



    /**
     * return the department slug of a specified slug.
     *
     * @param string $slug
     *
     * @return string
     */
    public static function departmentSlug(?string $slug)
    {
        $prefix = static::omissibleSlugPrefix();
        if (starts_with($slug, $prefix)) {
            return str_after($slug, $prefix);
        }

        return $slug;
    }



    /**
     * return the department slug of a supportive role's slug.
     *
     * @param Role $model
     *
     * @return string
     */
    public static function departmentSlugOfRole(Role $model)
    {
        return static::departmentSlug($model->slug);
    }



    /**
     * return a slug which is ready to be saved in the `roles` table.
     * <br>
     * _Adds the supportive prefix if needed._
     *
     * @param string $slug
     *
     * @return string
     */
    public static function roleSlug(string $slug)
    {
        $prefix = static::omissibleSlugPrefix();

        if (str_contains($slug, $prefix)) {
            return $slug;
        }

        return static::omissibleSlugPrefix() . $slug;
    }
}
