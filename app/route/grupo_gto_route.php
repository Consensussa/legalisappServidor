<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Grupo_Gto;

$app->get('/grupo_gto/', function ($req, $res, $args) {
        $um = new Grupo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/grupo_gto/{id}', function ($req, $res, $args) {
        $um = new Grupo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['id'])
            )
        );
    });
	
	
$app->post('/sincronizarGrupoGtoSAP/', function ($req, $res, $args) {
    $um = new Grupo_Gto();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->sincronizarGrupoGtoSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

$app->post('/actualizarGrupoGtoSAP/', function ($req, $res, $args) {
    $um = new Grupo_Gto();
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode(
                                    $um->actualizarGrupoGtoSAP(
                                            $req->getParsedBody()
                                    )
                            )
    );
	
});

$app->get('/gruposGto/{id}', function ($req, $res, $args) {
        $um = new Grupo_Gto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetGrupoAll($args['id'])
            )
        );
    });

