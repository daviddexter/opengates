<?php
/**Read gateway configuration. From ini file or from database.
Preferably database.

Currently a file is used inplace of a database
 */
class ConfigReader{

  public $appConfig = array();
  function __construct()
  {
    $this->findConfig();
  }

  private function findConfig()
  {
    //check if config file exists
    $file = getcwd().'/conf.ini';
    if(!file_exists($file)){
      print('Configuration file does not exist');
    }else{
      //read the config file
      $fileRead = parse_ini_file($file);
      array_push($this->appConfig,$fileRead);

    }
  }

   public function findConfigAll($type)
  {
     $file = getcwd().'/conf.ini';
     $fileRead = parse_ini_file($file);
     $configParser = $fileRead[$type];
     if(!isset($configParser["apikey"]) || !isset($configParser["apiusername"])){
       die('API Key / API Username not set in your conf.ini file');
     }else{
        return $apiItems = array($configParser["apikey"],$configParser["apiusername"]);
     }
  }
}

?>
