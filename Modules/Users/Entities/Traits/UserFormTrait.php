<?php namespace Modules\Users\Entities\Traits;

use Modules\Yasna\Services\ModelTraits\YasnaFormTrait;

/**
 * Class User
 * @method string usernameField()
 */
trait UserFormTrait
{
    use YasnaFormTrait;



    /**
     * define main form items
     */
    public function mainFormItems()
    {
        $this->addFormItem('name_first')
             //             ->whichIsRequired()
             ->withClass('form-default')
        ;

        $this->addFormItem('name_last')
             ->whichIsRequired()
        ;

        if ($this->usernameField() != 'mobile') {
            $this->addFormItem('mobile')
                 ->withClass('ltr')
                 ->withValidationRule('phone:mobile')
                 ->withPurificationRule('ed')
            ;
        }
    }



    /**
     * define username form items
     */
    protected function usernameFormItems()
    {
        $username_field = $this->usernameField();

        if ($username_field == "email") {
            $validation_rule = "email";
        } elseif ($username_field = "code_melli") {
            $validation_rule = "code_melli";
        } else {
            $validation_rule = null;
        }

        $this->addFormItem($username_field)
             ->withClass("ltr")
             ->withValidationRule($validation_rule)
             ->whichIsRequired()
             ->placedAfter("name_last")
        ;
    }
}
