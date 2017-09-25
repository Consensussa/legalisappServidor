<?php





/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

use App\Model\Impuestos_Cia;

/*

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

	*/

$app->post('/impuestos_Nube/', function ($req, $res, $args) {

    $um = new Impuestos_Cia();
    //print_r($req);exit;
    return $res

                    ->withHeader('Content-type', 'application/json')

                    ->getBody()

                    ->write(

                            json_encode(

                                    $um->sincronizarImpuestosNube(

                                            $req->getParsedBody()

                                    )

                            )

    );

	

});



$app->get('/impuestos_Nube/{id}', function ($req, $res, $args) {

        $um = new Impuestos_Cia();

        

        return $res

           ->withHeader('Content-type', 'application/json')

           ->getBody()

           ->write(

            json_encode(

                $um->GetTipoAll($args['id'])

            )

        );

    });

    