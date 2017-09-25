<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Metadatos;

//$app->group('/base/', function () {


$app->post('/base/', function ($req, $res) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->InsertOrUpdate(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->post('/base_legalizacion/', function ($req, $res) {
    $um = new Metadatos();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->InsertOrUpdateLegalizacion(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->get('/transaccion/', function ($req, $res, $args) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->invocarSecuencia('seq_transaccion')
                            )
    );
});

 $app->get('/aprobar/{idleg}/{nap}/', function ($req, $res, $args) {
        $um = new Metadatos();     

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
			$um->verificarAprobacion(array($args['idleg'],$args['nap']))
            )
        );
    });
    
$app->get('/aprobar/{idleg}/{nap}', function ($req, $res, $args) {
        $um = new Metadatos();     

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
			$um->verificarAprobacion(array($args['idleg'],$args['nap']))
            )
        );
    });



$app->post('/sincronizarLineasSap/', function ($req, $res, $args) {
    $um = new Metadatos();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->post('/confirmarSincronizarLineasSap/', function ($req, $res, $args) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->confirmarSincronizacionLineas(
                                            $req->getParsedBody()
                                    )
                            )
    );
});


$app->get('/reenviar/{idleg}', function ($req, $res, $args) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->reenviarEmail($args['idleg'])
                            )
    );
});


$app->post('/base_requisicion/', function ($req, $res) {
	
    $um = new Metadatos();
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->InsertOrUpdateRequisicion(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->get('/transaccionReq/', function ($req, $res, $args) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->invocarSecuencia('seq_tranreq')
                            )
    );
});

$app->post('/requisicionAprobacion/', function ($req, $res) {
	
    $um = new Metadatos();
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->InsertOrUpdateRequisicionAprobacion(
                                            $req->getParsedBody()
                                    )
                            )
    );
});


$app->post('/sincronizarLineasReqSap/', function ($req, $res, $args) {
    $um = new Metadatos();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarLineasReqSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->post('/confirmarSincronizarLineasReqSap/', function ($req, $res, $args) {
    $um = new Metadatos();

    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->confirmarSincronizacionLineasReq(
                                            $req->getParsedBody()
                                    )
                            )
    );
});

$app->post('/sincronizarDatosConexion/', function ($req, $res, $args) {
    $um = new Metadatos();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarDatosConexion(
                                            $req->getParsedBody()
                                    )
                            )
    );
});



//}); 
