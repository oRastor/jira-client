<?php

namespace JiraClient\Exception;

/**
 * Description of ResponseException
 *
 * @author rastor
 */
class ResponseException extends JiraException
{

    protected $response;

    public function setResponse($value)
    {
        $this->response = $value;
    }
    
    public function getResponse()
    {
        return $this->response;
    }

}
