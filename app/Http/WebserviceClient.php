<?php
namespace App\Http;
use GuzzleHttp\Client;
//use App\Constrants;
class WebServiceClient
{
	private static $client; 

	public function getWebServiceClient(){
        if(self::$client==null){
            self::$client = new Client([
                'base_uri' => Constrants::WEB_SERVICE_URI,
                'timeout'  => 2.0,
            ]);
        }
        return self::$client;
    }

    public function callWebservice($param){
        $webServiceClient = $this->getWebServiceClient();
        $response = $webServiceClient->get(Constrants::WEB_SERVICE_URI, $param);
        return json_decode($response->getBody()->getContents(),true);
    }
}
?>