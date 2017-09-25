<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Company;

$app->get('/company/', function ($req, $res, $args) {
        $um = new Company();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/company_nit/{id}/{cod}', function ($req, $res, $args) {
        $um = new Company();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetNit(array($args['id'],$args['cod']))
            )
        );
    });
	
	$app->get('/company/{id}', function ($req, $res, $args) {
        $um = new Company();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['id'])
            )
        );
    });


$app->get('/GetEntryComWeb/{nit}/{cod}', function ($req, $res, $args) {
        $um = new Company();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetEntryComWeb(array($args['nit'],$args['cod']))
            )
        );
    });
    
$app->get('/GetECWandName/{nit}/{cod}', function ($req, $res, $args) {
        $um = new Company();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetECWandName(array($args['nit'],$args['cod']))
            )
        );
    });
	
$app->post('/company/', function ($req, $res) {
    $um = new Company();

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


$app->put('/company/', function ($req, $res) {
    $um = new Company();
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
    