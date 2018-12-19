<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Modules\Manage\Http\Requests\ChangePersonalInfoRequest;
use Modules\Manage\Http\Requests\ChangeSelfPasswordRequest;
use Illuminate\Support\Facades\View;
use Modules\Yasna\Services\YasnaController;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends YasnaController
{
    protected $base_model = "User";
    protected $tabs       = [];
    protected $services;
    protected $request_tab;
    protected $request_tab_label;
    protected $view_file;
    protected $page;
    protected $view_arguments;



    /**
     * @param string $request_tab
     *
     * @return View|Response
     */
    public function index($request_tab = '_default_')
    {
        $this->request_tab = $request_tab;

        $this->loadServices();
        $this->loadTabs();
        $this->loadDefaultTab();
        $this->loadViewName();
        $this->loadRequestTabLabel();
        $this->loadPageInformation();
        $this->buildViewArguments();

        return view($this->view_file, $this->view_arguments);
    }



    /**
     * Loads $this->services by manage service environment
     */
    private function loadServices()
    {
        $this->services = module('manage')->service('account_settings')->read();
    }



    /**
     * Loads $this->tabs by processing the services
     */
    private function loadTabs()
    {
        foreach ($this->services as $service) {
            $this->tabs[] = [
                 $service['link'],
                 $service['caption'],
                 0,
                 user()->stringCheck($service['permit']),
            ];
        }
    }



    /**
     * Loads default tab, according to the first defined service
     */
    private function loadDefaultTab()
    {
        $tab_list = array_pluck($this->services, 'link');

        if ($this->request_tab == '_default_') {
            $this->request_tab = $tab_list[0];
        }
    }



    /**
     * Loads view file name of the requested tab
     */
    private function loadViewName()
    {
        $current_service = $this->services[$this->request_tab];
        if (isset($current_service['blade'])) {
            $this->view_file = $current_service['blade'];
            return;
        }

        $this->view_file = "manage::account.$this->request_tab";
    }



    /**
     * Loads the title of the current tab
     */
    private function loadRequestTabLabel()
    {
        $request_tab = $this->request_tab;

        $this->request_tab_label = array_first(array_where($this->services, function ($value, $key) use ($request_tab) {
            return $value['link'] == $request_tab;
        }))['caption'];
    }



    /**
     * Loads Page Information, used in manage navbar
     */
    private function loadPageInformation()
    {
        $this->page[0] = [
             'account',
             trans_safe("manage::settings.account"),
        ];

        $this->page[1] = [
             $this->request_tab,
             $this->request_tab_label,
        ];
    }



    /**
     * Loads view arguments
     */
    private function buildViewArguments()
    {
        $this->view_arguments = [
             "page" => $this->page,
             "tabs" => $this->tabs,
        ];
    }



    /**
     * @param ChangePersonalInfoRequest $request
     *
     * @return string
     */
    public function savePersonal(ChangePersonalInfoRequest $request)
    {
        $ok = user()->batchSaveBoolean($request);

        return $this->jsonAjaxSaveFeedback($ok, [
             'success_refresh' => true,
        ]);
    }



    /**
     * @param ChangeSelfPasswordRequest $request
     *
     * @return string
     */
    public function savePassword(ChangeSelfPasswordRequest $request)
    {
        $session_key = 'password_attempts';
        $check       = Hash::check($request->current_password, user()->password);


        if (!$check) {
            $session_value = $request->session()->get($session_key, 0);
            $request->session()->put($session_key, $session_value + 1);
            if ($session_value > 3) {
                $request->session()->flush();
                $ok = 0;
            } else {
                return $this->jsonFeedback(trans('manage::forms.feed.wrong_current_password'));
            }
        } else {
            $request->session()->forget($session_key);
            user()->password = bcrypt($request->new_password);
            $ok              = user()->update();
        }

        return $this->jsonAjaxSaveFeedback($ok, [
             'success_redirect' => url('manage'),
             'danger_refresh'   => true,
        ]);
    }



    /**
     * @param $theme_name
     *
     * @return string
     */
    public function saveTheme($theme_name)
    {
        return strval(user()->setPreference('admin_theme', $theme_name));
    }
}
