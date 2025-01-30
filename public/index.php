<?php



require '../vendor/autoload.php';
require '../config/db.php';
require '../config/queue.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
$log = new Logger('debugger');
//$log->pushHandler(new FirePHPHandler());
$log->pushHandler(new StreamHandler(__DIR__.'/my_app.log', Level::Debug));
$log->info('My logger is now ready');
Flight::set('log',$log);
Flight::path(__DIR__.'/../');
Flight::set('flight.log_errors', true);
Flight::set('current_player_id', 2);
Flight::map('status', function (int $error,?string $details = '') {
    $json_codes = json_decode(file_get_contents(__DIR__.'/../config/codes.json'),true);
    $info = $json_codes[$error];
    $info['timestamp'] = date("Y-m-d H:i:s");
    $info['path'] = Flight::request()->url;
    $info['details'] = $details;
    Flight::jsonHalt($info,$error);
});

//change to a .env
Flight::set('pw', 'argh');

Flight::map('dump', function ($data) {
     echo '<pre>';
    print_r($data);
});




require '../config/routes.php';


Flight::start();
