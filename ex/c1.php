<?php

//$queue  = '/aaaa';
$queue  = 'mudit_i_done_it';
$_waitTimer=5000000;
$_timeLastAsk = microtime(true);

function msg($txt)
{
    echo date('H:i:s > ').$txt."\n";
}

try {
    $stomp = new Stomp('tcp://localhost:61613');
    $stomp->subscribe($queue, array('activemq.prefetchSize' => 40));
    $stomp->setReadTimeout(0, 10000);
    while (true) {
        $frames_read=array();
        while ($stomp->hasFrame()) {
            $frame = $stomp->readFrame();
            if ($frame != null) {
                array_push($frames_read, $frame);
            }
            if (count($frames_read)==40) {
                break;
            }
        }
        msg("Nombre de frames lues : ".count($frames_read));
        msg("Pause...");
        $e=$_waitTimer-(microtime(true)-$_timeLastAsk);
        if ($e>0) {
            usleep($e);
        }
        if (count($frames_read)>0) {
            msg("Ack now...");
            foreach ($frames_read as $frame) {
                $stomp->ack($frame);
            }
        }
        $_timeLastAsk = microtime(true);
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}