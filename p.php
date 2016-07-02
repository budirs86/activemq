<?php
ini_set('MAX_EXECUTION_TIME', -999996);
$queue  = '/topic/mudit';
$msg    = 'hello tyagi ji';
/*print_r($argv);
 if ($argv[1] != NULL) {
   $msg = $argv[1];
} */

try {
    $stomp = new Stomp('tcp://localhost:61613');
    while (true) {
      $stomp->send($queue, $msg." ". date("Y-m-d H:i:s"));
      sleep(1);
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

?>