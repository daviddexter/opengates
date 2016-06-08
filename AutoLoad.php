<?php
require 'bin/engine.php';
require 'bin/sanitize.php';
/**Autoload class for the application**/
class Autoload
{
  public function SendingMessage($phoneNumber,$textMessage)
  {
    //Responsible for sending messages
    //First we sanitize the phoneNumber
    //Call the sanitize class
    $cleaner = new Sanitizer($phoneNumber);
    $wrappedTextMessage = Sanitizer::MessageWrapper($textMessage); //method to wrap message into 160 characters
    if(sizeof($cleaner->errors_)==0){
      //call the sending message engine
      $sendingEngine = new AppSendEngine(array_unique($phoneNumber),$wrappedTextMessage);
    }else {
      foreach ($cleaner->errors_ as $error) {
        print($error."<br><br>");
      }
    }
  }

  public function ReceivingMessage()
  {
    //Responsible for ReceivingMessages
    //call the receiving message engine
    $receiveEngine = new AppReceiveEngine();

  }

}

?>
