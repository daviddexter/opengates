<?php
require_once 'bin/reader.php';
require_once 'core/receivingsms/AppReceiving.php';

/**
 *
 */
class ReceiveAgent
{

  function __construct()
  {
    $this->receiveInit();
  }

  private function receiveInit()
  {
    //first we read the configuration from conf.ini file
    $config = new ConfigReader();
    if(sizeof($config->appConfig)!=0){
        $confParse = $config->appConfig[0]["APIRECEIVE"];
        //check config key_exists
        if(!array_key_exists("use",$confParse)){
            print('Use parameter is not defined in your conf.ini file');
        }else {
          $howToName = $confParse["name"]; //this is the name of gatway or kannel
          $howToUse = $confParse["use"]; //this is how to access the functions of the gateway or kannel
          $this->receiveWith($howToName,$howToUse); //method to filter whether to use a class or url
        }

    }
  }

  private function receiveWith($howToName,$howToUse)
  {
    $className = '';
    $urlPath = '';

    switch ($howToUse) {
      case 'class':
        //read the class name from conf.ini file
        //first check if the classname was defined
        $config = new ConfigReader();
        $confParse = $config->appConfig[0]["APIRECEIVE"];
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
          if(is_file($classFile)){$this->receiveWithClass($howToName,$classFile);}
        }

        break;

      case 'url':
        //first check if the urlroute was defined;
        $config = new ConfigReader();
        $confParse = $config->appConfig[0]["APIRECEIVE"];
        if(!array_key_exists("urlroute",$confParse)){
          print('Urlroute parameter is not defined in your conf.ini file');
        }elseif ($confParse["classname"] === '') {
          print('Urlroute defined in your conf.ini file is empty');
        }else{
            $urlPath = $confParse["urlroute"];
        }
        $this->receiveWithUrl($howToName,$urlPath);
        break;

      default:
        print('Usage not defined');
        break;
    }

  }

  public function receiveWithClass($name,$class)
  {
    $apiCall = new AppReceiveWithClass($name,$class); //instance for handling
    //the receiving with a class
  }

  public function receiveWithUrl($name,$url)
  {
    $apiCall = new AppReceiveWithUrl($name,$url); //instance for handling
    //the receiving with a url
  }
}




?>
