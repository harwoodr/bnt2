<?php
//$db =  new mysqli('db', 'root', 'root_password', 'newgame');
#$db =  new PDO('mysql:host=localhost;dbname=newgame&charset=utf8bm4', 'root', 'root_password');

//Flight::register('db', 'PDO', [ 'mysql:host=db;dbname=bnt2', 'root', 'root_password' ]);
//change to .env
Flight::register('db', \flight\database\PdoWrapper::class, [ 'mysql:host=db;dbname=bnt2', 'root', 'root_password' ]);

