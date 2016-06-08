<?php
require_once 'api/methods/AfricasTakingMethods.php';
/**
 * class for sending using API class
 */
class AppSendingWithClass
{

  function __construct($apiName,$apiClass,$phoneNumber,$textMessage)
  {
    $this->apiName = $apiName;
    $this->apiClass = $apiClass;
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->APIcaller($this->apiName,$this->apiClass,$this->phoneNumber,$this->textMessage);
  }

  private function APIcaller($apiName,$apiClass,$phoneNumber,$textMessage)
  {
      //several switch cases will be here representing every api name supported
      switch ($apiName) {
        case 'AfricasTalkingGateway':
          $this->AfricasTalkingGatewayAPI($apiClass,$phoneNumber,$textMessage);
          break;

        default:
          print('API not defined');
          break;
      }
  }

  private function AfricasTalkingGatewayAPI($classPath,$phoneNumber,$textMessage)
  {
    $ATWC = new AfricasTakingSendWithClass($classPath,$phoneNumber,$textMessage);
  }
}

/**
 * class for sending using API urlroute
 */
class AppSendingWithURL
{

  function __construct($apiName,$apiUrl,$phoneNumber,$textMessage)
  {
    $this->apiName = $apiName;
    $this->apiUrl = $apiUrl;
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->URLcaller($this->apiName,$this->apiUrl,$this->phoneNumber,$this->textMessage);
  }

  private function URLcaller($apiName,$apiUrl,$phoneNumber,$textMessage)
  {
    //several switch cases will be here representing every api name supported
    switch ($apiName) {
      case 'AfricasTalkingGateway':
        $this->AfricasTalkingGatewayAPI($apiUrl,$phoneNumber,$textMessage);
        break;

      default:
        print('API not defined');
        break;
    }

  }

  private function AfricasTalkingGatewayAPI($apiUrl,$phoneNumber,$textMessage)
  {
    $ATWC = new AfricasTakingSendWithUrl($apiUrl,$phoneNumber,$textMessage);
  }
}


?>
