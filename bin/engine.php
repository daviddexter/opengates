<?php
require 'core/sendingsms/send.php';
require 'core/receivingsms/receive.php';
/**Core text sending or receiving engines
 */

 /**
  *Engine for sending messages
  */
class AppSendEngine
{

  function __construct($phoneNumber,$textMessage)
  {
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->sendMsg($this->phoneNumber,$this->textMessage);
  }

  protected function sendMsg($pN,$tM)
  {
    //call the instance agent Responsible for sending sms
    //parse the phoneNumber and textMessage
    $agent = new SenderAgent($pN,$tM);
  }
}

/**
 *Engine for receiving messages
 */
class AppReceiveEngine
{

  function __construct()
  {
    $this->receiveMsg();
  }

  protected function receiveMsg()
  {
    //call the instance agent responsible for receiving sms
    $agent = new ReceiveAgent();

  }
}


?>
