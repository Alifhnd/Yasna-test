<?php namespace Modules\Yasna\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController as OriginalRegisterController;

class RegisterController extends OriginalRegisterController
{
    protected $register_blade = false;

    public function showRegistrationForm()
    {
        if (!$this->register_blade) {
            return parent::showRegistrationForm();
        }

        return view($this->register_blade);
    }
}
