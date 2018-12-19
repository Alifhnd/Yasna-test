<?php
namespace Modules\Yasna\Services\Responders\Standards;

use Modules\Yasna\Services\Responders\ApiResponseAbstract;
use Modules\Yasna\Services\Responders\ApiResponseInterface;

class ApiWhiteHouseResponse extends ApiResponseAbstract implements ApiResponseInterface
{
    protected $status;
    protected $developer_message_code = null;
    protected $developer_message      = null;
    protected $user_message_code      = null;
    protected $user_message           = null;
    protected $error_code             = null;
    protected $more_info              = null;
    protected $errors                 = [];



    /**
     * @inheritdoc
     */
    public function errorArray($error_code, int $status_code = 400)
    {
        $this->withStatus($status_code);
        $this->withErrorCode($error_code);

        return [
             "status"           => $this->getStatus(),
             "developerMessage" => $this->getDeveloperMessage(),
             "userMessage"      => $this->getUserMessage(),
             "errorCode"        => $this->getErrorCode(),
             "moreInfo"         => $this->getMoreInfoMessage(),
             "errors"           => $this->getErrors(),
        ];
    }



    /**
     * @inheritdoc
     */
    public function errorRespond($error_code, int $status_code = 400)
    {
        return response(
             $this->errorArray($error_code, $status_code),
             $status_code,
             [
                  "application/json",
             ]
        );
    }



    /**
     * @inheritdoc
     */
    public function clientErrorRespond($error_code, int $status_code = 400)
    {
        return $this->errorRespond($error_code, $status_code);
    }



    /**
     * @inheritdoc
     */
    public function serverErrorRespond($error_code, int $status_code = 500)
    {
        return $this->errorRespond($error_code, $status_code);
    }



    /**
     * @inheritdoc
     */
    public function successArray($results, $metadata = [])
    {
        $this->withStatus(200);
        if (count($metadata)) {
            $this->withMetadata($metadata);
        }

        return [
             "status"   => $this->getStatus(),
             "metadata" => $this->getMetadata(),
             "results"  => $results,
        ];
    }



    /**
     * @inheritdoc
     */
    public function successRespond($results = [], $metadata = [])
    {
        return response(
             $this->successArray($results, $metadata),
             200,
             [
                  "application/json",
             ]
        );
    }



    /**
     * set a custom error code
     *
     * @param $code
     *
     * @return $this
     */
    public function withErrorCode($code)
    {
        $this->error_code = $code;
        if (!$this->developer_message) {
            $this->withDeveloperMessageCode($code);
        }
        if (!$this->user_message) {
            $this->withUserMessageCode($code);
        }

        return $this;
    }



    /**
     * get developer message from the client module's trans files
     *
     * @return string
     */
    protected function getDeveloperMessage()
    {
        return $this->trans("developerMessages", $this->getDeveloperMessageCode());
    }



    /**
     * get more info message from the client module's config files
     *
     * @return string
     */
    protected function getMoreInfoMessage()
    {
        $map_root = static::getModuleAlias() . "." . "moreInfo";
        $map_main = "$map_root." . $this->getErrorCode();

        $config_main = config($map_main);
        if ($config_main) {
            return $config_main;
        }

        $config_alternative = config("$map_root.default");
        if ($config_alternative) {
            return $config_alternative;
        }

        if (debugMode()) {
            return $map_main;
        }

        return '';
    }



    /**
     * get user message from the client module's trans files
     *
     * @return string
     */
    protected function getUserMessage()
    {
        return $this->trans("userMessages", $this->getUserMessageCode());
    }
}
