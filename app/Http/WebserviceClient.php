<?php
namespace App\Http;
use App\Constrants;
use GuzzleHttp\Client;
class WebserviceClient
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
        return $webServiceClient->get(Constrants::WEB_SERVICE_URI, $param);
    }
}
?>