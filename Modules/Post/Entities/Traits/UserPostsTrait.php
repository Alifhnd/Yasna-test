<?php 

namespace Modules\Post\Entities\Traits;

use Modules\Post\Entities\Post;

trait UserPostsTrait
{

    public function posts()
    {
        return $this->hasmany(Post::class , 'post_author');
    }
}
//@TODO: Do not forget to register it in your module service provider: $this->addModelTrait("UserPostsTrait", "MODEL_NAME")}
