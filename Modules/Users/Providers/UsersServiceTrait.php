<?php
namespace Modules\Users\Providers;

use Modules\Yasna\Entities\Role;

trait UsersServiceTrait
{
    public function customBoot()
    {
        $this->registerServices();
        $this->registerModelTraits();
        $this->registerSidebar();
        $this->registerModelSelectors();
        $this->registerUserHandlers();
        $this->registerPermitTabs();
        $this->registerUpstream();
    }

    public function registerServices()
    {
        module('users')
            ->register("mass_action_handlers", "Methods, responsible to generate 'Mass Actions' button, above users browse view.")
            ->register("mass_actions", "Array of the 'Mass Actions' button, above users browse view. (On Demand).")
            ->register('row_action_handlers', "Methods, responsible to generate the 'Actions' button, on each row of users browse view.")
            ->register('row_actions', "Array of the 'Actions' button, on each row of users browse view (On Demand).")
            ->register('model_selector', "Responsible methods to be loaded in the 'selector' method of 'Post' model. ")
            ->register('browse_headings_handlers', "Methods, responsible to generate the users browse columns.")
            ->register('browse_headings', "Array of the blades, responsible to show the content of each browse column (On Demand).")
            ->register('sidebar_subs', "Sub menus of the users sidebar folded menu (On Demand).")
            ->register('permit_tabs', "Tabs of the Permit-Assignment blade, together with their corresponding content.")
            ->register("browse_button_handlers", "Methods, responsible to fill the buttons area above the browse view. ")
            ->register("browse_buttons", "Array of the buttons, above the use users browse view (other than the mass action). ")
        ;
    }

    public function registerModelTraits()
    {
        module('yasna')
            ->service('traits')
            ->add()->trait("Users:UserModelTrait")->to("User")
            ->add()->trait("Users:RoleModelTrait")->to("Role")
        ;
    }

    public function registerSidebar()
    {
        module('manage')
            ->service('sidebar')
            ->add('users')
            ->blade('users::layouts.sidebar')
            ->order(43)
        ;
    }

    /**
     * Browses all the user-roles and registers a sub-menu for each.
     * This way, future modules are able to install new items and/or remove/change the others.
     */
    public static function registerSidebar_subs()
    {
        /*-----------------------------------------------
        | Browse ...
        */
        foreach (Role::orderBy('title')->get() as $role) {
            module('users')
                ->service('sidebar_subs')
                ->add($role->slug)
                ->icon($role->spreadMeta()->icon)
                ->caption($role->plural_title)
                ->link("users/browse/$role->slug")
                ->order(11)
                ->condition(user()->as('admin')->can("users-$role->slug"))
            ;
        }

        /*-----------------------------------------------
        | All-Users ...
        */
        module('users')
            ->service('sidebar_subs')
            ->add('all')
            ->icon('address-book')
            ->trans('users::forms.all_users')
            ->link('users/browse/all')
            ->condition(user()->as('admin')->can('users-all'))
        ;
    }

    public function registerModelSelectors()
    {
        module('users')
            ->service('model_selector')
            ->add('status')->method('selector_status')->order(1)
            ->add('id')->method('selector_simples')->order(2)
            ->add('email')
            ->add('code_melli')
            ->add('mobile')
            ->add('bin')
            ->add('roleString')->method('selector_roleString')->order(3)
            ->add('role')->method('selector_role')->order(4)
            ->add('min_status')
            ->add('max_status')
            ->add('permits')
            ->add('banned')
            ->add('search')->method('selector_search')->order(99)
        ;
    }

    /*
    |--------------------------------------------------------------------------
    | Handlers
    |--------------------------------------------------------------------------
    |
    */


    public function registerUserHandlers()
    {
        module('users')
            ->service('mass_action_handlers')
            ->add()
            ->method("users:handleMassActions")
        ;

        module('users')
            ->service('browse_headings_handlers')
            ->add()
            ->method("users:handleBrowseColumns")
        ;

        module('users')
            ->service('row_action_handlers')
            ->add()
            ->method("users:handleRowActions")
        ;

        module('users')
            ->service('browse_button_handlers')
            ->add()
            ->method("users:handleBrowseButtons")
        ;
    }

    /*
    |--------------------------------------------------------------------------
    | Browse Columns
    |--------------------------------------------------------------------------
    |
    */
    public static function handleBrowseColumns($arguments)
    {
        $request_role = $arguments['request_role'];

        /*-----------------------------------------------
        | Name and Username ...
        */
        module('users')
            ->service('browse_headings')
            ->add('name')
            ->trans("validation.attributes.name_first")
            ->blade("users::browse-name")
            ->order(1)
        ;


        /*-----------------------------------------------
        | User Roles ...
        */
        module('users')
            ->service('browse_headings')
            ->add('roles')
            ->trans("users::permits.user_role")
            ->blade("users::browse-roles")
            ->condition($request_role == 'all')
            ->order(31)
        ;

        /*-----------------------------------------------
        | Status ...
        */
        module('users')
            ->service('browse_headings')
            ->add('status')
            ->trans("validation.attributes.status")
            ->blade("users::browse-status")
            ->condition($request_role != 'all')
            ->order(31)
        ;
    }

    public static function renderBrowseColumns($arguments)
    {
        if (isset($arguments['ajax']) and $arguments['ajax']) {
            module('users')
                ->service('browse_headings_handlers')
                ->handle($arguments)
            ;
        }

        return service('users:browse_headings')->read();
    }

    /*
    |--------------------------------------------------------------------------
    | Row Actions
    |--------------------------------------------------------------------------
    |
    */


    public static function handleRowActions($arguments)
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
        if ($request_role != 'all') {
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
    }

    public static function renderRowActions($model, $request_role)
    {
        /*-----------------------------------------------
        | Service Buildup on demand ...
        */
        module('users')
            ->service('row_action_handlers')
            ->handle(compact('model', 'request_role'))
        ;

        /*-----------------------------------------------
        | Return ...
        */

        return module('users')
            ->service('row_actions')
            ->indexed('icon', 'caption', 'link', 'condition')
            ;
    }

    /*
    |--------------------------------------------------------------------------
    | Create Button
    |--------------------------------------------------------------------------
    |
    */


    public static function handleBrowseButtons($arguments)
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

    public static function renderBrowseButtons($role)
    {
        /*-----------------------------------------------
        | Service Buildup on demand ...
        */
        module('users')
            ->service('browse_button_handlers')
            ->handle(compact('role'))
        ;

        /*-----------------------------------------------
        | Return ...
        */
        return module('users')
            ->service('browse_buttons')
            ->read()
        ;
    }

    /*
    |--------------------------------------------------------------------------
    | Mass Actions
    |--------------------------------------------------------------------------
    |
    */
    public static function handleMassActions($arguments)
    {
    }


    /*
    |--------------------------------------------------------------------------
    | Permits
    |--------------------------------------------------------------------------
    |
    */
    public function registerPermitTabs()
    {
        $service     = "users:permit_tabs";
        $view_folder = "users::permits";

        service($service)
            ->add('hello')
            ->icon("user")
            ->blade("$view_folder.hello")
            ->order(1)
        ;

        service($service)
            ->add('users')
            ->trans("users::forms.users")
            ->blade("$view_folder.users")
            ->order(11)
        ;

        service($service)
            ->add("others")
            ->trans("users::permits.other_modules")
            ->blade("$view_folder.others")
            ->order(99)
        ;
    }


    /*
    |--------------------------------------------------------------------------
    | Upstream Settings
    |--------------------------------------------------------------------------
    |
    */
    public function registerUpstream()
    {
        module('manage')
            ->service('upstream_tabs')
            ->add()
            ->link('roles')
            ->trans('manage::settings.roles')
            ->method('users:UpstreamController@roleIndex')
            ->order(21)
        ;
    }
}
