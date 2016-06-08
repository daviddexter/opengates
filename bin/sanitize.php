<?php
/**
 *Sanitize phone number by filtering out errors in input
 */
class Sanitizer
{
  public $errors_ = array ();

  function __construct($phoneNumber)
  {
    $this->phoneNumber = $phoneNumber;
    $this->sanitize($this->phoneNumber);
  }

  public function sanitize($pnum)
  {
    
    foreach ($pnum as $ns) {
      //check if the input is a string
      if(!is_string($ns)){array_push($this->errors_,'Phonenumber input should be a string at '.$ns.'' );}
      //check if the input string is digit
      if(!ctype_digit($ns)){array_push($this->errors_,'Phonenumber input string should contain only digits at '.$ns.'');};
      //check the length
      if(strlen($ns)!=12){array_push($this->errors_,'Phonenumber input length should be 12 characters at '.$ns.'');}
    }
  }

  public function MessageWrapper($msg)
  {
     return str_split($msg,160); //split into chunks of 160 characters
  }
}


?>
