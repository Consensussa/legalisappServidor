<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Tipo_Gto;

$app->get('/tipo_gto/', function ($req, $res, $args) {
        $um = new Tipo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/tipo_gto/{id}', function ($req, $res, $args) {
        $um = new Tipo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['id'])
            )
        );
    });
	
$app->post('/sincronizarTipoGto/', function ($req, $res, $args) {
    $um = new Tipo_Gto();
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

$app->get('/tiposGto/{id}', function ($req, $res, $args) {
        $um = new Tipo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetTipoAll($args['id'])
            )
        );
    });
    