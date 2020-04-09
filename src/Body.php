<?php


namespace CurlClient;


use Json;

/**
 * Class Body
 */
class Body extends \Slim\Http\Body
{
    private $fh;

    /**
     * Body constructor.
     */
    public function __construct()
    {
        $this->fh = fopen('php://temp', 'r+');
        parent::__construct($this->fh);
    }

    public function __destruct()
    {
        fclose($this->fh);
    }

    /**
     * @param $data
     * @return int
     */
    public function writeJson($data)
    {
        return $this->write(Json::stringify($data));
    }

    /**
     * @param $data
     * @return int
     */
    public function writeFormData($data)
    {
        return $this->write(is_string($data) ? $data : http_build_query($data));
    }
}