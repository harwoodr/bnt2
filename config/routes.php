<?php

use App\Utility;
$router = Flight::router();
$router->group('/', function($router) {
    $router->get('', function () {
        echo 'hello world!';

    });
    $router->get('info', function () {
        phpinfo();
    });


    //($seed = 0, $numSectors = 1000, $linksPerSector = 3, $numPorts = 100, $numPlanets = 100)
    $router->get('createUniverse', function () {
        $request = Flight::request();
        if($request->query['pw'] == Flight::get('pw')) {
            $universe = new App\Utility\createUniverse();
            $queryVals = array ('seed', 'numSectors', 'linksPerSector', 'numPorts', 'numPlanets');
            foreach ($queryVals as $queryVal) {
                if (isset($request->query[$queryVal])) {
                    $universe->$queryVal = $request->query[$queryVal];
                }
            }
            $universe->genesis();
            echo "done";
        } else {
            echo "incorrect password" . $request->query['pw'];
        }

    });









    // resources go below here

    Flight::resource('commodity',\App\Controller\commodityController::class, [ 'only' => [ 'index', 'show' ] ]);
    Flight::resource('port',\App\Controller\shipController::class, [ 'only' => [ 'index', 'show' ] ]);
    Flight::resource('sector',\App\Controller\sectorController::class, [ 'only' => [ 'index', 'show' ] ]);

    Flight::resource('device',\App\Controller\deviceController::class, [ 'only' => [ 'index', 'show', 'update', 'destroy' ] ]);

    Flight::resource('event',\App\Controller\eventController::class, ['except' => [ 'create', 'edit', 'update']]);
    Flight::resource('fleet',\App\Controller\fleetController::class, ['except' => [ 'create', 'edit']]);
    Flight::resource('invite',\App\Controller\inviteController::class, ['except' => [ 'create', 'edit']]);
    Flight::resource('planet',\App\Controller\planetController::class, ['except' => [ 'create', 'edit']]);
    Flight::resource('program',\App\Controller\programController::class, ['except' => [ 'create', 'edit']]);
    Flight::resource('ship',\App\Controller\shipController::class, ['except' => [ 'create', 'edit']]);
    Flight::resource('team',\App\Controller\teamController::class, ['except' => [ 'create', 'edit']]);



});