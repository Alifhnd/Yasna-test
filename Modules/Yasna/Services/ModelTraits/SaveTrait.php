<?php
namespace Modules\Yasna\Services\ModelTraits;

use Illuminate\Database\Eloquent\Model;

trait SaveTrait
{
    private $data_being_saved;
    private $id_being_saved;



    /**
     * @param       $request             : an array, or raw Request, to be saved into db.
     * @param array $overflow_parameters : parameters to be unset before the actual save command.
     *
     * @return $this
     */
    public function batchSave($request, $overflow_parameters = [])
    {
        $this->batchSavePurification($request, $overflow_parameters);
        $this->batchSaveAddPersons();
        $this->batchCollectMeta();

        if ($this->id) {
            $saved = $this->batchsaveUpdate();
        } else {
            $saved = $this->batchSaveCreate();
        }

        return $saved;
    }



    /**
     * Just like batchSave(), but returns boolean
     *
     * @param       $request             : an array, or raw Request, to be saved into db.
     * @param array $overflow_parameters : parameters to be unset before the actual save command.
     *
     * @return boolean
     */
    public function batchSaveBoolean($request, $overflow_parameters = [])
    {
        return $this->batchSave($request, $overflow_parameters)->exists;
    }



    /**
     * Just like batchSave(), but returns the id
     *
     * @param       $request             : an array, or raw Request, to be saved into db.
     * @param array $overflow_parameters : parameters to be unset before the actual save command.
     *
     * @return integer: saved model id
     */
    public function batchSaveId($request, $overflow_parameters = [])
    {
        return $this->batchSave($request, $overflow_parameters)->id;
    }



    /**
     * @param $data
     * @param $overflow_parameters
     */
    private function batchSavePurification($data, $overflow_parameters)
    {
        /*-----------------------------------------------
        | Array Conversion ...
        */
        if (!is_array($data)) {
            $data = $data->toArray();
        }

        /*-----------------------------------------------
        | Safe Id ...
        */
        unset($data['id']);

        /*-----------------------------------------------
        | Hashid ...
        */
        //if(isset($data['hashid']) and !$data['id']) {
        //	$data['id'] = hashid($data['hashid']);
        //}

        /*-----------------------------------------------
        | Unset Overflow Parameters ...
        */
        $overflow_parameters = array_merge($overflow_parameters, ['key', 'security', 'hashid']);
        foreach ($overflow_parameters as $parameter) {
            if (isset($data[$parameter])) {
                unset($data[$parameter]);
            }
        }

        foreach ($data as $key => $item) {
            if ($key[0] == '_') {
                unset($data[$key]);
            }
        }


        /*-----------------------------------------------
        | Return ...
        */
        $this->data_being_saved = $data;
        $this->id_being_saved   = $this->id;
    }



    /**
     * Automatically add created_by and updated_by values to the data being saved.
     */
    private function batchSaveAddPersons()
    {
        if ($this->id) {
            $field = 'updated_by';
        } else {
            $field = 'created_by';
        }

        if ($this->hasField($field) and !isset($this->data_being_saved[$field])) {
            $this->data_being_saved[$field] = user()->id;
        }
    }



    /**
     * Automatically bundles all meta fields, into a single json field.
     */
    private function batchCollectMeta()
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem()) {
            return;
        }

        /*-----------------------------------------------
        | Process ...
        */
        foreach ($this->data_being_saved as $field => $value) {
            $this->setMeta($field, $value);
            if ($this->isMeta($field)) {
                unset($this->data_being_saved[$field]);
            }
        }
        $this->data_being_saved['meta'] = $this->UpdateMetaProperty();

        /*-----------------------------------------------
        | Return ...
        */
        return;
    }



    /**
     * @return Model
     */
    private function batchSaveCreate()
    {
        $saved = $this->create($this->data_being_saved);
        if ($saved) {
            return $saved->fresh();
        } else {
            return $this->newInstance();
        }
    }



    /**
     * @return $this
     */
    private function batchSaveUpdate()
    {
        //chalk()->add("id " . $this->id_being_saved);
        //chalk()->add($this->data_being_saved);
        $saved = $this->update($this->data_being_saved);
        if ($saved) {
            return $this;
        } else {
            return $this->newInstance();
        }
    }



    /**
     * @param       $id_array
     * @param array $data : doesn't support meta fields.
     * @param int   $exception
     *
     * @return boolean
     */
    public function multiSet($id_array, $data = [], $exception = 0)
    {
        if ($this->hasField('updated_by')) {
            $data['updated_by'] = user()->id;
        }

        return $this
             ->whereIn('id', $id_array)
             ->where('id', '!=', $exception)
             ->update($data)
             ;
    }
}
