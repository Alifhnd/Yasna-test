<?php


namespace Modules\Yasna\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Post\Entities\Post;
use Modules\Yasna\Entities\Traits\DeveloperTrait;
use Modules\Yasna\Entities\Traits\PermitsTrait;
use Modules\Yasna\Entities\Traits\AuthorizationTrait;
use Modules\Yasna\Entities\Traits\UserPreferencesTrait;
use Modules\Yasna\Entities\Traits\UserUsernameTrait;
use Modules\Yasna\Services\YasnaModel;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends YasnaModel implements AuthenticatableContract, CanResetPasswordContract, JWTSubject
{
    use SoftDeletes;
    use AuthorizationTrait;
    use Authenticatable;
    use CanResetPassword;
    use DeveloperTrait;
    use UserPreferencesTrait;
    use UserUsernameTrait;

    protected $guarded = ['status'];
    protected $hidden  = ['password'];
    protected $casts   = [
         'meta'                  => "array",
         'preferences'           => "array",
         'password_force_change' => 'boolean',
         'marriage_date'         => 'datetime',
         'birth_date'            => 'datetime',

    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class , 'post_author');
    }


    /*
    |--------------------------------------------------------------------------
    | Assessors
    |--------------------------------------------------------------------------
    |
    */
    public function getFullNameAttribute($original)
    {
        if ($original) {
            return $original;
        }

        if (!$this->exists) {
            return trans_safe("users::forms.deleted_user");
        }

        return $this->name_first . ' ' . $this->name_last;
    }



    public function getManageLinkAttribute()
    {
        if ($this->exists) {
            //TODO: Profile Link here
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Stators
    |--------------------------------------------------------------------------
    |
    */
    //public function preference($slug)
    //{
    //	$this->spreadMeta();
    //	$preferences = array_normalize($this->preferences, [
    //		'max_rows_per_page' => "50",
    //	]);
    //
    //	return $preferences[ $slug ];
    //}


    public function getSignatureAttribute()
    {
        return md5($this->id . $this->created_at . $this->updated_at . $this->deleted_at);
    }



    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->exists and $this->id == user()->id;
    }



    /**
     * @return bool
     */
    public function isNotLoggedIn()
    {
        return !$this->isLoggedIn();
    }



    /**
     * Returns the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }



    /**
     * Returns a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
