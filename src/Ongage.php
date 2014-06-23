<?php
namespace RfgOngage;

class Ongage
{
    /**
     * @var username Ongage Username
     */
    protected static $username;

    /**
     * @var password Ongage Password
     */
    protected static $password;

    /**
     * @var account_code Ongage Account Code
     */
    protected static $account_code;

    /**
     * @var \GuzzleHttp\Client The Guzzle HTTP client
     */
    protected static $httpClient;

    /**
     * @const string Ongage API URL
     */
    const BASE_ONGAGE_URL = 'https://api.ongage.net/api';

    /**
     * Function __construct
     * @param string $username
     * @param string $password
     * @param string $account_code
     */
    public function __construct($username = null, $password = null, $account_code = null)
    {
        // Instatiate GuzzleHttp Client
        self::$httpClient = new GuzzleHttp\Client();

        // Set Authentication Variables
        self::$username = $username;
        self::$password = $password;
        self::$account_code = $account_code;
    }

    public function send($OngageObject) {
        
    }
}