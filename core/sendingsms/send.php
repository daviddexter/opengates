<?php
require_once 'bin/reader.php';
require_once 'core/sendingsms/AppSending.php';
/**
 * class responsible for sending the text message
 */
class SenderAgent
{

  function __construct($phoneNumber,$textMessage)
  {
    $this->phoneNumber = $phoneNumber;
    $this->textMessage = $textMessage;
    $this->sendInit($this->phoneNumber,$this->textMessage);
  }

  private function sendInit($phoneNumber,$textMessage){
    //first we read the configuration from conf.ini file
    $config = new ConfigReader();
    if(sizeof($config->appConfig)!=0){
        $confParse = $config->appConfig[0]["APISEND"];
        //check config key_exists
        if(!array_key_exists("use",$confParse)){
            print('Use parameter is not defined in your conf.ini file');
        }else {
          $howToName = $confParse["name"]; //this is the name of gatway or kannel
          $howToUse = $confParse["use"]; //this is how to access the functions of the gateway or kannel
          $prefixed = $confParse["prefix"]; //if the phoneNumber should be prefixed or not
          $prefixedPhoneNumbers = array();
          if($prefixed === 'true'){
            foreach ($phoneNumber as $number) {
              $addPrefix = '+'.$number;
              array_push($prefixedPhoneNumbers,$addPrefix);
            }
          }else{
            foreach ($phoneNumber as $number) {
              array_push($prefixedPhoneNumbers,$number);
            }
          }
          $this->sendWith($howToName,$howToUse,$prefixedPhoneNumbers,$textMessage); //method to filter whether to use a class or url
        }

    }
  }

  private  function sendWith($howToName,$howToUse,$phoneNumber,$textMessage)
  {
    $className = '';
    $urlPath = '';
    switch ($howToUse) {
      case 'class':
        //read the class name from conf.ini file
        //first check if the classname was defined
        $config = new ConfigReader();
        $confParse = $config->appConfig[0]["APISEND"];
        if(!array_key_exists("classname",$confParse)){
          print('Classname parameter is not defined in your conf.ini file');
        }elseif ($confParse["classname"] === '') {
          print('Classname defined in your conf.ini file is empty');
        }else{
            $className = $confParse["classname"]; //parse the class name
            $apiname = strtolower($confParse["name"]); //parse the gateway/kannel name
        }
        //load the class
        $classFile = getcwd().'/api/'.$apiname.'/'.$className; //variable for the class from the filesystem
        //check if the file exists
        if(!file_exists($classFile)){
          print('file doesnt exist');
        }else {
          if(is_file($classFile)){$this->sendWithClass($howToName,$classFile,$phoneNumber,$textMessage);}
        }

        break;

      case 'url':
        //first check if the urlroute was defined;
        $config = new ConfigReader();
        $confParse = $config->appConfig[0]["APISEND"];
        if(!array_key_exists("urlroute",$confParse)){
          print('Urlroute parameter is not defined in your conf.ini file');
        }elseif ($confParse["classname"] === '') {
          print('Urlroute defined in your conf.ini file is empty');
        }else{
            $urlPath = $confParse["urlroute"];
        }
        $this->sendWithUrl($howToName,$urlPath,$phoneNumber,$textMessage);
        break;

      default:
        print('Usage not defined');
        break;
    }

  }

  private function sendWithClass($name,$class,$phoneNumber,$textMessage)
  {
      $apiCall = new AppSendingWithClass($name,$class,$phoneNumber,$textMessage); //instance for handling
      //the sending with a class

  }

  private function sendWithUrl($name,$urlPath,$phoneNumber,$textMessage)
  {
      $urlCall = new AppSendingWithURL($name,$urlPath,$phoneNumber,$textMessage); //instance for handling
      //the sending with a url
  }
}


?>
