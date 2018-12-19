<?php namespace Modules\Yasna\Services\ModelTraits;

trait DeleteTrait
{
    /**
     * @return boolean
     */
    public function delete()
    {
        if ($this->hasnotTrashSystem()) {
            return parent::delete();
        }

        $data ['deleted_at'] = $this->now();
        if ($this->hasField('deleted_by')) {
            $data['deleted_by'] = user()->id;
        }
        return $this->update($data);
    }



    /**
     * @return boolean
     */
    public function undelete()
    {
        $data['deleted_at'] = null;
        if ($this->hasField('deleted_by')) {
            $data['deleted_by'] = 0;
        }

        return $this->update($data);
    }



    /**
     * @return boolean
     */
    public function hardDelete()
    {
        $this->forceDeleting = true;

        $deleted = parent::delete();

        $this->forceDeleting = false;

        return $deleted;
    }



    /**
     * @param     $id_array
     * @param int $exception
     *
     * @return boolean
     */
    public function multiDelete($id_array, $exception = 0)
    {
        $data['deleted_at'] = $this->now();
        if ($this->hasField('deleted_by')) {
            $data['deleted_by'] = user()->id;
        }

        return $this
             ->whereIn('id', $id_array)
             ->where('id', '!=', $exception)
             ->update($data)
             ;
    }



    /**
     * @return bool
     * Works just like laravel's native trashed() method, but it's safe to use on models without soft delete support.
     */
    public function isTrashed()
    {
        return boolval($this->deleted_at);
    }



    /**
     * @return bool
     */
    public function isNotTrashed()
    {
        return !$this->isTrashed();
    }



    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->exists and boolval($this->id) and !$this->isTrashed();
    }



    /**
     * @return bool
     */
    public function isNotActive()
    {
        return !$this->isActive();
    }
}
