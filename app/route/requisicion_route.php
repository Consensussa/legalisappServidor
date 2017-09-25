<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Requisicion;

//Metodo que indica la ruta del servicio y el método solicitado correspondiente a obtener todos los registros 
$app->get('/requisicion/', function ($req, $res, $args) {
        $um = new Requisicion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    //Metodo que indica la ruta del servicio y el método solicitado correspondiente a obtener la maxima fecha de la tabla 
    $app->get('/maxrequisicion/{data}', function ($req, $res, $args) {
        $um = new Requisicion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetMax($args['data'])
            )
        );
    });
    
    //Metodo que indica la ruta del servicio y el método solicitado correspondiente a obtener un registro en especifico 
    $app->get('/requisicionitems/{data}', function ($req, $res, $args) {
        $um = new Requisicion();       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetItems($args['data'])
            )
        );
    });
    
//Metodo que indica la ruta del servicio y el método solicitado correspondiente a insertar el registro entrante 
$app->post('/requisicion/', function ($req, $res, $args) {
    $um = new Requisicion();
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode($um->sincronizarData($req->getParsedBody()))
    );
	
});


  
    $app->get('/resSincroAprobacion/{id}/{dato}', function ($req, $res, $args) {
        $um = new Requisicion();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->UpdateResSincroAprobacion(array($args['id'], $args['dato']))
            )
        );
    });
	
	 $app->get('/requisicionStock/{id}/{dato}', function ($req, $res, $args) {
        $um = new Requisicion(); 
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetStock(array($args['id'], $args['dato']))
            )
        );
    });
	
	$app->post('/sincronizarItemsSAP/', function ($req, $res, $args) {
    $um = new Requisicion();
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode($um->sincronizarItemsSAP($req->getParsedBody()))
    );
	
});

$app->post('/getItemsWs/', function ($req, $res, $args) {
    $um = new Requisicion();
	
    return $res
                    ->withHeader('Content-type', 'application/json')
                    ->getBody()
                    ->write(
                            json_encode($um->GetItemsWs($req->getParsedBody()))
    );
	
});

	
   