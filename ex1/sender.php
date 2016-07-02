<?php
//require_once('Stomp.php');
require_once('Test/Mailer.php');
require_once('Test/ImageProcessor.php');
require_once('Test/Task.php');

use \Test\Task;
use \Test\Mailer;
use \Test\ImageProcessor;

// make the connection in your bootstrap
$con = new Stomp("tcp://localhost:61613");
//$con->connect();

// Inject the connection
// Use some DI container
Task::$con = $con;


// do some async mails (will be processed with Mailer->exec())
for($i=0; $i<10; $i++)
    Mailer::async(array("param1"=>"Message $i"));
    
// do some async image processins (will be processed with ImageProcessor->exec())    
for($i=0; $i<10; $i++)
    ImageProcessor::async(array("param1"=>"Message $i"));
    
// send it with delay of 10 sec    
Mailer::async(array("param1"=>"Message delayed 10 sec"), 10);