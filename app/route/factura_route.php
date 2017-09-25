<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Factura;

//$app->group('/base/', function () {
    
     
    $app->get('/factura/', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $app->get('/factura/{id}/{user}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get(array($args['id'], $args['user']))
            )
        );
    });
    
    $app->get('/unafactura/{id}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetUnaFactura($args['id'])
            )
        );
    });
    
    
    
    $app->get('/facturaExiste/{doc}/{ref}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetExiste(array($args['doc'], $args['ref']))
            )
        );
    });
    
    $app->post('/factura/', function ($req, $res) {
        $um = new Factura();
        
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
    
    $app->post('/facturaWeb/', function ($req, $res) {
        $um = new Factura();
        
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
    
    $app->put('/factura/', function ($req, $res) {
        $um = new Factura();
        
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
    
    $app->put('/facturaValor/', function ($req, $res) {
        $um = new Factura();
        
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
    
    $app->delete('/factura/{id}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });
    
      
        $app->get('/factura/{id}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAllTransaccion($args['id'])
            )
        );
    });
    
    $app->get('/facturaLegalizacion/{id}', function ($req, $res, $args) {
        $um = new Factura();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAllLegalizacion($args['id'])
            )
        );
    });
    
    
//}); 
