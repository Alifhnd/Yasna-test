<?php

namespace Modules\Yasna\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class YasnaSeedingTool
{
    /**
     * keep the table name
     *
     * @var string
     */
    protected $table_name;

    /**
     * keep the array of data to be seeded
     *
     * @var array
     */
    protected $data;

    /**
     * keep the flag specifying whether the table should be truncated beforehand
     *
     * @var bool
     */
    protected $should_truncate_first;

    /**
     * keep an array of the table columns
     *
     * @var array
     */
    protected $columns;

    /**
     * keep the field name which should be controlled to prevent duplicated data
     *
     * @var string
     */
    protected $unique_field = "slug";



    /**
     * YasnaSeedingTool constructor.
     *
     * @param string $table_name
     * @param array  $array
     * @param bool   $should_truncate_first
     * @param string $unique_field
     */
    public function __construct(string $table_name, array $data, string $unique_field = "slug")
    {
        $this->table_name            = $table_name;
        $this->data                  = $data;
        $this->unique_field          = $unique_field;
        $this->columns               = $this->getColumnList();
        $this->should_truncate_first = false;
    }



    /**
     * run the seeding order
     *
     * @return int
     */
    public function run()
    {
        $saved_count = 0;

        Model::unguard();
        if ($this->should_truncate_first) {
            $this->truncate();
        }

        foreach ($this->data as $data) {
            $data = $this->enrichData($data);
            $saved_count += (int)$this->save($data);
        }

        return $saved_count;
    }



    /**
     * save the seeding data
     *
     * @param array $data
     *
     * @return bool
     */
    protected function save(array $data)
    {
        $existing = $this->getExistingRecord($data);

        if (!$existing) {
            return $this->insertData($data);
        }

        if (isset($existing->updated_by) and !$existing->updated_by) {
            return $this->updateData($data);
        }

        return false;
    }



    /**
     * insert data as a new record
     *
     * @param array $data
     *
     * @return bool
     */
    protected function insertData(array $data)
    {
        return DB::table($this->table_name)->insert($data);
    }



    /**
     * update existing data
     *
     * @param array $data
     *
     * @return bool
     */
    protected function updateData(array $data)
    {
        $updated = DB::table($this->table_name)->where($this->unique_field, $data[$this->unique_field])->update($data);

        return (bool)$updated;
    }



    /**
     * check if the record already exists
     *
     * @param array $data
     *
     * @return null|object|Model
     */
    protected function getExistingRecord(array $data)
    {
        if ($this->hasNotColumn($this->unique_field) or !isset($data[$this->unique_field]) or !$data[$this->unique_field]) {
            return null;
        }

        return DB::table($this->table_name)->where($this->unique_field, $data[$this->unique_field])->first();
    }



    /**
     * enrich data with standard timestamps
     *
     * @param array $data
     *
     * @return array
     */
    protected function enrichData(array $data)
    {
        $data = $this->fillCreatedAt($data);
        $data = $this->fillDeletedAt($data);
        $data = $this->fillMetaFields($data);

        return $data;
    }



    /**
     * fill meta fields, if present in the table
     *
     * @param array $data
     *
     * @return array
     */
    protected function fillMetaFields(array $data)
    {
        $field_name = "meta";
        $prefix     = $field_name . "-";

        if ($this->hasnotColumn($field_name)) {
            return $data;
        }

        foreach ($data as $key => $value) {
            if (str_contains($key, $prefix)) {
                $data[$field_name][str_after($key, $prefix)] = $value;
                unset($data[$key]);
            }
        }

        if (isset($data[$field_name]) and is_array($data[$field_name])) {
            $data[$field_name] = json_encode($data[$field_name]);
        }

        return $data;
    }



    /**
     * fill deleted_at field, if present in the table
     *
     * @param array $data
     *
     * @return array
     */
    protected function fillDeletedAt(array $data)
    {
        $field_name = 'deleted_at';

        if ($this->hasColumn($field_name) and isset($data['_deleted']) and $data['_deleted']) {
            $data[$field_name] = now()->toDateTimeString();
        }

        unset($data['_deleted']);

        return $data;
    }



    /**
     * fill created_at field, if present in the table
     *
     * @param array $data
     *
     * @return array
     */
    protected function fillCreatedAt(array $data)
    {
        $field_name = 'created_at';

        if ($this->hasColumn($field_name) and !isset($data[$field_name])) {
            $data[$field_name] = now()->toDateTimeString();
        }

        return $data;
    }



    /**
     * truncate the table
     *
     * @return void
     */
    protected function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($this->table_name)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }



    /**
     * check if the table has a certain column
     *
     * @param string $column
     *
     * @return bool
     */
    protected function hasColumn(string $column)
    {
        return in_array($column, $this->columns);
    }



    /**
     * check if the table has not a certain column
     *
     * @param string $column
     *
     * @return bool
     */
    protected function hasnotColumn(string $column)
    {
        return !$this->hasColumn($column);
    }



    /**
     * get column listing of the table
     *
     * @return array
     */
    protected function getColumnList()
    {
        return Schema::getColumnListing($this->table_name);
    }

}
