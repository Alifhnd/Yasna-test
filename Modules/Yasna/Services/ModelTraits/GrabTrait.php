<?php namespace Modules\Yasna\Services\ModelTraits;

/*
 * Responsible to grab a single record, using id, hashid, slug, or any other field provided as the second argument.
 * Role::grab( $id_or_hashid_or_slug  , $field_name = 'slug' )
 */

trait GrabTrait
{
    public static function bootGrabTrait()
    {
        static::addGlobalScope(new YasnaGrabScope);
    }



    public static function grabber($needle = 0, $with_trashed)
    {
        if ($with_trashed) {
            return get_called_class()::withTrashed()->grab($needle);
        } else {
            return get_called_class()::grab($needle);
        }
    }
}
