<?php

namespace JiraClient\HttpClient;

use GuzzleHttp\Client,
    JiraClient\Credential,
    JiraClient\Response,
    JiraClient\Exception\JiraException;

/**
 * Description of GuzzleClient
 *
 * @author rastor
 */
class GuzzleClient extends AbstractClient
{

    /**
     *
     * @var Client
     */
    private $guzzle;

    /**
     * is guzzle 6 version
     * 
     * @var boolean
     */
    private $isNewVersion;

    public function __construct()
    {
        $this->guzzle = new Client();

        $this->isNewVersion = class_exists('GuzzleHttp\Psr7\Request');
    }

    public function sendRequest($method, $url, $data, Credential $credential)
    {
        $options = array(
            'auth' => [$credential->getLogin(), $credential->getPassword()],
            'json' => $data
        );

        try {
            if ($this->isNewVersion) {
                $response = $this->guzzle->request($method, $url, $options);
            } else {
                $request = $this->guzzle->createRequest($method, $url, $options);
                $response = $this->guzzle->send($request);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $data = $e->getResponse()->getBody()->getContents();
                throw new JiraException("Request failed. Response: {$data}", $e);
            }

            throw new JiraException("Request failed", $e);
        }

        $responseContent = $response->getBody()->getContents();

        $responseData = json_decode($responseContent, true);

        return new Response($responseData, $response->getStatusCode());
    }

}
