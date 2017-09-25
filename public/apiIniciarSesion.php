<?php


function sendPost($datos) {
   //datos a enviar
    $data = array("data" => $datos);
	
    //url contra la que atacamos
    $ch = curl_init("http://legalisapp.com/legalisappServidor/public/iniciarSesion/");
    //a true, obtendremos una respuesta de la url, en otro caso, 
    //true si es correcto, false si no lo es
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //establecemos el verbo http que queremos utilizar para la petición
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //enviamos el array data
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //obtenemos la respuesta
    $response = curl_exec($ch);
   
    // Se cierra el recurso CURL y se liberan los recursos del sistema
  
    curl_close($ch);
    if (!empty($response)) {
        
        return $response;
    } 
	else{
		return 'else'; 
	}
}

	//http://stackoverflow.com/questions/18382740/cors-not-working-php
	if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
	if (isset($postdata)) {       
            				
		$request = json_decode($postdata);      
                
        $res=sendPost($request);
		 echo $res; 
		
	}
	else {
		echo "Not called properly with username parameter!";
	}

        
