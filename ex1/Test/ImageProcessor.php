<?php
namespace Test;
require_once "Task.php";


class ImageProcessor extends Task
{
   /**
    * This will be called async in the background
    * this is the actual method that will process the message
    */
    public function exec($message)
    {
        print "I am ImageProcessor " . $message["param1"];
    }
    
    // the rest of the code omitted
}