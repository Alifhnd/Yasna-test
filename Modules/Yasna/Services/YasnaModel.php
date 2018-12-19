<?php namespace Modules\Yasna\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Yasna\Services\GeneralTraits\Serializable;
use Modules\Yasna\Services\ModelTraits\CompatibilityTrait;
use Modules\Yasna\Services\ModelTraits\DeleteTrait;
use Modules\Yasna\Services\ModelTraits\ElectorTrait;
use Modules\Yasna\Services\ModelTraits\ExistenceTrait;
use Modules\Yasna\Services\ModelTraits\GrabTrait;
use Modules\Yasna\Services\ModelTraits\HelpersTrait;
use Modules\Yasna\Services\ModelTraits\MetaTrait;
use Modules\Yasna\Services\ModelTraits\PersonsTrait;
use Modules\Yasna\Services\ModelTraits\SaveTrait;
use Modules\Yasna\Services\ModelTraits\ScopesTrait;
use Modules\Yasna\Services\ModelTraits\StructureTrait;
use Modules\Yasna\Events\ModelSaved;

/**
 * Class YasnaModel
 *
 * @property $hashid
 * @method grab($identifier, $field)
 * @method grabId(int $id)
 * @method grabSlug(string $slug)
 * @method grabHashid(string $hashid)
 * @package Modules\Yasna\Services
 */
abstract class YasnaModel extends Model
{
    use Serializable;
    use StructureTrait;     // Adds methods, holding information about the class itself, and the containing module.
    use PersonsTrait;       // Responsible for finding persons behind created_by, updated_by, and any other did_by else.
    use MetaTrait;          // Responsible for Meta system management.
    use SaveTrait;          // Responsible for save functionality.
    use DeleteTrait;        // Responsible for delete functionality.
    use ElectorTrait;       // Responsible for selecting a number of records.
    use GrabTrait;          // Responsible for selecting one record.
    use ExistenceTrait;     // Responsible for isExists
    use HelpersTrait;       // Adds some frequently-used helper function to the model instances.
    use CompatibilityTrait; // Houses old methods, for the compatibility reasons only.
    use ScopesTrait;        // Adds scopes

    public static $abstract_version = 2.0; // <~~ Please don't override this. Thanks.
    public        $invalids         = false;
    protected     $guarded          = ['id'];
    protected     $fields_array     = [];
    protected     $dispatchesEvents = [
         'saved'   => ModelSaved::class,
         "deleted" => ModelSaved::class,
    ];



    /**
     * @return Model: A fresh new instance of the current model
     */
    public static function instance()
    {
        return model(self::className());
    }



    /**
     * @return string
     */
    public function getHashIdAttribute()
    {
        return hashid_encrypt($this->id, 'ids');
    }



    /**
     * Makes sure new instances are equipped with id = 0, instead of the trouble-maker null.
     *
     * @param array $attributes
     * @param bool  $exists
     *
     * @return Model
     */
    public function newInstance($attributes = [], $exists = false)
    {
        $model     = parent::newInstance($attributes, $exists);
        $model->id = 0;

        return $model;
    }
}
