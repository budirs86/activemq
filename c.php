<?php
ini_set('MAX_EXECUTION_TIME', -999999);
$queue  = '/topic/mudit';

try {
    $stomp = new Stomp('tcp://localhost:61613');
    $stomp->subscribe($queue);
    while (true) {
       if ($stomp->hasFrame()) {
           $frame = $stomp->readFrame();
           if ($frame != NULL) {
               print "Received: " . $frame->body . " - time now is " . date("Y-m-d H:i:s"). "\n";
               $stomp->ack($frame);
           }
//       sleep(1);
       }
       else {
           print "No frames to read\n";
       }
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

?>