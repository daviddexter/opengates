<?php
require_once 'bin/reader.php';

/**
*AfricasTalking supporting methods for both sending and receiving messages
*/
/**
 *
 */
class ResultsBuffer
{
  protected $_results = array ();

  protected function bufferResults()
  {
    foreach ($this->_results as $result) {
      print($result.'<br>');
    }
  }

}
/**
 *using a class to send messages with AfricasTalking API
 */
class AfricasTakingSendWithClass extends ResultsBuffer
{


  function __construct($classPath,$phoneNumber,$textMessage)
  {
    $this->classPath = $classPath;
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->withClassSend($this->classPath,$this->phoneNumber,$this->textMessage);
    $this->bufferResults();
  }

  private function withClassSend($path,$phoneNumber,$textMessage)
  {
    require $path;
    $type = 'APISEND';
    $configReader = ConfigReader::findConfigAll($type);
    $apiKey_ = $configReader[0];
    $apiUser_ = $configReader[1];
    $gateway    = new AfricasTalkingGateway($apiUser_, $apiKey_);

    //send to receipients
    foreach ($phoneNumber as $phone) {
      foreach ($textMessage as $text) {
        try {
              $results = $gateway->sendMessage($phone,$text);
              foreach($results as $result) {
                // status is either "Success" or "error message"
                $status = $result->status;
                array_push($this->_results,$status);
              }

           }catch ( AfricasTalkingGatewayException $e ){
               $er = "Encountered an error while sending.Please check your internet connection ".$e->getMessage();
               array_push($this->_results,$er);

           }
        }
      }
  }

}

/**
 *using a url to send messages with AfricasTalking API
 */
class AfricasTakingSendWithUrl extends ResultsBuffer
{

  function __construct($urlPath,$phoneNumber,$textMessage)
  {
    $this->urlPath = $urlPath;
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->withUrlSend($this->urlPath,$this->phoneNumber,$this->textMessage);
    $this->bufferResults();
  }

  private function withUrlSend($urlPath,$phoneNumber,$textMessage)
  {
    $type = 'APISEND';
    $configReader = ConfigReader::findConfigAll($type);
    $apiKey_ = $configReader[0];
    $apiUser_ = $configReader[1];
    foreach ($phoneNumber as $number) {
      foreach($textMessage as $msg){
        $urlPath.'username='.$apiUser_.'&Apikey='.$apiKey_.'&to='.$number.'&message='.$msg; //returns an xml response
      }
    }
  }
}


/**
 * using a class to receive messages with AfricasTalking API
 */
class AfricasTakingReceiveWithClass extends ResultsBuffer
{

  function __construct($classPath)
  {
    $this->classPath = $classPath;
    $this->withClassReceive($this->classPath);
    $this->bufferResults();
  }

  private function withClassReceive($path)
  {
    require $path;
    $type = 'APIRECEIVE';
    $configReader = ConfigReader::findConfigAll($type);
    $apiKey_ = $configReader[0];
    $apiUser_ = $configReader[1];
    $gateway    = new AfricasTalkingGateway($apiUser_, $apiKey_);

    try {

      $lastReceivedId = 0;

      do {
        $results = $gateway->fetchMessages($lastReceivedId);
        foreach($results as $result){
          //append into results array
          //from,to,message,date,linkId
          $from = $result->from;
          $to = $result->to;
          $message = $result->text;
          $dateSent = $result->date;
          $lastReceivedId = $result->id;
          array_push($this->_results, $from, $to, $message, $dateSent, $lastReceivedId);
        }
      } while (count($results) > 0 );

    } catch (AfricasTalkingGatewayException $e) {
      $er = "Encountered an error while sending.Please check your internet connection ".$e->getMessage();
      array_push($this->_results,$er);
    }

  }

}




 ?>
