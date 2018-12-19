<?php namespace Modules\Users\Http\Controllers;

use Modules\Yasna\Services\YasnaController;

class UsersHandleController extends YasnaController
{
    /**
     * Responsible for massActionButtons
     *
     * @param $arguments : same arguments passed to the blade, in UsersBrowseController
     */
    public static function massActions($arguments)
    {
    }



    /**
     * Responsible for browse columns (headings)
     *
     * @param $arguments : same arguments passed to the blade, in UsersBrowseController
     */

    public static function browseColumns($arguments)
    {
        $request_role = $arguments['request_role'];

        /*-----------------------------------------------
        | Name and Username ...
        */
        module('users')
             ->service('browse_headings')
             ->add('name')
             ->trans("validation.attributes.name_first")
             ->blade("users::browse.row-name")
             ->order(2)
        ;


        /*-----------------------------------------------
        | User Roles ...
        */
        module('users')
             ->service('browse_headings')
             ->add('roles')
             ->trans("users::permits.user_role")
             ->blade("users::browse.row-roles")
             ->condition(static::isACombinedRole($request_role))
             ->order(31)
        ;

        /*-----------------------------------------------
        | Status ...
        */
        module('users')
             ->service('browse_headings')
             ->add('status')
             ->trans("validation.attributes.status")
             ->blade("users::browse.row-status")
             ->condition(static::isNotACombinedRole($request_role))
             ->order(31)
        ;
    }



    /**
     * Responsible for row actions
     *
     * @param $arguments : same arguments passed to the blade, in UsersBrowseController
     */
    public static function rowActions($arguments)
    {
        $model        = $arguments['model'];
        $request_role = $arguments['request_role'];
        $service      = 'users:row_actions';

        /*-----------------------------------------------
        | Editor ...
        */
        service($service)
             ->add('edit')
             ->icon('pencil')
             ->trans("manage::forms.button.edit_info")
             ->link("modal:manage/users/act/-hashid-/edit")
             ->condition($model->canEdit())
             ->order(11)
        ;


        /*-----------------------------------------------
        | Change Password ...
        */
        service($service)
             ->add('password')
             ->icon('key')
             ->trans("users::forms.change_password")
             ->link("modal:manage/users/act/-hashid-/password")
             ->condition($model->canEdit())
             ->order(21)
        ;

        /*-----------------------------------------------
        | Role Management  ...
        */
        service($service)
             ->add('roles')
             ->icon('user-circle')
             ->trans("users::permits.user_role")
             ->link("modal:manage/users/act/-hashid-/roles")
             ->condition($model->canPermit())
             ->order(31)
        ;

        /*-----------------------------------------------
        | Permits ...
        */
        if (static::isNotACombinedRole($request_role)) {
            service($service)
                 ->add('permits')
                 ->icon('shield')
                 ->trans("users::permits.permit")
                 ->link("modal:manage/users/act/-hashid-/permits/$request_role")
                 ->condition($model->as($request_role)->canPermit())
                 ->order(31)
            ;
        }

        /*-----------------------------------------------
        | Block / Unblock ...
        */
        if ($request_role != 'all') {
            $enabled = $model->as($request_role)->enabled();
            $action  = $enabled ? 'block' : 'unblock';

            service($service)
                 ->add('block')
                 ->icon($enabled ? 'ban' : 'unlock')
                 ->trans($enabled ? "users::forms.block" : "users::forms.unblock")
                 ->link("modal:manage/users/act/-hashid-/block/$request_role/$action")
                 ->condition($enabled ? $model->canDelete() : $model->canBin())
                 ->order(99)
            ;
        }

        /*-----------------------------------------------
        | Delete / Undelete ...
        */
        if ($request_role == 'all') {
            $enabled = !$model->trashed();
            $action  = $enabled ? 'delete' : 'undelete';

            service($service)
                 ->add('delete')
                 ->icon($enabled ? 'trash' : 'undo')
                 ->trans($enabled ? "manage::forms.button.soft_delete" : "manage::forms.button.undelete")
                 ->link("modal:manage/users/act/-hashid-/delete/$action")
                 ->condition($enabled ? $model->canDelete() : $model->canBin())
                 ->order(99)
            ;
        }


        /*
        |--------------------------------------------------------------------------
        | Login As
        |--------------------------------------------------------------------------
        |
        */
        if (dev()) {
            service($service)
                 ->add('login_as')
                 ->icon('bug')
                 ->trans("users::forms.login_as")
                 ->link("modal:manage/users/act/-hashid-/login")
                 ->condition(!$model->isDeveloper() and $model->id != user()->id)
            ;
        }
    }



    /**
     * Responsible for the buttons above the browse grid
     *
     * @param $arguments : same arguments passed to the blade, in UsersBrowseController
     */
    public static function browseButtons($arguments)
    {
        $service = "users:browse_buttons";
        $role    = $arguments['role'];

        service($service)
             ->add('create')
             ->icon('plus-circle')
             ->caption($role->slug == 'all' ? trans("users::forms.create_new_person") : trans('manage::forms.button.add_to') . SPACE . $role->plural_title)
             ->link("modal:manage/users/create/$role->slug")
             ->set('type', 'success')
             ->condition(user()->as('admin')->can("users-$role->slug.create"))
        ;
    }



    /**
     * @return array
     */
    public static function combinedRoles()
    {
        return [
             'admin',
             'all',
        ];
    }



    /**
     * @param $role
     *
     * @return bool
     */
    public static function isACombinedRole($role)
    {
        return in_array($role, static::combinedRoles());
    }



    /**
     * @param $role
     *
     * @return bool
     */
    public static function isNotACombinedRole($role)
    {
        return !static::isACombinedRole($role);
    }
}
