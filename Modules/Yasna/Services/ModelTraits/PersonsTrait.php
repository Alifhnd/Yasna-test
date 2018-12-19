<?php
namespace Modules\Yasna\Services\ModelTraits;

use App\Models\User;

/**
 * Class PersonsTrait
 * @package Modules\Yasna\Services\ModelTraits
 * @property $creator
 */
trait PersonsTrait
{

    /**
     * @param $field
     * @return User
     */
    public function getPerson($field)
    {
        $user_id = $this->$field;
        if ($user_id) {
            $user = cache()->remember("user-$user_id", 10, function () use ($user_id) {
                return model('user', $user_id);
            });
        } else {
            $user = false;
        }

        if (!$user) {
            $user = model('user');
        }

        return $user;
    }



    /**
     * @return User
     */
    public function getCreatorAttribute()
    {
        return $this->getPerson('created_by');
    }



    /**
     * @return User
     */
    public function getPublisherAttribute()
    {
        return $this->getPerson('published_by');
    }



    /**
     * @return User
     */
    public function getUpdaterAttribute()
    {
        return $this->getPerson('updated_by');
    }



    /**
     * @return User
     */
    public function getDeleterAttribute()
    {
        return $this->getPerson('deleted_by');
    }
}
