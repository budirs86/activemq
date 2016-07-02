<?php

$queue  = '/queue/mudit_queue';

/* connection */
try {
    $stomp = new Stomp('tcp://localhost:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$stomp->subscribe($queue);

/* read a frame */
 if ($stomp->hasFrame()) {
			$frame = $stomp->readFrame();

		//if ($frame->body === $msg) {
			echo "<pre>";
			print_r($frame);
			echo "</pre>";

			/* acknowledge that the frame was received */
			$stomp->ack($frame);
		//}
  }else
  {
	  echo "no msg frame found";
  }

/* close connection */
unset($stomp);

?>