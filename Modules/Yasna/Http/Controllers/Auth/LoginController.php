<?php namespace Modules\Yasna\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController as OriginalLoginController;
use Modules\Yasna\Events\UserLoggedIn;
use Modules\Yasna\Events\UserLoggedOut;
use Illuminate\Http\Request;

class LoginController extends OriginalLoginController
{
    protected $username_field       = false;
    protected $login_blade          = 'yasna::auth.login';
    protected $redirect_after_login = null;



    public function __construct()
    {
        if (!$this->username_field) {
            $this->username_field = usernameField() ;
        }
        $this->middleware('guest', ['except' => ['logout', 'home', 'redirectAfterLogin']]);
    }



    /**
     * @param \Illuminate\Http\Request $request
     */
    public function login(Request $request)
    {
        $done = $this->defaultLogin($request);
        if (user()->id) {
            event(new UserLoggedIn(user()->id));
        }

        return $done;
    }



    public function username()
    {
        return $this->username_field;
    }



    public function home()
    {
        return $this->redirectAfterLogin();
    }



    public function redirectAfterLogin()
    {
        if ($this->redirect_after_login) {
            return redirect($this->redirect_after_login);
        } else {
            return redirect('/manage');
        }
    }



    public function showLoginForm()
    {
        if (!$this->login_blade) {
            return parent::showLoginForm();
        }

        return view($this->login_blade);
    }



    public function logout(Request $request)
    {
        event(new UserLoggedOut());

        $last_user = session()->pull('last_user', 0);
        if ($last_user) {
            session()->invalidate();
            login($last_user);
            return redirect('manage/users/browse/manager');
        }
        return parent::logout($request);
    }



    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, $this->validationRules());
    }



    protected function validationRules()
    {
        return [
             $this->username()      => 'required|string',
             'password'             => 'required|string',
             'g-recaptcha-response' => !env('APP_DEBUG') ? 'required|captcha' : '',
        ];
    }
}
