# opengates
A cluster of multiple SMS gateway services 

Current gateway supported is Africastalking http:africastalking.com

More will be added as development continues

Example code

<?php
include 'AutoLoad.php';
$num = array('254718376163','254718376164');
$msg = 'Lorem Ipsum is simply dummy text of the printing and
       typesetting industry. Lorem Ipsum has been the industry
       standard dummy text ever since the 1500s, when an unknown
       printer took a galley of type and scrambled it to make a
       type specimen book. It has survived not only five centuries,
       but also the leap into electronic typesetting, remaining
       essentially unchanged. It was popularised in the 1960s
       with the release of Letraset sheets containing Lorem Ipsum
       passages, and more recently with desktop publishing software
       like Aldus PageMaker including versions of Lorem Ipsum.';
$sms = new Autoload(); //create an instance
$sms->SendingMessage($num,$msg); //call this for sending sms
$sms->ReceivingMessage(); // call this for receiving sms
 ?>
