<?php 

namespace Modules\Post\Entities;

use Modules\Yasna\Services\YasnaModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends YasnaModel
{
    use SoftDeletes;

    protected $fillable = ['title'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class , 'post_tags' , 'post_id');
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


}
