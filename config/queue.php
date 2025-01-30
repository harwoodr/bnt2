<?php
use Enqueue\Fs\FsConnectionFactory;
//$context = $connectionFactory->createContext();

Flight::map('context', function () {
    //only stores in /tmp - needs to change for production
    return (new FsConnectionFactory())->createContext();

});