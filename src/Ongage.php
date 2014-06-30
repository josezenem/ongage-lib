<?php
namespace RfgOngage;

use GuzzleHttp;

class Ongage
{

    /**
     *
     * @var username Ongage Username
     */
    protected static $username;

    /**
     *
     * @var password Ongage Password
     */
    protected static $password;

    /**
     *
     * @var account_code Ongage Account Code
     */
    protected static $account_code;

    /**
     *
     * @var \GuzzleHttp\Client The Guzzle HTTP client
     */
    protected static $httpClient;

    /**
     * @const string Ongage API URL
     */
    const BASE_ONGAGE_URL = 'https://api.ongage.net/api';

    /**
     * Function __construct
     *
     * @param string $username            
     * @param string $password            
     * @param string $account_code            
     */
    public function __construct($username = null, $password = null, $account_code = null)
    {
        // Instatiate GuzzleHttp Client
        self::$httpClient = new GuzzleHttp\Client([
            'base_url' => self::BASE_ONGAGE_URL
        ]);
        
        // Set Authentication Variables
        self::$username = $username;
        self::$password = $password;
        self::$account_code = $account_code;
    }

    public function send($OngageObject)
    {
        $request = self::$httpClient->createRequest($OngageObject->request_type, self::BASE_ONGAGE_URL . $OngageObject->base_endpoint . $OngageObject->method, array(
            'body' => $OngageObject->body,
            'query' => $OngageObject->query
        ));
        // $request = self::$httpClient->post(self::BASE_ONGAGE_URL . $OngageObject->base_endpoint, array('X_USERNAME' => self::$username, 'X_PASSWORD' => self::$password, 'X_ACCOUNT_CODE' => self::$account_code), json_encode($OngageObject->parameters));
        $request->setHeader('X_USERNAME', self::$username);
        $request->setHeader('X_PASSWORD', self::$password);
        $request->setHeader('X_ACCOUNT_CODE', self::$account_code);
        //$request->setHeader('Content-Type', $OngageObject->contentType);
        try {
            $response = self::$httpClient->send($request);
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody());
            }
        }
    }
}