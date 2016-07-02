<?php
namespace Test;

/**
 * Each class that extends this one will be async.
 *
 */
abstract class Task
{
   /**
    * @var \Stomp
    */
    public static $con;
    
   /**
    * This method will process the message async
    */
    public abstract function exec($message);
    
   /**
    * Common method for all async classes
    */
    public static function async($message, $delay=0)
    {   
        if (!self::$con)
            throw new Exception("Please inject Stomp connection first");
        
        // full qualified name of the caller class to handle the message
        // needed by the receiver to load the class
        $message["class"] = get_called_class();
        
        // add delay if needed to schedule the mesage
        $headers = array();
        if ($delay)
            $headers["AMQ_SCHEDULED_DELAY"] = $delay * 1000;
        
        // send it to ActiveMQ
        $message = serialize($message);
        self::$con->send("/queue/test",  $message,  $headers);
    }
}