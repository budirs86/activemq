Requiremens
    PHP version >= 5.3
    ActiveMQ
    
Open new console and run the receiver:
    php receiver.php

While the receiver is startes send some async tasks
    php sender.php
    
The receiver should process the messages and print output.    
    