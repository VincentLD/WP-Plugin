<?php 

require_once 'KeplerInterface.php';

class KeplerApi implements KeplerGetVehicules  {

    const DEMO = true;
    
    const KEPLER_VEHICLES_ENDPOINT = 'vehicles/';
    const KEPLER_VERSION_TOKEN = 'v3.0';
    const KEPLER_VERSION_VEHICLES = 'v3.7';
    const KEPLER_DEMO_URL = 'https://demo.kepler-soft.net/api/'; // Ne pas oublier le "/" à la fin.
    
    private static $instance;
    
    private function __construct() {   
        
    }

    // Faire une requête en utilisant le token
    private static function kepler_api_get_full_endpoint($endpoint = '', string $api_version = self::KEPLER_VERSION_TOKEN) : string {

        return self::get_base_url() . $api_version . '/' . $endpoint;
    }

    private static function kepler_get_auth_token() {

        $url = self::kepler_api_get_full_endpoint('auth-token/');
        
        $fields = ['apiKey' => get_option('apiKey')];
        
        $json = self::send_request($url, null, $fields);

        return $json['value'];
    }

    
    private static function send_request(string $url, ?string $token = null, ?array $fields = null) {

        $response = false;

        $curl = curl_init($url);
    
        if($curl) {

            $args = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            ];

            if(!is_null($token))
                $args[CURLOPT_HTTPHEADER] = ['X-Auth-Token: ' .$token];

            if(!is_null($fields))
                $args[CURLOPT_POSTFIELDS] = $fields;                

            curl_setopt_array($curl, $args);

            $response = curl_exec($curl);
            
            $response = json_decode($response, true);

            curl_close($curl);                
        }
     
        return $response;
    }
    
    // Permet de switcher entre l'url test/prod
    private static function get_base_url() {

        if(self::DEMO)
            $url = self::KEPLER_DEMO_URL;
        else
            $url = self::KEPLER_DEMO_URL;
        
        return $url;
    }
    
    // Singleton
    public static function getInstance(): self  {

    if (is_null(self::$instance)) {

        self::$instance = new KeplerApi();
    }

    return self::$instance;
    }

    public static function kepler_get_vehicles(string $endpoint = 'vehicles/', string $api_version = self::KEPLER_VERSION_VEHICLES) : array {
 
        $url = self::kepler_api_get_full_endpoint($endpoint, $api_version);
        
        $json = self::send_request($url, self::kepler_get_auth_token(), $fields = null);
 
        return $json;
    }
}