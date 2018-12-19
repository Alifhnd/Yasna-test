<?php
namespace Modules\Yasna\Services\ModelTraits;

use Illuminate\Database\Eloquent\Builder;

trait ElectorTrait
{
    use ElectorSearchTrait;

    private $elector_query;
    private $elector_parameters;
    private $elector_custom_builder = false;



    /**
     * Main Calling Method
     * Returns a Builder instance, if an empty array is passed.
     *
     * @see github wiki for more information.
     *
     * @param array|bool $parameters                : key-value pair
     * @param array      $bypassed_consistent_rules : simple list
     *
     * @return Builder
     */
    public function elector($parameters = false, $bypassed_consistent_rules = [])
    {
        if (is_array($parameters)) {
            $this->initiateElectorQuery();
            $this->runDynamicElectors($parameters);
            $this->runConsistentElectors($bypassed_consistent_rules);
        }

        return $this->q();
    }



    /**
     * @param $parameter
     *
     * @return mixed
     */
    public function getElector($parameter)
    {
        if (isset($this->elector_parameters[$parameter])) {
            return $this->elector_parameters[$parameter];
        }

        return false;
    }



    /**
     * @param $parameter
     *
     * @return bool
     */
    public function issetElector($parameter)
    {
        return isset($this->elector_parameters[$parameter]);
    }



    /**
     * Initiates the query
     */
    private function initiateElectorQuery()
    {
        $this->elector_query = $this->newInstance()->whereRaw('1=1');
    }



    /**
     * @param $parameters
     */
    private function runDynamicElectors($parameters)
    {
        $this->elector_parameters = $parameters;

        foreach ($parameters as $key => $value) {
            $method_name = camel_case("elector $key");

            if ($this->hasMethod($method_name) and isset($value)) {
                if (is_string($value) and strtolower($value) == 'null') {
                    $value = null;
                }
                $this->$method_name($value);
            }
        }
    }



    /**
     * @param $bypass_array
     */
    private function runConsistentElectors($bypass_array)
    {
        $bypass_array = (array)$bypass_array;
        foreach ($this->listConsistentElectors() as $consistentElector) {
            if (not_in_array($consistentElector, $bypass_array)) {
                $method_name = camel_case("consistentElector $consistentElector");
                $this->$method_name();
            }
        }
    }



    /**
     * @param string|array $criteria
     */
    protected function electorCriteria($criteria)
    {
        /*-----------------------------------------------
        | Parser ...
        */
        if (is_string($criteria)) {
            $criteria = explode_not_empty(',', $criteria);
        }

        /*-----------------------------------------------
        | Going Through ...
        */
        foreach ((array)$criteria as $criterion) {
            $method_name = camel_case("electorCriteria $criterion");

            if ($this->hasMethod($method_name)) {
                $this->$method_name();
            } else {
                $this->electorFieldDestroy();
            }
        }
    }



    /**
     * Adds a $query->where('slug',$slug) to the query.
     *
     * @param string $slug
     */
    protected function electorSlug($slug)
    {
        $this->q()->where('slug', $slug);
    }



    /**
     * @param int $id
     */
    protected function electorId($id)
    {
        $this->electorFieldId(intval($id));
    }



    /**
     * @param $hashid
     */
    protected function electorHashid($hashid)
    {
        $this->electorFieldId($hashid);
    }



    /**
     * Adds a $query->where('created_by' , $creator_id) to the query.
     *
     * @param string|integer $creator_id : accepts hashid as well.
     */
    protected function electorCreator($creator_id)
    {
        if (is_string($creator_id)) {
            $creator_id = hashid($creator_id);
        }

        $this->electorFieldId($creator_id, 'created_by');
    }



    /**
     * Adds a $query->where($field_name , $id) to the query.
     *
     * @param string|integer $id : accepts hashid as well.
     * @param string         $field_name
     */
    protected function electorFieldId($id, $field_name = 'id')
    {
        if (is_string($id)) {
            $id = hashid($id);
        }

        $id = intval($id);

        $this->electorFieldValue($field_name, $id);
    }



    /**
     * @param $field_name
     * @param $value
     */
    protected function electorFieldValue($field_name, $value)
    {
        $this->q()->where($field_name, $value);
    }



    protected function electorFieldLike($field_name, $value)
    {
        $this->q()->where($field_name, 'like', "%$value%");
    }



    /**
     * Adds a $query->where($field_name , $value), but makes sure the value is in boolean.
     *
     * @param boolean $value
     * @param string  $field_name
     */
    protected function electorFieldBoolean($value, $field_name)
    {
        $this->q()->where($field_name, boolval($value));
    }



    protected function electorFieldDestroy()
    {
        $this->electorFieldId(0);
    }



    /**
     * @return array
     */
    public function listElectors()
    {
        $methods = $this->methodsArray('elector');
        $result  = [];

        foreach ($methods as $method) {
            if ($method == 'elector') {
                continue;
            }
            if (str_contains($method, 'electorField')) {
                continue;
            }
            if (str_contains(strtolower($method), 'selector')) {
                continue;
            }

            $result[] = snake_case(str_replace('elector', null, $method));
        }

        return $result;
    }



    public function listCriteriaElectors()
    {
        $keyword = "electorCriteria";
        $methods = $this->methodsArray($keyword);

        $result = [];

        foreach ($methods as $method) {
            if ($method == $keyword) {
                continue;
            }
            $result[] = snake_case(str_replace($keyword, null, $method));
        }

        return $result;
    }



    /**
     * @return array
     */
    public function listConsistentElectors()
    {
        $methods = $this->methodsArray('consistentElector');
        $result  = [];

        foreach ($methods as $method) {
            $result[] = snake_case(str_replace('consistentElector', null, $method));
        }

        return $result;
    }



    /**
     * @return Builder
     */
    private function q()
    {
        return $this->elector_query;
    }



    /**
     * Creates a custom Builder queue for easier custom query building
     *
     * @return Builder
     */
    protected function build()
    {
        if ($this->elector_custom_builder === false) {
            $this->elector_custom_builder = $this->whereRaw('1=1');
        }

        return $this->elector_custom_builder;
    }
}



// Methods Ideas: CreatedBefore, CreatedAfter
