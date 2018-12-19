<?php
namespace Modules\Yasna\Services\ModelTraits;

trait ElectorSearchTrait
{
    /**
     * Lists all xSearchableFields() methods and merges their arrays to return an array of searchable fields.
     *
     * @return array
     */
    public function getSearchableFields()
    {
        $result = [];

        foreach ($this->methodsArray('SearchableFields') as $method) {
            if ($method == 'getSearchableFields') {
                continue;
            }

            $result = array_merge($result, $this->$method());
        }

        return $result;
    }



    protected function electorSearch($keyword)
    {
        $searchable_fields = $this->getSearchableFields();
        $concat_string     = " ";


        /*-----------------------------------------------
        | Safety Bypass ...
        */
        if (!count($searchable_fields)) {
            $this->electorFieldDestroy();
            return;
        }

        /*-----------------------------------------------
        | Process ...
        */
        foreach ($searchable_fields as $field) {
            $concat_string .= " , `$field` ";
        }

        $this->elector_query->whereRaw(" LOCATE('$keyword' , CONCAT_WS(' ' $concat_string)) ");
    }
}
