<?php

namespace JiraClient;

use JiraClient\Client\AbstractClient,
    JiraClient\Request\IssueRequest;

/**
 * Description of JiraClient
 *
 * @author rastor
 */
class JiraClient
{

    const ENDPOINT_PATH = '/rest/api/2';

    private $credential;
    private $endpoint;

    /**
     *
     * @var AbstractClient
     */
    private $httpClient;

    public function __construct($endpoint, $login = null, $password = null)
    {
        $this->endpoint = $endpoint . self::ENDPOINT_PATH;
        $this->credential = new Credential($login, $password);
        $this->httpClient = new Client\GuzzleClient();
    }

    /**
     * 
     * @return IssueRequest
     */
    public function issue()
    {
        return new IssueRequest($this, $this->credential);
    }

    public function call($method, $path, $data = array())
    {
        return $this->httpClient->sendRequest($method, $this->endpoint . $path, $data, $this->credential);
    }

    public function callPost($path, $data = array())
    {
        return $this->httpClient->sendRequest(Request\AbstractRequest::METHOD_POST, $this->endpoint . $path, $data, $this->credential);
    }

    public function callGet($path, $data = array())
    {
        return $this->httpClient->sendRequest(Request\AbstractRequest::METHOD_GET, $this->endpoint . $path, $data, $this->credential);
    }

    public function callPut($path, $data = array())
    {
        return $this->httpClient->sendRequest(Request\AbstractRequest::METHOD_PUT, $this->endpoint . $path, $data, $this->credential);
    }

    public function callDelete($path, $data = array())
    {
        return $this->httpClient->sendRequest(Request\AbstractRequest::METHOD_DELETE, $this->endpoint . $path, $data, $this->credential);
    }

}
