<?php
//require_once('Stomp.php');
require_once('Test/Mailer.php');

$con = new Stomp("tcp://localhost:61613");
//$con->connect();
$con->subscribe("/queue/test", array('activemq.prefetchSize'=>1));
//D:\XAMPP\htdocs\amq\ex1\PHP receiver.php
$i=0;

while (true)
{ 
    $aMsg = $con->readFrame();
    if ( $aMsg == null) 
        continue;
    
    print $i++ . " ";
    
    try
    {
        $msg = $aMsg->body;
        $msg = unserialize($msg);
        
        //TODO: this needs to be loaded with your framework auto loader
        // if bootstrapped properly no need for this
        $fqClassName = $msg["class"];
       require_once str_replace("\\", "/", $fqClassName) . ".php";
        
        // now when the async class is loaded, make new instance and call exec method
        $class = new $fqClassName();
        $class->exec($msg);
    }
    catch(Exception $err)
    {
            // do something
            print_r($err);
    }
    
    $con->ack($aMsg);
    
    print PHP_EOL;
}