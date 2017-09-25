<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class Factura {
	
    private $db;
    private $table = 'ok1_fact';
    private $response;
    private $primary = 'EntryFactWeb';

    public function __CONSTRUCT() {
        $this->db = Database::StartUp();
        $this->response = new Response();
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
    
    
    public function GetUnaFactura($data) {
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
    
    public function GetExiste($data) {
        try {
            $result = array();
            $sql = "SELECT * FROM $this->table WHERE Documento ='".$data[0]."' AND  Referencia = '".$data[1]."'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            $this->response->message = "Existe";
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    

    public function Update($data) {
        try {
            $sql = "UPDATE $this->table SET 
                            met_clave          = ?
                        WHERE $this->primary = ?";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['idLeg'],
                                $data['entryFactMovil'],
                                $data['entryFactWeb']
                            )
            );

            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Insert($data) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (EntryFactMovil, Fecha, IDLeg, Valor, Moneda, Referencia, Documento, TipoDoc, Adjunto, 
                            EntryLegalizacionSAP,ComentarioLine, SubTotalSinImpuesto, SubTotalImpuesto, NombreSN, IdTran)
                            VALUES ('".$data['entryFactMovil']."','". $data['fecha']."','".$data['iDLeg']."','". $data['valor']."',
							'".$data['moneda']."','".$data['referencia']."','".$data['documento']."','". $data['tipoDoc']."','". $data['adjunto']."',
							'".$data['lineLegSAP']."','". $data['comentarioLine']."','".$data['subTotalSinImpuesto']."','". $data['subTotalImpuesto']."',
							'".$data['nombreSN']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";
            $this->db->prepare($sql)
                    ->execute(array());
            array_push($data, 'insert');
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
    public function InsertWeb($data) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
							INSERT INTO $this->table
                            (EntryFactMovil, EntryLegWeb, EntryPerfilWeb, Fecha, IDLeg, Valor, Moneda, Referencia, Documento, TipoDoc, Adjunto, 
                            EntryLegalizacionSAP,ComentarioLine, SubTotalSinImpuesto, SubTotalImpuesto, NombreSN, IdTran)
                            VALUES ('".$data['entryFactMovil']."','". $data['entryLegMovil']."','". $data['entryPerfilMovil']."','". $data['fecha']."','".$data['iDLeg']."','". $data['valor']."',
							'".$data['moneda']."','".$data['referencia']."','".$data['documento']."','". $data['tipoDoc']."','". $data['adjunto']."',
							'".$data['lineLegSAP']."','". $data['comentarioLine']."','".$data['subTotalSinImpuesto']."','". $data['subTotalImpuesto']."',
							'".$data['nombreSN']."','".$data['idTransaccion']."');
					SET FOREIGN_KEY_CHECKS=1;";
            $this->db->prepare($sql)
                    ->execute(array());
            array_push($data, 'insert');
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
            $this->response->setResponse(true, 'true');
            $this->response->result = '1';
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            $this->response->result = '0';
        }
    }

    public function UpdateForaneas($data) {
        try {
            $sql = "UPDATE ok1_fact, (SELECT EntryLegWeb FROM ok1_leg WHERE idTran= " . $data['idTransaccion'] . ") t1
                SET ok1_fact.EntryLegWeb = t1.EntryLegWeb WHERE ok1_fact.idTran =" . $data['idTransaccion'];
								
            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse(true, 'true');
            $this->response->result = '1';
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            $this->response->result = '0';
        }
    }
    
    public function UpdateValor($data) {
        
            $sql = "UPDATE $this->table SET 
                            Valor = ".$data['valor']."
                        WHERE $this->primary = ".$data['entryFactMovil'];
            //echo $sql; exit;
            $stm=$this->db->prepare($sql);
            $stm->execute(array($data));
            $this->response->setResponse(true);
            //$this->response->result = $stm->fetch();
            return $this->response;
    }

    public function GetAllTransaccion($idTransaccion) {
        try {
			$result = array();
			$query = "SELECT * FROM $this->table WHERE idTran=".$idTransaccion;
		
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }
    
    public function GetAllLegalizacion($idLegalizacion) {
        try {
			$result = array();
			$query = "SELECT * FROM $this->table WHERE EntryLegWeb=".$idLegalizacion;
		
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }
    
    

 public function GetAllSincronizacionSAP($idLegalizacion) {
        try {
            $result = array();
            $query = "SELECT * FROM $this->table WHERE EntryLegWeb=".$idLegalizacion;		
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }
}
