<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Legalizacion;

//$app->group('/base/', function () {
    
     
    $app->get('/legalizacion/', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/legalizacion/{id}/{user}', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get(array($args['id'], $args['user']))
            )
        );
    });
    
    $app->get('/GetLegasAbiertas/{entryPerfilMovil}', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetLegalizacionesAbiertas($args['entryPerfilMovil'])
            )
        );
    });
    
    $app->get('/GetLegasMovil/', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetLegalizacionesMovil()
            )
        );
    });
    
    $app->post('/legalizacion/', function ($req, $res) {
        $um = new Legalizacion();
        
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
    
    $app->post('/legalizacionWeb/', function ($req, $res) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->InsertWeb(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    $app->put('/legalizacion/', function ($req, $res) {
        $um = new Legalizacion();
        
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
    
    $app->put('/legalizacionValor/', function ($req, $res) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->UpdateValor(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    
    $app->put('/legalizacionCargada/', function ($req, $res) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->UpdateCargada(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    $app->delete('/legalizacion/{id}', function ($req, $res, $args) {
        $um = new Legalizacion();
        //print_r($args);exit;
       // echo $args; exit;
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });
    
    
    
        $app->get('/legalizacion/{id}', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetTransaccion($args['id'])
            )
        );
    });
    
    $app->get('/unalegalizacion/{id}', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Getuna($args['id'])
            )
        );
    });
    
    $app->get('/resSincroLegas/{id}/{dato}', function ($req, $res, $args) {
        $um = new Legalizacion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->UpdateResSincroLegas(array($args['id'], $args['dato']))
            )
        );
    });
    
   
    
//}); 
