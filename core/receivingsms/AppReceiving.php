<?php
require_once 'api/methods/AfricasTakingMethods.php';
/**
 *Class for receiving messages with class call
 */
class AppReceiveWithClass
{

  function __construct($apiName,$apiClass)
  {
    $this->apiName = $apiName;
    $this->apiClass = $apiClass;
    $this->APIcaller($this->apiName,$apiClass);
  }

  private function APIcaller($apiName, $apiClass)
  {
    //several switch cases will be here representing every api name supported 
    switch ($apiName) {
      case 'AfricasTalkingGateway':
        $this->AfricasTalkingGatewayAPI($apiClass);
        break;

      default:
        print('API not defined');
        break;
    }
  }

  private function AfricasTalkingGatewayAPI($classPath)
  {
    $ATWC = new AfricasTakingReceiveWithClass($classPath);
  }
}

/**
 * Class for receiving messages with url call
 */
class AppReceiveWithUrl
{

  function __construct($name,$url)
  {
    $this->name = $name;
    $this->url = $url;
    $this->APIcaller($this->name,$this->url);
  }

  private function APIcaller($apiName, $apiUrl)
  {
    switch ($apiName) {
      case 'AfricasTalkingGateway':
        $this->AfricasTalkingGatewayAPI($apiUrl);
        break;

      default:
        print('API not defined');
        break;
    }
  }
}


?>
