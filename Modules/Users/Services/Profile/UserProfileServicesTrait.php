<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/17/18
 * Time: 1:07 PM
 */

namespace Modules\Users\Services\Profile;

use Closure;
use Modules\Manage\Services\Widgets\Button;

trait UserProfileServicesTrait
{
    /**
     * Returns the name string which will be shown in the user's profile.
     * <br>
     * _By default, the name string is the full name of the user._
     *
     * @return string
     */
    public function getNameString()
    {
        $parser = $this->getNameParser();
        return $parser($this->user);
    }



    /**
     * Sets the parser which will be used to generate the name string.
     *
     * @param Closure $parser
     */
    public function setNameParser(Closure $parser)
    {
        module($this->runningModule()->getAlias())
             ->service('profile_name_parser')
             ->add('main_parser')
             ->value([
                  'parser' => $parser,
             ])
        ;
    }



    /**
     * Returns the parser to be used to generate the name string.
     *
     * @return Closure
     */
    public function getNameParser()
    {
        $registered = $this->safeReadServices('profile_name_parser');

        return $registered['main_parser']['value']['parser'];
    }



    /**
     * Returns the identifier which will be shown in the user's profile.
     * <br>
     * _By default, the identifier is the username of the user._
     *
     * @return string
     */
    public function getIdentifier()
    {
        $parser = $this->getIdentifierParser();
        return $parser($this->user);
    }



    /**
     * Sets the parser to be used to generate the identifier which will be shown in the user's profile.
     *
     * @param Closure $parser
     */
    public function setIdentifierParser(Closure $parser)
    {
        module($this->runningModule()->getAlias())
             ->service('profile_identifier_parser')
             ->add('main_parser')
             ->value([
                  'parser' => $parser,
             ])
        ;
    }



    /**
     * Returns the parser to be used to generate the identifier.
     *
     * @return Closure
     */
    public function getIdentifierParser()
    {
        $registered = $this->safeReadServices('profile_identifier_parser');

        return $registered['main_parser']['value']['parser'];
    }



    /**
     * Returns the URL of the avatar which will be shown in the user's profile.
     * <br>
     * _By default, the avatar is a temporary user image._
     *
     * @return string
     */
    public function getAvatar()
    {
        $parser = $this->getAvatarParser();
        return $parser($this->user);
    }



    /**
     * Sets the parser to be used to generate the URL of the avatar which will be shown in the user's profile.
     *
     * @param Closure $parser
     */
    public function setAvatarParser(Closure $parser)
    {
        module($this->runningModule()->getAlias())
             ->service('profile_avatar_parser')
             ->add('main_parser')
             ->value([
                  'parser' => $parser,
             ])
        ;
    }



    /**
     * Returns the parser to be used to generate the URL of the user's avatar.
     *
     * @return Closure
     */
    public function getAvatarParser()
    {
        $registered = $this->safeReadServices('profile_avatar_parser');

        return $registered['main_parser']['value']['parser'];
    }



    /**
     * Adds a row to the user's profile.
     *
     * @param string  $title  The title of the row.
     * @param Closure $parser The closure which will generate the value of the row.
     * @param string  $name   The name of the service
     */
    public function addRow(string $title, Closure $parser, string $name)
    {
        module($this->runningModule()->getAlias())
             ->service('profile_rows')
             ->add($name)
             ->value([
                  'title'  => $title,
                  'parser' => $parser,
             ])
        ;
    }



    /**
     * Returns an array of the registered rows to be shown in the user's profile.
     *
     * @return array
     */
    public function getRows()
    {
        $registered = $this->safeReadServices('profile_rows');

        return array_map(function ($service) {
            $parser = $service['value']['parser'];
            return [
                 'title' => $service['value']['title'],
                 'value' => $parser($this->user),
            ];
        }, $registered);
    }



    /**
     * Adds a row to the user's profile.
     * <br>
     * _The blades will be included with a $model parameter which is the target user._
     *
     * @param string $blade The path of the blade to be included in the user's profile.
     */
    public function addBlade(string $blade)
    {
        $name = snake_case(preg_replace("/[^A-Za-z0-9 ]/", ' ', $blade));

        module($this->runningModule()->getAlias())
             ->service('profile_blades')
             ->add($name)
             ->value($blade)
        ;
    }



    /**
     * Returns an array of registered extra blades to be shown in the user profile.
     *
     * @return array
     */
    public function getBlades()
    {
        $registered = $this->safeReadServices('profile_blades');

        return array_map(function ($service) {
            return $service['value'];
        }, $registered);
    }



    /**
     * Adds a button to the footer of user's profile.
     *
     * @param array  $info An array of information to be used while creating the button.
     * @param string $name The Name of the Service
     */
    public function addButton(array $info, string $name)
    {
        module($this->runningModule()->getAlias())
             ->service('profile_buttons')
             ->add($name)
             ->value($info)
        ;
    }



    /**
     * Returns an array of registered buttons to be shown in the user profile's footer.
     *
     * @return array
     */
    public function getButtons()
    {
        $registered = $this->safeReadServices('profile_buttons');

        return array_map(function ($service) {
            return $this->generateButtonWidget($service);
        }, $registered);
    }



    /**
     * Returns an instance of the `Modules\Manage\Services\Widgets\Button` class
     * which has been made based on the given information
     *
     * @param array $button_info
     *
     * @return Button
     */
    protected function generateButtonWidget(array $button_info)
    {
        $button = widget('button');

        $button = $this->handleButtonLabel($button, $button_info);
        $button = $this->handleButtonCondition($button, $button_info);
        $button = $this->handleButtonTarget($button, $button_info);
        $button = $this->handleButtonOnClick($button, $button_info);
        $button = $this->handleButtonShape($button, $button_info);

        return $button;
    }



    /**
     * Handles the label of the button based on the specified info.
     *
     * @param Button $button
     * @param array  $button_info
     *
     * @return Button
     */
    protected function handleButtonLabel(Button $button, array $button_info)
    {
        $label = ($button_info['value']['label'] ?? $button_info['key']);

        $button->label($this->findValueWithType($label));

        return $button;
    }



    /**
     * Handles the condition of the button based on the specified info.
     *
     * @param Button $button
     * @param array  $button_info
     *
     * @return Button
     */
    protected function handleButtonCondition(Button $button, array $button_info)
    {
        $label = ($button_info['value']['condition'] ?? true);

        $button->condition($this->findValueWithType($label));

        return $button;
    }



    /**
     * Handles the target of the button based on the specified info.
     *
     * @param Button $button
     * @param array  $button_info
     *
     * @return Button
     */
    protected function handleButtonTarget(Button $button, array $button_info)
    {
        $target = ($button_info['value']['target'] ?? null);

        if ($target) {
            $button->target($this->findValueWithType($target));
        }

        return $button;
    }



    /**
     * Handles the onClick property of the button based on the specified info.
     *
     * @param Button $button
     * @param array  $button_info
     *
     * @return Button
     */
    protected function handleButtonOnClick(Button $button, array $button_info)
    {
        $on_click = ($button_info['value']['on_click'] ?? null);

        if ($on_click) {
            $button->onClick($this->findValueWithType($on_click));
        }

        return $button;
    }



    /**
     * Handles the shape of the button based on the specified info.
     *
     * @param Button $button
     * @param array  $button_info
     *
     * @return Button
     */
    protected function handleButtonShape(Button $button, array $button_info)
    {
        $shape = ($button_info['value']['shape'] ?? null);

        if ($shape) {
            $button->shape($this->findValueWithType($shape));
        }

        return $button;
    }



    /**
     * Finds the real value of the given value based on its type.
     * <br>
     * _If the value is a closure, it will be ran with the user as its argument, and the result will be returned_
     *
     * @param $value
     *
     * @return mixed
     */
    protected function findValueWithType($value)
    {
        if (is_closure($value)) {
            return $value($this->user);
        }

        return $value;
    }



    /**
     * Reads the specified service in a safe mode to prevent exceptions on Closure values.
     *
     * @param string $service_name
     *
     * @return array
     */
    protected function safeReadServices(string $service_name)
    {
        return module($this->runningModule()->getAlias())
             ->service($service_name)
             ->read()
             ;
    }
}
