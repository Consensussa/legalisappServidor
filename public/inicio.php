<?php
//header("Access-Control-Allow-Origin: *");
function sendPost($datos) {
    
    //datos a enviar
    $data = array("data" => $datos);
    //url contra la que atacamos
    $ch = curl_init("http://localhost/legalisapp/public/base/");
    //a true, obtendremos una respuesta de la url, en otro caso, 
    //true si es correcto, false si no lo es
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //establecemos el verbo http que queremos utilizar para la petición
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //enviamos el array data
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //obtenemos la respuesta
    $response = curl_exec($ch);
    
    print_r($response);
    
    // Se cierra el recurso CURL y se liberan los recursos del sistema
    
    
    curl_close($ch);
    if (!$response) {
        return $response;
    }
}


$existe = sendPost('{"perfiles":[{"sincronizado":"0","entryPerfilMovil":"1","entryPerfilWeb":"555","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"2","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"3","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"4","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"5","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"6","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"7","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"8","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"9","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"10","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"11","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"12","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"13","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"14","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"15","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"16","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"17","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"18","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"19","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"20","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"21","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"22","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"23","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"24","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"25","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"26","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"27","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"28","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"29","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"30","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"31","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"32","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"33","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"34","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"35","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"36","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"37","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"38","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"39","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"40","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"41","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"42","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"43","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"44","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"45","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"46","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"47","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"48","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"49","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"50","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"51","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"52","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"53","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"54","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"55","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"56","entryPerfilWeb":"1","docPerfil":"1","perfil":"PER01","proyecto":"1","sn":"Consensus","company":"1","aprobador":"crojas@consensussa.com","dimension1":"1","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"57","entryPerfilWeb":"null","docPerfil":"1","perfil":"cam","proyecto":"1","sn":"1","company":"2","aprobador":"4","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"58","entryPerfilWeb":"null","docPerfil":"1","perfil":"cam","proyecto":"1","sn":"1","company":"2","aprobador":"4","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"59","entryPerfilWeb":"null","docPerfil":"1","perfil":"cam","proyecto":"1","sn":"1","company":"2","aprobador":"4","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"60","entryPerfilWeb":"null","docPerfil":"1053816943","perfil":"CR","proyecto":"1","sn":"1","company":"888888","aprobador":"prueba@consensussa.com","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"61","entryPerfilWeb":"null","docPerfil":"2","perfil":"jorge","proyecto":"1","sn":"1","company":"2","aprobador":"2","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"62","entryPerfilWeb":"null","docPerfil":"888","perfil":"frog","proyecto":"1","sn":"1","company":"999","aprobador":"rrrrrr","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"},{"sincronizado":"0","entryPerfilMovil":"63","entryPerfilWeb":"null","docPerfil":"000","perfil":"rtx","proyecto":"1","sn":"1","company":"000","aprobador":"actualizo@b.com","dimension1":"0","dimension2":"0","dimension3":"0","dimension4":"0","dimension5":"0"}],"legalizaciones":[{"sincronizado":"0","entryLegMovil":"7","cargado":"0","descripcion":"1","entryPerfilMovil":"1","estado":"Abierto","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"1","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"8","cargado":"0","descripcion":"Leg2","entryPerfilMovil":"60","estado":"Abierto","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"2","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"9","cargado":"0","descripcion":"Leg3","entryPerfilMovil":"60","estado":"Pendiente","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"3","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"10","cargado":"0","descripcion":"Leg4","entryPerfilMovil":"60","estado":"Enviado","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"4","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"11","cargado":"0","descripcion":"Leg5","entryPerfilMovil":"60","estado":"Aprobado","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"5","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"12","cargado":"0","descripcion":"Leg6","entryPerfilMovil":"60","estado":"Pendiente","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"6","noAprobacion":"0","valor":"10","entryLegWeb":"0"},{"sincronizado":"0","entryLegMovil":"13","cargado":"0","descripcion":"Leg7","entryPerfilMovil":"60","estado":"Abierto","fechaAutorizacion":"01-01-2016","fechaSincronizacion":"01-01-2016","iDLeg":"7","noAprobacion":"0","valor":"10","entryLegWeb":"0"}]}'
);


