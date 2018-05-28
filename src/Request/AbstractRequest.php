<?php

namespace JiraClient\Request;

use JiraClient\JiraClient;

/**
 * Description of AbstractRequest
 *
 * @author pbrasseur
 */
class AbstractRequest
{

    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';

    /**
     *
     * @var JiraClient 
     */
    protected $client;

    public function __construct(JiraClient $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

}
