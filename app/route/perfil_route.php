<?php
//header("Access-Control-Allow-Origin: *");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Perfil;

//$app->group('/base/', function () {


$app->get('/perfil/', function ($req, $res, $args) {
    $um = new Perfil();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->GetAll()
                            )
    );
});

$app->get('/perfil/{id}', function ($req, $res, $args) {
    $um = new Perfil();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->Get($args['id'])
                            )
    );
});

$app->get('/perfilesCompany/{id}', function ($req, $res, $args) {
    $um = new Perfil();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->GetAllCompany($args['id'])
                            )
    );
});

$app->post('/perfil/', function ($req, $res) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->Insert(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->put('/perfil/', function ($req, $res) {
    $um = new Perfil();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->Update(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->put('/perfilJoomla/', function ($req, $res) {
    $um = new Perfil();
    
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->UpdateJoomla(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->delete('/perfil/{id}', function ($req, $res, $args) {
    $um = new Perfil();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->Delete($args['id'])
                            )
    );
});

$app->post('/sincronizarPerfilSAP/', function ($req, $res, $args) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarPerfilSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

$app->post('/confirmarSincronizarPerfilSAP/', function ($req, $res, $args) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->confirmarSincronizarPerfilSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

$app->post('/sincronizarPerfilMovil/', function ($req, $res, $args) {
    $um = new Perfil();	
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->InsertPerfilMovil(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

$app->post('/actualizarPerfilSAP/', function ($req, $res, $args) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->actualizarPerfilSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});


    	
	$app->get('/perfilNombreWeb/{nombre}/{company}/', function ($req, $res, $args) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->GetNombreWeb(array($args['nombre'],$args['company']))
                            )
    );
});


$app->post('/sincronizarperfilesreq/', function ($req, $res, $args) {
    $um = new Perfil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarPerfilRequisicionSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

//}); 
