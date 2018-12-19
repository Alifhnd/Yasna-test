<?php

namespace Modules\Post\Entities;

use Modules\Yasna\Entities\User;
use Modules\Yasna\Services\YasnaModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends YasnaModel
{
    use SoftDeletes;

    protected $guarded    = ['id'];
    protected $primaryKey = 'id';

    const PUBLISHED = 1;
    const FUTURE    = 2;
    const DRAFT     = 3;
    const PENDING   = 4;



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'post_author');
    }



    /**
     * get the main meta fields of the table.
     *
     * @return array
     */
    public function mainMetaFields()
    {
        return [
            //TODO: Fill this with the names of your meta fields, or remove the method if you do not want meta fields at all.
        ];
    }



    /**
     * get an array of status messages
     *
     * @return array
     */

    public static function getStatusArray()
    {
        return [
             self::DRAFT     => trans_safe('post::message.draft'),
             self::FUTURE    => trans_safe('post::message.future'),
             self::PENDING   => trans_safe('post::message.pending'),
             self::PUBLISHED => trans_safe('post::message.published'),
        ];
    }



    public static function getStatusComboArray()
    {
        $array = [];
        foreach (static::getStatusArray() as $key => $value) {
            $array[] = [$key,$value];
        }

        return $array;
    }



    /**
     * get the description of a given status number
     *
     * @param int $status
     *
     * @return string|null
     */
    public static function getStatusDescription(int $status)
    {
        $array = static::getStatusArray();

        if(isset($array[$status])) {
            return $array[$status];
        }

        return null;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     *
     * @return mixed
     */
    //public function storePost($request)
    //{
    //    $post = Post::batchsave([
    //         'post_title'   => $request->input('title'),
    //         'post_content' => $request->input('content'),
    //         'post_author'  => User::first()->id,
    //         'post_status'  => $request->input('postStatus'),
    //    ]);
    //
    //    if ($post && $post instanceof Post) {
    //
    //        $tags      = $request->input('postTags');
    //        $savedTags = [];
    //        foreach ($tags as $key => $tag) {
    //            if (intval($tag) == 0) {
    //                unset($tags[$key]);
    //                $newTag      = Tag::create(['title' => $tag]);
    //                $savedTags[] = $newTag->id;
    //            }
    //        }
    //        $tags = array_map(function ($item) {
    //            return intval($item);
    //        }, $savedTags);
    //        $tags = array_unique($tags);
    //        $post->tags()->sync($tags);
    //
    //
    //    }
    //    return $post;
    //}
}
