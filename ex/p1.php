<?php

function msg($txt)
{
    echo date('H:i:s > ').$txt."\n";
}
$argv=array('mmt','hello mmt',5);
//$queue  = '/aaaa';
$queue  = 'mudit_i_done_it';
//$msg    = 'bar';
if (count($argv)<3) {
    echo $argv[0]." [msg] [nb to send]\n";
    exit(1);
}
$msg     = (string)$argv[1];
$to_send = intval($argv[2]);

try {
    $stomp = new Stomp('tcp://localhost:61613');
    while (--$to_send) {
        msg("Sending...");
        $result = $stomp->send(
            $queue,
            $msg." ". date("Y-m-d H:i:s"),
            array('receipt' => 'message-123')
        );
        echo 'result='.var_export($result,true)."\n";
        msg("Done.");
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>