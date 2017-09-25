<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Legalizacion {

    private $db;
    private $table = 'ok1_leg';
    private $response;
    private $primary = 'EntryLegWeb';
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
    
    public function GetLegalizacionesAbiertas($data) {
        try {
            $result = array();
			$sql = "SELECT * FROM $this->table WHERE  EntryPerfilWeb = '".$data."' AND Estado like '%Abierto%' AND Cargado = 0";
			$stm = $this->db->prepare($sql);
            $stm->execute();
            //echo $sql; exit;
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    
     public function GetLegalizacionesMovil() {
        try {
            $result = array();
			$sql = "SELECT * FROM $this->table WHERE  Cargado = 3";
			$stm = $this->db->prepare($sql);
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    
     public function UpdateResSincroLegas($data) {		  
        try {
            $result = array();
            $sql = "DELETE FROM $this->table WHERE $this->primary = '" . $data[0]."'";
			 
            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);
            $this->response->result = 'true';
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
   

    public function Get($data) {
        try {
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE $this->primary = ?");
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


public function Getuna($data) {
        try {
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE $this->primary = ?");
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    public function GetLegalizacionEnviar($data) {
        try {
            $result = array();
			$sql = "SELECT * FROM $this->table WHERE  Descripcion = '".$data['descripcion']."' AND 
                                        EntryPerfilWeb = '".$data['entryPerfilMovil']."' AND Estado = '".$data['estado']."' AND
                                        IDLeg = '".$data['iDLeg']."' AND Valor = '".$data['valor']."' AND EntryLegMovil = '".$data['entryLegMovil']."'";
           
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
    
    
    public function UpdateValor($data) {
        
            $sql = "UPDATE $this->table SET 
                            Valor = ".$data['valor']."
                        WHERE $this->primary = ".$data['entryLegMovil'];
            //echo $sql; exit;
            $stm=$this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            //$this->response->result = $stm->fetch();
            return $this->response;
    }
    
    public function UpdateCargada($data) {
        
            $sql = "UPDATE $this->table SET 
                            Cargado = ".$data['cargado']."
                        WHERE $this->primary = ".$data['entryLegMovil'];
            //echo $sql; exit;
            $stm=$this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            //$this->response->result = $stm->fetch();
            return $this->response;
    }
    
    
    
    public function Update($data) {
        try {
            $sql = "UPDATE $this->table SET 
                            met_clave          = ?, 
                            met_nombre_db        = ?
                        WHERE $this->primary = ?";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['met_clave'],
                                $data['met_nombre_db'],
                                $data['met_usuario']
                            )
            );

            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function InsertWeb($data) {
	
	
		$random = $this->servicio->generateRandomString(6);

		  $sql = "SELECT Dimension2 FROM ok1_perf WHERE EntryPerfilWeb =".$data['entryPerfilMovil'];

            $stm = $this->db->prepare($sql);
			
            $stm->execute(array());
            $result = (array)$stm->fetch();
		
			if ($result['Dimension2']==='0' || $result['Dimension2']===0){
				$data['estado']='aprobado';
			}
		
		
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (Cargado, Descripcion, EntryPerfilWeb, Estado, IDLeg, NoAprobacion, Valor, EntryLegMovil, idTran)
                            VALUES ('".$data['cargado']."','".$data['descripcion']."','".$data['entryPerfilMovil']."','Abierto','".
                            $data['iDLeg']."','".$data['noAprobacion'] = $this->servicio->generateRandomString(6)
							."','". $data['valor']."','". $data['entryLegMovil']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";		
			/*$sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (Cargado, Descripcion, EntryPerfilWeb, Estado, FechaAutorizacion, FechaSincronizacion, IDLeg, NoAprobacion, Valor, EntryLegMovil, idTran)
                            VALUES ('".$data['cargado']."','".$data['descripcion']."','".$data['entryPerfilMovil']."','".$data['estado'].
							"',null,null,'". $data['iDLeg']."','".$data['noAprobacion'] = $this->servicio->generateRandomString(6)
							."','". $data['valor']."','". $data['entryLegMovil']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";		*/
				
            $this->db->prepare($sql)
                    ->execute(array());
            //array_push($data, 'insert');
            $this->response->setResponse(true,"Insertó con éxito");

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
    public function Insert($data) {
		
		$random = $this->servicio->generateRandomString(6);

		  $sql = "SELECT Dimension2 FROM ok1_perf WHERE EntryPerfilWeb =".$data['entryPerfilMovil'];

            $stm = $this->db->prepare($sql);
			
            $stm->execute(array());
            $result = (array)$stm->fetch();
		
			if ($result['Dimension2']==='0' || $result['Dimension2']===0){
				$data['estado']='aprobado';
			}
		
		
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (Cargado, Descripcion, EntryPerfilWeb, Estado, IDLeg, NoAprobacion, Valor, EntryLegMovil, idTran)
                            VALUES ('".$data['cargado']."','".$data['descripcion']."','".$data['entryPerfilMovil']."','".$data['estado'].
							"','". $data['iDLeg']."','".$data['noAprobacion'] = $this->servicio->generateRandomString(6)
							."','". $data['valor']."','". $data['entryLegMovil']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";		
			/*$sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (Cargado, Descripcion, EntryPerfilWeb, Estado, FechaAutorizacion, FechaSincronizacion, IDLeg, NoAprobacion, Valor, EntryLegMovil, idTran)
                            VALUES ('".$data['cargado']."','".$data['descripcion']."','".$data['entryPerfilMovil']."','".$data['estado'].
							"',null,null,'". $data['iDLeg']."','".$data['noAprobacion'] = $this->servicio->generateRandomString(6)
							."','". $data['valor']."','". $data['entryLegMovil']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";		*/
				
            $this->db->prepare($sql)
                    ->execute(array());
            //array_push($data, 'insert');
            $this->response->setResponse(true,"Insertó con éxito");

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Delete($data) {
        try {
            //print_r($data); exit;
            $stm = $this->db
                    ->prepare("DELETE FROM $this->table WHERE $this->primary = ?");

            $stm->execute(array($data));

            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
    
        public function GetTransaccion($data) {		
		 try {
            $result = array();
			$query = "SELECT * FROM $this->table WHERE idTran = ?";		
            $stm = $this->db->prepare($query);
            $stm->execute(array($data));
            $array_result = json_decode(json_encode($stm->fetch()), true);  			
            return $array_result;
        } catch (Exception $e) {
            
            return array("error");
        }
    }
	
	     public function GetAllSincronizacionSAP() {
        try {
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE Estado ='aprobado'" );
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


 public function GetEnviadosLegalizacion($data) {
        try {
            $result = array();

            $sql = "SELECT * FROM ok1_leg WHERE EntryLegWeb IN (" . $data . ") AND  SincronizacionSAP = 1";
            
			$stm = $this->db->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
            $result = (array) $result;
            return $result;
        } catch (Exception $e) {
            return '-1';
        }
    }      
    
    public function GetLegalizacionesWeb($data) {
        try {
            $result = array();

            $sql = "SELECT T1.*,T2.EntryPerfilMovil FROM ok1_leg AS T1 inner join ok1_perf AS T2 ON T1.EntryPerfilWeb = T2.EntryPerfilWeb WHERE Cargado = 3 AND Estado = 'Abierto' AND T2.EntryPerfilWeb IN (" . $data . ")";
            
			$stm = $this->db->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
            $result = (array) $result;
            return $result;
        } catch (Exception $e) {
            return '-1';
        }
    }  

}
