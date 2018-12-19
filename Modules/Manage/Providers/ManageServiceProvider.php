<?php

namespace Modules\Manage\Providers;

use Modules\Depoint\Http\Controllers\DashboardController;
use Modules\Manage\Providers\Traits\ManageAssetTraits;
use Modules\Manage\Services\ManageDashboardWidget;
use Modules\Yasna\Services\YasnaProvider;

class ManageServiceProvider extends YasnaProvider
{
    use ManageAssetTraits;



    /**
     * Provider Index
     */
    public function index()
    {
        $this->registerServices();
        $this->registerAssets();
        $this->registerUpstreamTabs();
        $this->registerSettingsSidebar();
        $this->registerAccountSettings();
        $this->registerDownstream();
        $this->registerSidebar();
        $this->registerModals();
        $this->registerWidgets();
        $this->registerHelpSidebar();
        $this->registerDefaultWidgets();
        $this->registerModelTraits();
        $this->registerPersonalSettings();
        $this->registerProviders();
    }



    /**
     * register personal account settings
     */
    public function registerPersonalSettings()
    {
        module("manage")
             ->service("account_personal_settings")
             ->add("basic_info")
             ->order(11)
             ->blade("manage::account.basic")
        ;

    }



    /**
     * Dashboard Widget Handlers
     */
    public function registerWidgets()
    {
        module('manage')
             ->service('widgets_handler')
             ->add('manage')
             ->method('manage:handleWidgets')
             ->order(11)
        ;
    }



    /**
     * Dashboard Widgets
     */
    public static function handleWidgets()
    {
        $service = 'widgets';

        module('manage')
             ->service($service)
             ->add('manage-hello')
             ->blade('manage::dashboard.hello')
             ->trans('manage::dashboard.hello.title')
             ->color('primary')
             ->icon('user')
             ->order(11)
        ;

        module('manage')
             ->service($service)
             ->add('manage-today')
             ->blade('manage::dashboard.today')
             ->trans('manage::dashboard.today.title')
             ->color('info')
             ->icon('calendar')
             ->order(12)
        ;

        module('manage')
             ->service($service)
             ->add('manage-welcome')
             ->blade('manage::dashboard.welcome')
             ->trans('manage::dashboard.welcome.title')
             ->color('purple')
             ->icon('dashboard')
             ->order(13)
             ->condition(
                  function () {
                      return dev();
                  }
             )
        ;

        module('manage')
             ->service($service)
             ->add('manage-upstream')
             ->blade('manage::dashboard.upstream')
             ->trans('manage::settings.upstream')
             ->color('inverse')
             ->icon('bug')
             ->order(14)
             ->condition(
                  function () {
                      return dev();
                  }
             )
        ;

        module('manage')
             ->service($service)
             ->add('manage-downstream')
             ->blade('manage::dashboard.downstream')
             ->trans('manage::settings.site')
             ->color('purple')
             ->icon('cog')
             ->order(15)
             ->condition(
                  function () {
                      return user()->isSuper();
                  }
             )
        ;

        module('manage')
             ->service($service)
             ->add('manage-weather')
             ->blade('manage::dashboard.weather.weather')
             ->trans('manage::dashboard.weather.title')
             ->color('info')
             ->icon('sun')
             ->order(16)
        ;
    }



    /**
     * Module Aliases
     */
    public function registerAliases()
    {
        $this->addAlias('ManageModule', ManageServiceProvider::class);
    }



    /**
     * Manage Services
     */
    public function registerServices()
    {
        module("manage")
             ->register("account_settings", "Responsible to make accounts-settings tabs")
             ->register("account_personal_settings", "Responsible to house account settings, personal tab")
             ->register('user_info_sidebar', "Responsible to add layout to user-info section in sidebar")
             ->register("template_assets", "Assets to be loaded globally in Manage-Side")
             ->register("template_bottom_assets", "Assets to be loaded globally in Manage-Side, Bottom Area!")
             ->register("help_sidebar", "Responsible to make a help sidebar menu")
             ->register("settings_sidebar", "Responsible to make settings sidebar")
             ->register('sidebar', "Responsible to make sidebar menu")
             ->register('downstream', "Responsible to make tabs for downstream settings")
             ->register('upstream_tabs', "Responsible to make tabs for upstream (developers) settings")
             ->register('file_manager', "All file manager handler blades are to be added here.")
             ->register('modals', 'Modals, and other hidden areas may be required in the template.')
             ->register('nav_create', "Items to be appeared in the manage nav-bar create button.")
             ->register('nav_create_handler', "Methods, to handle the above item.")
             ->register('nav_notification_handler',
                  "Methods, responsible to handle nav-bar notification button, on demand")
             ->register('nav_notification', "Methods, to handle the above item.")
             ->register('widgets', "Blades, to handle all homepage widgets.")
             ->register('widgets_handler', "Methods, to handle dashboard widgets.")
             ->register("default_widgets", "Desktop widgets to be used when user setting is not set")
             ->register("notification_groups", "Groups of notifications to be used in the notifications' preview.")
        ;
    }



    /**
     * Manage Sidebar
     */
    public function registerSidebar()
    {
        service('manage:sidebar')
             ->add('help')
             ->blade('manage::sidebar.help')
             ->order(99)
        ;

        service('manage:sidebar')
             ->add('support')
             ->blade('manage::sidebar.support')
             ->order(99)
        ;
    }



    /**
     * Help Sidebar
     */
    public function registerHelpSidebar()
    {
        service('manage:help_sidebar')
             ->add('graph-demo')
             ->link('graphs-demo')
             ->caption('trans:manage::template.graphs')
             ->permit('is:developer')
             ->order(98)
        ;


        service('manage:help_sidebar')
             ->add('elements-demo')
             ->link('elements-demo')
             ->caption('trans:manage::template.elements')
             ->permit('is:developer')
             ->order(99)
        ;
    }



    /**
     * Upstream Tabs
     */
    public function registerUpstreamTabs()
    {
        module('manage')
             ->service('upstream_tabs')
             ->add('upstream-settings')
             ->link('settings')
             ->caption('trans:manage::settings.general')
             ->method('manage:UpstreamSettingsController@index')
             ->order(11)
        ;

        module('manage')
             ->service('upstream_tabs')
             ->add('upstream-states')
             ->link('states')
             ->caption('trans:manage::settings.states')
             ->method('manage:UpstreamController@stateIndex')
             ->order(31)
        ;
        module('manage')
             ->service('upstream_tabs')
             ->add('upstream-domains')
             ->link('domains')
             ->caption('trans:manage::settings.domains')
             ->method('manage:UpstreamController@domainIndex')
             ->order(41)
        ;
    }



    /**
     * Settings Sidebar
     */
    public function registerSettingsSidebar()
    {
        module('manage')
             ->service('settings_sidebar')
             ->add('account')
             ->link('account')
             ->caption("trans:manage::settings.account")
             ->icon('user')
             ->order(1)
        ;
        module('manage')
             ->service('settings_sidebar')
             ->add('site')
             ->link('downstream')
             ->caption("trans:manage::settings.site")
             ->icon('sliders')
             ->order(18)
             ->permit(function () {
                 return user()->isSuperadmin();
             })
        ;
        module('manage')
             ->service('settings_sidebar')
             ->add('upstream')
             ->link('upstream')
             ->caption("trans:manage::settings.upstream")
             ->icon('github-alt')
             ->order(99)
             ->permit('is:developer')
        ;

        module('manage')
             ->service('settings_sidebar')
             ->add('statue')
             ->link('statue')
             ->trans('manage::statue.title')
             ->icon('flask')
             ->order(100)
        ;

        module('manage')
             ->service('user_info_sidebar')
             ->add('user_info_picture')
             ->blade('manage::layouts.sidebar.user-info-avatar')
             ->order(1)
        ;

        module('manage')
             ->service('user_info_sidebar')
             ->add('user_info')
             ->blade('manage::layouts.sidebar.user-info-block')
             ->order(10)
        ;
    }



    /**
     * Account Settings
     */
    public function registerAccountSettings()
    {
        module('manage')
             ->service('account_settings')
             ->add('password')
             ->link('password')
             ->caption("trans:manage::settings.change_password")
             ->order(12)
        ;
        module('manage')
             ->service('account_settings')
             ->add('personal')
             ->link('personal')
             ->caption("trans:manage::settings.personal")
             ->order(11)
        ;
    }



    /**
     * Downstream Tabs
     */
    public function registerDownstream()
    {
        module('manage')
             ->service('downstream')
             ->add('downstream')
             ->link('settings')
             ->caption('trans:manage::settings.general')
             ->method("manage:SettingsDownstreamController@index")
             ->condition(function () {
                 return user()->as('admin')->can('settings.settings');
             })
             ->order(1)
        ;
    }



    /**
     * Modal Windows
     */
    public function registerModals()
    {
        module('manage')
             ->service('modals')
             ->add('manage-modals')
             ->blade("Manage::modals")
             ->order(0)
        ;
    }



    /**
     * Default Widgets to be used if user setting cannot be found
     */
    public function registerDefaultWidgets()
    {
        ManageDashboardWidget::addDefault('manage-welcome', 3, 0, 0);
        ManageDashboardWidget::addDefault('manage-hello', 3, 3, 0);
        ManageDashboardWidget::addDefault('manage-today', 3, 0, 24);

    }



    /**
     * Register model traits
     *
     * @return void
     */
    protected function registerModelTraits()
    {
        $this->addModelTrait("SettingManageTrait", "Setting");
        $this->addModelTrait("ManageUserTrait", "User");
    }



    /**
     * Registers the providers.
     */
    protected function registerProviders()
    {
        $this->addProvider(NotificationServiceProvider::class);
    }
}
