<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/17/18
 * Time: 11:59 AM
 */

namespace Modules\Users\Services\Profile;


use App\Models\User;
use Closure;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;

class UserProfile
{
    use ModuleRecognitionsTrait;
    use UserProfileServicesTrait;
    use UserProfileLinkTrait;

    /**
     * The Main User
     *
     * @var User|null
     */
    protected $user;



    /**
     * UserProfile constructor.
     *
     * @param User|null $user
     */
    public function __construct(?User $user = null)
    {
        $this->user = ($user ?? $this->defaultUser());
    }



    /**
     * Returns the default User which will be used in case of no user specified in the construction.
     *
     * @return User
     */
    protected function defaultUser()
    {
        return user();
    }
}
