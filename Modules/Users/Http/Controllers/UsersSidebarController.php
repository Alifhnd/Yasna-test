<?php namespace Modules\Users\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Modules\Yasna\Services\YasnaController;

class UsersSidebarController extends YasnaController
{
    /**
     * Handles and Reads the services for users sidebar.
     * Called from users::layouts.sidebar.blade
     *
     * @return array
     */
    public function render()
    {
        $this->handleSidebarSubs();

        return service("users:sidebar_subs")->read();
    }



    /**
     * Handles sidebars
     */
    private function handleSidebarSubs()
    {
        $this->rolesOneByOne();
        $this->allRolesTogether();

        if ($this->shouldCombineAllAdmins()) {
            $this->adminRolesTogether();
        }
    }



    /**
     * Handles all of the roles, one by one
     */
    private function rolesOneByOne()
    {
        foreach ($this->rolesCollection() as $role) {
            if ($role->is_admin and $this->shouldCombineAllAdmins()) {
                continue;
            }

            module('users')
                 ->service('sidebar_subs')
                 ->add($role->slug)
                 ->caption($role->plural_title)
                 ->link("users/browse/$role->slug")
                 ->order(11)
                 ->condition(user()->as('admin')->can("users-$role->slug"))
            ;
        }
    }



    /**
     * Handles all roles, combined together
     */
    private function allRolesTogether()
    {
        module('users')
             ->service('sidebar_subs')
             ->add('all')
             ->icon('address-book')
             ->trans('users::forms.all_users')
             ->link('users/browse/all')
             ->condition(user()->as('admin')->can('users-all'))
        ;
    }



    /**
     * Handles all admin roles, combined together
     */
    private function adminRolesTogether()
    {
        module('users')
             ->service('sidebar_subs')
             ->add('admins')
             ->icon('user-secret')
             ->trans('users::forms.all_admins')
             ->link('users/browse/admin')
             ->condition(user()->as('admin')->can('users-all')) //@TODO: advisable to make a more distinct permission
        ;
    }



    /**
     * @return bool
     */
    private function shouldCombineAllAdmins()
    {
        return getSetting('combine_admin_roles_on_manage_sidebar');
    }



    /**
     * @return Collection
     */
    private function rolesCollection()
    {
        return model('role')->orderBy('is_admin', 'desc')->orderBy('title')->get();
    }
}
