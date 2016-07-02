<?php

$queue  = '/queue/mudit_queue';
$msg    = 'hello mudit test message';

/* connection */
try {
    $stomp = new Stomp('tcp://localhost:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

/* send a message to the queue 'foo' */
if($stomp->send($queue, $msg))
{
	echo $msg.'sent';
}
else
{
	echo 'not sent';
}
unset($stomp);
?>