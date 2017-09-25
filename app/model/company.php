<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Company {

    private $db;
    private $table = 'ok1_company';
    private $response;
    private $primary = 'EntryComWeb';
	private $key= '123456789012345678901234';
    private $iv='password';
	private $servicio;

    public function __CONSTRUCT() {
        $this->db = Database::StartUp();
        $this->response = new Response();
        $this->servicio = new Servicio();
    }

    public function GetAll() {
        try {
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table");
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function Get($data) {
        try {
            $result = array();
			$sql= "SELECT * FROM $this->table WHERE $this->primary = ". $data;
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


    public function GetNit($data) {
        try {
            $result = array();
			$sql= "SELECT * FROM $this->table WHERE Nit = '". $data[0]."' AND codigoVerificacion='".$data[1]."'";
			//echo $sql;exit;
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


    public function GetEntryComWeb($data) {
        try {
            $result = array();
            $sql= "SELECT EntryComWeb FROM $this->table WHERE Nit = '". $data[0]."' AND codigoVerificacion='".$data[1]."'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    
    public function GetECWandName($data) {
        try {
            $result = array();
            $sql= "SELECT EntryComWeb, NombreCompany FROM $this->table WHERE Nit = '". $data[0]."' AND codigoVerificacion='".$data[1]."'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


    public function Update($data) {
        try {
            $sql = "UPDATE $this->table SET
                            Nit = ?
                        WHERE $this->primary = ?";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['Nit'],
                                $data['DocEntryCompany']
                            )
            );

            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Delete($data) {
        try {
            $stm = $this->db
                    ->prepare("DELETE FROM $this->table WHERE $this->primary = ?");

            $stm->execute(array($data));

            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }


	public function Insert($data) {

	$data['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(),$data['Nit']);

	$data['Nit'] = $this->servicio->limpiarCadena($data['Nit']);

	$data['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nombre']);
    $data['Nombre'] = $this->servicio->limpiarCadena($data['Nombre']);

	$data['NombreCompany'] = $this->descifrar($this->servicio->getKey(), $this->servicio->getIv(),$data['NombreCompany']);
    $data['NombreCompany'] = $this->servicio->limpiarCadena($data['NombreCompany']);

    

        try {
            $result = array();
			$codigoVerificacion =  $this->generateRandomString(6);
            $sql;
            $stm;

		  if (($data['CodigoVerificacion'] !==null && $data['CodigoVerificacion'] !=='') || ($data['DocEntryCompany'] !==null && $data['DocEntryCompany'] !=='')){
            
			$data['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['CodigoVerificacion']);
			$data['CodigoVerificacion'] = $this->servicio->limpiarCadena($data['CodigoVerificacion']);
			$data['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['DocEntryCompany']);
            $data['DocEntryCompany'] = $this->servicio->limpiarCadena($data['DocEntryCompany']);
            
            $sql = "SELECT COUNT(*) as existe FROM ok1_company c WHERE c.NombreCompany = '" . $data['NombreCompany']."' AND c.Nit = '".$data['Nit']."'";
            
            /*

			$sql = "SELECT * FROM ok1_company c WHERE c.EntryComWeb = " . $data['DocEntryCompany'];*/
            


			$stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array)$result;

            if ($result['existe']!=='0'){
                $sql = "SELECT COUNT(*) as existe1 FROM ok1_company c WHERE c.NombreCompany = '" . $data['NombreCompany']."' AND c.Nit = '".$data['Nit']."' AND c.EntryComWeb = " . $data['DocEntryCompany']." AND c.CodigoVerificacion = '". $data['CodigoVerificacion']."'";
                //echo $sql;exit;
                /*
    
                $sql = "SELECT * FROM ok1_company c WHERE c.EntryComWeb = " . $data['DocEntryCompany'];*/
                
    
    
                $stm = $this->db->prepare($sql);
                $stm->execute(array());
                $result = $stm->fetch();
                $result = (array)$result;
                if ($result['existe1']!=='0'){
                    $this->response->setResponse('0', 'Ya existe en BD');
                    $this->response->result = 'false';
                    return $this->response;
                }else{
                    $this->response->setResponse('2', 'Desea actualizar Nit');
                    $this->response->result = 'false';
                    return $this->response;
                }

            }
            
            /*
			if ($data['Nit']!== $result['Nit']){
				$this->response->setResponse('2', 'Desea actualizar Nit');
				$this->response->result = 'false';
                return $this->response;

			}else if ($data['Nombre']!== $result['Nombre']){
				$sql = " INSERT INTO ok1_company (Nit, Nombre, CodigoVerificacion, NombreCompany) VALUES ('" . $data['Nit'] . "','" . $data['Nombre'] . "','" . $codigoVerificacion . "','" . $data['NombreCompany'] . "')";
                $stm = $this->db->prepare($sql);
                $stm->execute(array());
				$result =$this->db->lastInsertId();
                $resultCifrado= $this->cifrar($this->key,$this->iv,$result);
				$codigoVerificacionCifrado= $this->cifrar($this->key,$this->iv,$codigoVerificacion);
                $resId='{"DocEntryCompany":"' . $resultCifrado . '","CodigoVerificacion":"' . $codigoVerificacionCifrado . '"}';
                $this->response->setResponse('1', $resId);
				$this->response->result = 'true';
                return $this->response;
			}else{
				$this->response->setResponse('0', 'Ya existe en BD');
				$this->response->result = 'false';
                return $this->response;
			}*/
		  }
		  else{
          $sql = "SELECT '1' as valor FROM ok1_company c WHERE c.Nombre = '" . $data['Nombre'] . "' AND c.Nit = '" . $data['Nit'] . "'";
          
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array)$result;

		  if ($result['valor'] !== '1') {
                $sql = " INSERT INTO ok1_company (Nit, Nombre, CodigoVerificacion, NombreCompany) VALUES ('" . $data['Nit'] . "','" . $data['Nombre'] . "','" . $codigoVerificacion . "','" . $data['NombreCompany'] . "')";

				$stm = $this->db->prepare($sql);
                $stm->execute(array());
				$result =$this->db->lastInsertId();
				$resultCifrado= $this->cifrar($this->key,$this->iv,$result);
				$codigoVerificacionCifrado= $this->cifrar($this->key,$this->iv,$codigoVerificacion);
                $resId='{"DocEntryCompany":"' . $resultCifrado . '","CodigoVerificacion":"' . $codigoVerificacionCifrado . '"}';
                $this->response->setResponse('1', $resId);
				$this->response->result = 'true';
                return $this->response;
            }else{
				$this->response->setResponse('0', 'Ya existe en BD');
				$this->response->result = 'false';
                return $this->response;
			}
		}
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            $this->response->result = 'false';
            return $this->response;
        }
    }

	public function descifrar($key,$iv,$data){
		if (strlen($key)!=24){
			echo "La longitud de la key ha de ser de 24 dígitos.<br>";
			return -1;
		}
		if ((strlen($iv) % 8 )!=0){
			echo "La longitud del vector iv ha de ser múltiple de 8 dígitos.<br>";
			return -2;
		}
		return @mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($data), MCRYPT_MODE_CBC, $iv);
	}

	function cifrar($key,$iv,$data){
      return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $data, MCRYPT_MODE_CBC, $iv));
 }


	public function limpiarCadena($cadena) {
     return (ereg_replace('[^ A-Za-z0-9_-ñÑ\-]', '', $cadena));
}

	function generateRandomString($length = 10) {
  $characters = '0123456789';
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $randomString;
}

}

?>
