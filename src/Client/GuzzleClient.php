<?php

namespace JiraClient\Client;

use GuzzleHttp\Client,
    JiraClient\Credential,
    JiraClient\Response,
    JiraClient\Exception\JiraException;

/**
 * Description of GuzzleClient
 *
 * @author rastor
 */
class GuzzleClient
{

    /**
     *
     * @var Client
     */
    private $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    public function sendRequest($method, $url, $data, Credential $credential)
    {
        $request = $this->guzzle->createRequest($method, $url, array(
            'auth' => [$credential->getLogin(), $credential->getPassword()],
            'json' => $data
        ));
        
        try {
            $response = $this->guzzle->send($request);
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
