<?php

namespace JiraClient\Client;

use JiraClient\Response;

/**
 * Description of GuzzleClient
 *
 * @author rastor
 */
class AbstractClient
{
    /**
     * @return Response
     */
    public function sendRequest($method, $url, $data, $credential);
}
