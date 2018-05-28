<?php

namespace JiraClient\HttpClient;

use JiraClient\Response,
    JiraClient\Credential;

/**
 * Description of GuzzleClient
 *
 * @author pbrasseur
 */
abstract class AbstractClient
{

    /**
     * @return Response
     */
    public abstract function sendRequest($method, $url, $data, Credential $credential);
}
