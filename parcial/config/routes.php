<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioController;
use App\Controllers\MateriaController;
use App\Middlewares\ParametrosMiddleware;
use App\Middlewares\ValidaTokenMiddle;


return function ($app) {
    $app->group('/', function (RouteCollectorProxy $group) {
        $group->post('usuario', UsuarioController::class . ':add')->add(ParametrosMiddleware::class.':valUsuario');
        $group->post('login', UsuarioController::class . ':login')->add(ParametrosMiddleware::class.':valLogin');
        $group->post('materias', MateriaController::class . ':add')->add(ValidaTokenMiddle::class.':validaAdmin')->add(ParametrosMiddleware::class.':valMateria');
        $group->get('materias/{id}', MateriaController::class . ':getId')->add(ValidaTokenMiddle::class.':validaSoloToken');
        $group->put('materias/{id}/{profesor}', MateriaController::class . ':getIdProf')->add(ValidaTokenMiddle::class.':validaAdmin');
    });

};













?>