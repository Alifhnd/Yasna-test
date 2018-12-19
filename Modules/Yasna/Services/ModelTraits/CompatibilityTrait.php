<?php namespace Modules\Yasna\Services\ModelTraits;

/*
 * Deprecated Methods!
 */

use Illuminate\Support\Facades\Auth;

trait CompatibilityTrait
{
    protected static $columns_array       = null;
    protected        $saved_selector_para = [];
    protected        $meta_spread         = false;



    /**
     * @deprecated
     */
    public static function counter($parameters, $in_persian = false)
    {
        $return = self::selector($parameters)->count();
        if ($in_persian) {
            return pd($return);
        } else {
            return $return;
        }
    }



    /**
     * @deprecated
     */
    public static function none()
    {
        return self::whereNull('id');
    }



    /**
     * @deprecated
     */
    public static function searchRawQuery($keyword, $fields = null)
    {
        if (!$fields) {
            $fields = static::$search_fields;
        }

        $concat_string = " ";
        foreach ($fields as $field) {
            $concat_string .= " , `$field` ";
        }

        return " LOCATE('$keyword' , CONCAT_WS(' ' $concat_string)) ";
    }



    /**
     * @deprecated
     */
    public static function metaFields()
    {

        /*-----------------------------------------------
        | Signature Variable ...
        */
        if (isset(self::$meta_fields)) {
            $array = self::$meta_fields;
        } else {
            $array = [];
        }

        /*-----------------------------------------------
        | Methods ...
        */
        //$methods = self::methods('MetaFields');
        //foreach($methods as $method) {
        //	$array = array_merge($array, self::$method());
        //}


        return $array;
    }



    /**
     * @deprecated
     */
    public static function storeMeta($data)
    {
        //Bypass...
        //if(!self::hasColumn('meta') or !isset(self::$meta_fields)) {
        if (!self::hasMeta()) {
            return $data;
        }

        //Current Data...
        if (!isset($data['id'])) {
            $data['id'] = 0;
        }
        $model = self::find($data['id']);
        if ($model) {
            if (is_array($model->meta)) {
                $meta = $model->meta;
            } else {
                $meta = json_decode($model->meta, true);
            }
        } else {
            $meta = [];
        }

        //Process...
        foreach ($data as $field => $value) {
            if (self::hasColumn($field) or !self::hasMeta($field)) {
                continue;
            }

            $meta[$field] = $value;
            unset($data[$field]);
        }
        $data['meta'] = json_encode($meta);

        return $data;
    }



    /**
     * @deprecated
     */
    public static function findBySlug($slug, $field = '_default_', $options = [])
    {
        $class = model(self::className());

        /*-----------------------------------------------
        | Solving a probable common mistake ...
        | (In case an options array is passed as the second argument.)
        */
        if (is_array($field)) {
            $options = $field;
            $field   = '_default_';
        }

        /*-----------------------------------------------
        | Options ...
        */
        $options = array_normalize($options, [
             'with_trashed' => false,
             'trashed_only' => false,
        ]);
        if ($field === '_default_') {
            $field = 'slug';
        }

        /*-----------------------------------------------
        | Model ...
        */
        //$model = Cache::remember("$class-$slug", 100, function () use ($options , $class , $field , $slug){
        $model = $class::where($field, $slug);

        if ($options['with_trashed']) {
            $model = $model->withTrashed();
        }
        if ($options['trashed_only']) {
            $model = $model->trashedOnly();
        }
        $model = $model->first();
        //return $model ;
        //});

        if ($model and $model->id) {
            return $model;
        }

        /*-----------------------------------------------
        | Safe Return ...
        */

        return new $class();// self();
    }



    /**
     * @deprecated
     */

    public static function findByHashid($hashid, $connection = true, $options = [])
    {
        $class = model(self::className());

        /*-----------------------------------------------
        | Solving a probable common mistake ...
        | (In case an options array is passed as the second argument.)
        */
        if (is_array($connection)) {
            $options    = $connection;
            $connection = true;
        }


        /*-----------------------------------------------
        | Options ...
        */
        $options = array_normalize($options, [
             'with_trashed' => false,
             'only_trashed' => false,
        ]);
        if ($connection === true) {
            $connection = 'ids';
        }

        /*-----------------------------------------------
        | Safe Decryption ...
        */
        $id = intval(hashid($hashid, $connection));

        /*-----------------------------------------------
        | Model ...
        */
        if ($id) {
            $model = $class::where('id', $id);

            if ($options['with_trashed']) {
                $model = $model->withTrashed();
            }
            if ($options['only_trashed']) {
                $model = $model->onlyTrashed();
            }
            $model = $model->first();
            if ($model and $model->id) {
                return $model;
            }
        }

        /*-----------------------------------------------
        | Safe Return ...
        */

        return new $class();
    }



    /**
     * @deprecated
     */

    public static function store($request, $unset_things = [])
    {
        //Convert to Array...
        if (is_array($request)) {
            $data = $request;
        } else {
            $data = $request->toArray();
        }

        //Hashid...
        if (isset($data['hashid'])) {
            $data['id'] = hashid($data['hashid']);
        }

        //Unset Unnecessary things...
        $unset_things = array_merge($unset_things, ['key', 'security', 'hashid']);
        foreach ($unset_things as $unset_thing) {
            if (isset($data[$unset_thing])) {
                unset($data[$unset_thing]);
            }
        }
        foreach ($data as $key => $item) {
            if ($key[0] == '_') {
                unset($data[$key]);
            }
        }

        //Meta...
        $data = self::storeMeta($data);

        //Action...
        if (isset($data['id']) and $data['id'] > 0) {
            if (self::hasColumn('updated_by') and !isset($data['updated_by'])) {
                if (Auth::check()) {
                    $data['updated_by'] = Auth::user()->id;
                } else {
                    $data['updated_by'] = 0;
                }
            }

            $model = self::where('id', $data['id']);

            if (self::hasColumn('deleted_at')) {
                $model = $model->withTrashed();
            }


            $affected = $model->update($data);
            if ($affected) {
                $model = $model->first();
                if ($model) {
                }
                $affected = $data['id'];
            }
        } else {
            if (self::hasColumn('created_by') and !isset($data['created_by'])) {
                if (Auth::check()) {
                    $data['created_by'] = Auth::user()->id;
                } else {
                    $data['created_by'] = 0;
                }
            }

            $model = self::create($data);
            if ($model) {
                $affected = $model->id;
            } else {
                $affected = 0;
            }
        }

        //feedback...
        return $affected;
    }



    /**
     * @deprecated
     */

    public function settingCombo($slug)
    {
        $options = Setting::get($slug);
        $result  = [];

        foreach ($options as $option) {
            array_push($result, [$option]);
        }

        return $result;
    }



    /**
     * @deprecated
     * @return string
     * (use native getTable() method)
     */
    public static function tableName()
    {
        return self::instance()->getTable();
    }



    /**
     * @param null $search
     *
     * @deprecated
     */
    public static function methods($pattern = null)
    {
        return self::instance()->methodsArray($pattern);
    }



    /**
     * @deprecated (use hasField() instead)
     *
     * @param $column_name
     */
    public static function hasColumn($column_name)
    {
        return self::instance()->hasField($column_name);
    }





    /**
     * @deprecated
     *
     * @param $fields
     */
    public static function hasMeta($field = null)
    {
        if ($field) {
            return self::instance()->isMeta($field);
        } else {
            return self::instance()->hasMetaSystem();
        }
    }



    /**
     * @deprecated
     *
     * @param null $slug
     */
    public static function meta($slug = null)
    {
        return self::instance()->getMeta($slug);
    }
}
