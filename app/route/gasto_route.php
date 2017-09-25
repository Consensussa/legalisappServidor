<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Gasto;

//$app->group('/base/', function () {
    
     
    $app->get('/gasto/', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/gasto/{id}/{user}', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get(array($args['id'], $args['user']))
            )
        );
    });
    
    $app->post('/gasto/', function ($req, $res) {
        $um = new Gasto();
        
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
    
    $app->post('/gastoWeb/', function ($req, $res) {
        $um = new Gasto();
        
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
    
    $app->put('/gasto/', function ($req, $res) {
        $um = new Gasto();
        
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
    
    $app->delete('/gasto/{id}', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });
    
     $app->get('/gasto/{id}', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAllTransaccion($args['id'])
            )
        );
    });
    
    $app->get('/gastosFactura/{id}', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAllgastosFactura($args['id'])
            )
        );
    });
    
    $app->get('/ungasto/{id}', function ($req, $res, $args) {
        $um = new Gasto();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetUno($args['id'])
            )
        );
    });
    
//}); 
