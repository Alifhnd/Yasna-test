<?php

namespace Modules\Users\Providers;

use App\Models\User;
use Modules\Yasna\Services\YasnaProvider;

class UsersServiceProvider extends YasnaProvider
{

    /**
     * Call Other Methods
     */
    public function index()
    {
        $this->registerServices();
        $this->registerModelTraits();
        $this->registerSidebar();
        $this->registerUserHandlers();
        $this->registerPermitTabs();
        $this->registerUpstream();
        $this->registerAliases();
        $this->registerRoleSampleModules();
        $this->registerDownstream();

        $this->registerProfile();
    }



    /**
     * Register Services
     */
    public function registerServices()
    {
        module('users')
             ->register('browse_top_blade', 'Add any blade to head of users browse page')
             ->register("mass_action_handlers",
                  "Methods, responsible to generate 'Mass Actions' button, above users browse view.")
             ->register("mass_actions",
                  "Array of the 'Mass Actions' button, above users browse view. (On Demand).")
             ->register('row_action_handlers',
                  "Methods, responsible to generate the 'Actions' button, on each row of users browse view.")
             ->register('row_actions',
                  "Array of the 'Actions' button, on each row of users browse view (On Demand).")
             ->register('browse_headings_handlers',
                  "Methods, responsible to generate the users browse columns.")
             ->register('browse_headings',
                  "Array of the blades, responsible to show the content of each browse column (On Demand).")
             ->register('sidebar_subs',
                  "Sub menus of the users sidebar folded menu (On Demand).")
             ->register('permit_tabs',
                  "Tabs of the Permit-Assignment blade, together with their corresponding content.")
             ->register("role_sample_modules",
                  "Module string, to be used as sample for role definitions.")
             ->register("browse_button_handlers",
                  "Methods, responsible to fill the buttons area above the browse view. ")
             ->register("browse_buttons",
                  "Array of the buttons, above the use users browse view (other than the mass action). ")
        ;
    }



    /**
     * Module string, to be used as sample for role definitions.
     */
    public function registerRoleSampleModules()
    {
        module('users')
             ->service('role_sample_modules')
             ->add('users')
             ->value('browse ,  view ,  search ,  create ,  edit ,  delete ,  bin ,  permit')
        ;


        module('users')
             ->service('role_sample_modules')
             ->add('settings')
             ->value('setting')
        ;
    }



    /**
     * Model Traits
     */
    public function registerModelTraits()
    {
        module('yasna')
             ->service('traits')
             ->add()->trait("Users:UserModelTrait")->to("User")
             ->add()->trait("Users:RoleModelTrait")->to("Role")
             ->add()->trait('Users:StateUserTrait')->to('State')
        ;
    }



    /**
     * Manage Sidebars
     */
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
     * Module Aliases
     */
    public function registerAliases()
    {
        $this->addAlias('UsersModule', UsersServiceProvider::class);
        $this->addAlias('DepartmentsTools', DepartmentsServiceProvider::class);
    }



    /**
     * Browses all the user-roles and registers a sub-menu for each.
     * This way, future modules are able to install new items and/or remove/change the others.
     */
    public static function registerSidebar_subs()
    {
    }



    /**
     * User Handlers
     */
    public function registerUserHandlers()
    {
        module('users')
             ->service('mass_action_handlers')
             ->add()
             ->method("users:UsersHandleController@massActions")
        ;

        module('users')
             ->service('browse_headings_handlers')
             ->add()
             ->method("users:UsersHandleController@browseColumns")
        ;

        module('users')
             ->service('row_action_handlers')
             ->add()
             ->method("users:UsersHandleController@rowActions")
        ;

        module('users')
             ->service('browse_button_handlers')
             ->add()
             ->method("users:UsersHandleController@browseButtons")
        ;
    }



    /**
     * Permit Tabs in users::views.actions.permits.blade
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



    /**
     * Upstream Settings
     */
    public function registerUpstream()
    {
        module('manage')
             ->service('upstream_tabs')
             ->add()
             ->link('roles')
             ->trans('manage::settings.roles')
             ->method('users:RolesUpstreamController@index')
             ->order(21)
        ;
    }



    /**
     * register the downstream part.
     *
     * @return void
     */
    protected function registerDownstream()
    {
        module('manage')
             ->service('downstream')
             ->add('departments')
             ->link('departments')
             ->trans('users::department.plural')
             ->method('users:DepartmentsBrowseController@downstream')
             ->condition(function () {
                 return user()->isSuperadmin();
             })
             ->order(31)
        ;
    }



    /**
     * add providers.
     */
    protected function registerProviders()
    {
        $this->addProvider(DepartmentsServiceProvider::class);
    }



    /**
     * Registers things related to the user prfile.
     */
    protected function registerProfile()
    {
        $this->registerProfileServices();
        $this->registerProfileDependencies();
    }



    /**
     * Registers services using by the user profile.
     */
    protected function registerProfileServices()
    {
        module('users')
             ->register("profile_name_parser",
                  "Closure which gets a User and returns the name showing in profile.")
             ->register("profile_identifier_parser",
                  "Closure which gets a User and returns the identifier showing in profile.")
             ->register("profile_avatar_parser",
                  "Closure which gets a User and returns the link of the avatar showing in profile.")
             ->register("profile_rows",
                  "Array of some titles and closures to render row showing in profile.")
             ->register("profile_blades",
                  "Array of blades which will be rendered in the user's profile.")
             ->register("profile_buttons",
                  "Array of buttons which will be shown in the footer of the profile modal.")
        ;
    }



    /**
     * Registers dependencies of the user profile.
     */
    protected function registerProfileDependencies()
    {
        if (!class_exists(MODELS_NAMESPACE . 'User')) {
            return;
        }

        $this->setProfileParsers();
        $this->setProfileRows();
        $this->setProfileButtons();
    }



    /**
     * Sets parsers for the user profile.
     */
    protected function setProfileParsers()
    {
        userProfile()->setNameParser(
             function (User $user) {
                 return $user->full_name;
             }
        );

        userProfile()->setIdentifierParser(
             function (User $user) {
                 return $user->username;
             }
        );

        userProfile()->setAvatarParser(
             function (User $user) {
                 return module('manage')->getAsset('images/user/avatar-default.jpg');
             }
        );
    }



    /**
     * Adds rows to the user profile.
     */
    protected function setProfileRows()
    {
        userProfile()->addRow(
             trans_safe('validation.attributes.name_first'),
             function (User $user) {
                 return $user->name_first;
             },
             'name_first'
        );

        userProfile()->addRow(
             trans_safe('validation.attributes.name_last'),
             function (User $user) {
                 return $user->name_last;
             },
             'name_last'
        );

        userProfile()->addRow(
             trans_safe('validation.attributes.code_melli'),
             function (User $user) {
                 return ad($user->code_melli);
             },
             'code_melli'
        );

        userProfile()->addRow(
             trans_safe('validation.attributes.mobile'),
             function (User $user) {
                 return ad($user->mobile);
             },
             'mobile'
        );

        userProfile()->addRow(
             trans_safe('validation.attributes.email'),
             function (User $user) {
                 return $user->email;
             },
             'email'
        );

        userProfile()->addRow(
             trans_safe('validation.attributes.gender'),
             function (User $user) {
                 $gender = $user->gender;
                 if (!$gender) {
                     return '';
                 }
                 return $this->module()->getTrans("people.gender.$gender");
             },
             'gender'
        );
    }



    /**
     * Sets the profile's buttons.
     */
    protected function setProfileButtons()
    {
        userProfile()->addButton([
             'label'     => "tr:manage::forms.button.edit_info",
             'condition' => function (User $user) {
                 return $user->canEdit();
             },
             'target'    => function (User $user) {
                 return "modal:manage/users/act/{$user->hashid}/edit";
             },
             'shape'     => 'info',
        ], 'edit');
    }
}
