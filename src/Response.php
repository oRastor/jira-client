<?php

namespace JiraClient;

/**
 * Description of Response
 *
 * @author rastor
 */
class Response
{

    private $data;
    private $code;

    public function __construct($data, $code)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->data;
    }

}
