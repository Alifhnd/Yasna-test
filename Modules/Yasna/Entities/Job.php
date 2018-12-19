<?php namespace Modules\Yasna\Entities;

use Modules\Yasna\Services\YasnaModel;

class Job extends YasnaModel
{
    protected $guarded = ["id"];



    /**
     * @return array
     */
    public function show()
    {
        $array           = $this->toArray();
        $decoded_payload = json_decode($this->payload, true);
        $array           = array_merge($array, $decoded_payload, $decoded_payload['data']);

        unset($array['payload']);
        unset($array['data']);

        $array['available_at'] = carbon()::createFromTimestamp($array['available_at'])->toDateTimeString();

        return $array;
    }
}
