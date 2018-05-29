<?php

namespace JiraClient;

use JiraClient\Request\Issue;

/**
 * Description of JiraClient
 *
 * @author pbrasseur
 */
class JiraClient
{

    const ENDPOINT_PATH = '/rest/api/2';

    private $credential;
    private $endpoint;

    /**
     *
     * @var Issue 
     */
    private $issueRequest;

    /**
     *
     * @var \JiraClient\HttpClient\AbstractClient 
     */
    private $httpClient;

    public function __construct($endpoint, $login = null, $password = null, \JiraClient\HttpClient\AbstractClient $httpClient = null)
    {
        $this->endpoint = $endpoint . self::ENDPOINT_PATH;
        $this->credential = new Credential($login, $password);

        if ($httpClient === null) {
            $this->httpClient = new HttpClient\GuzzleClient();
        } else {
            $this->httpClient = $httpClient;
        }
    }

    /**
     * 
     * @return Issue
     */
    public function issue()
    {
        if ($this->issueRequest === null) {
            $this->issueRequest = new Request\Issue($this);
        }

        return $this->issueRequest;
    }

    public function call($method, $path, $data = array())
    {
        return $this->httpClient->sendRequest($method, $this->endpoint . $path, $data, $this->credential);
    }

    public function callPost($path, $data = array())
    {
        return $this->call(Request\AbstractRequest::METHOD_POST, $path, $data);
    }

    public function callGet($path, $data = array())
    {
        return $this->call(Request\AbstractRequest::METHOD_GET, $path, $data);
    }

    public function callPut($path, $data = array())
    {
        return $this->call(Request\AbstractRequest::METHOD_PUT, $path, $data);
    }

    public function callDelete($path, $data = array())
    {
        return $this->call(Request\AbstractRequest::METHOD_DELETE, $path, $data);
    }

}
