<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Leg_ConfMovil;

$app->get('/leg_confmovil/', function ($req, $res, $args) {
        $um = new Leg_ConfMovil();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
$app->get('/leg_confmovil/{id}', function ($req, $res, $args) {
        $um = new Leg_ConfMovil();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['id'])
            )
        );
    });
    
$app->post('/sincronizar_leg_confmovil_sap/', function ($req, $res, $args) {
    $um = new Leg_ConfMovil();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarLegConfMovilSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

    