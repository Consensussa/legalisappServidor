<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class Gasto {

    private $db;
    private $table = 'ok1_gto';
    private $response;
    private $primary = 'EntryGastoWeb';

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
    
    public function GetUno($data) {
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

    public function Insert($data) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;		
							INSERT INTO $this->table
                            (EntryFactWeb, IdGasto, Impuesto, Info1, Info2, Info3, EntryTipoGto, Valor, EntryGastoMovil, Notas, IdTran)
                            VALUES ('".$data['entryFactMovil']."','". $data['idGasto']."','".$data['impuesto']."','". $data['info1']."',
							'". $data['info2']."','". $data['info3']."','".$data['tipoGasto']."','".$data['valor']."','".$data['entryGastoMovil']."',
							'".$data['notas']."', '". $data['idTransaccion']."');
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
                            (EntryFactWeb, EntryLegWeb, EntryPerfilWeb, IdGasto, Impuesto, Info1, Info2, Info3, EntryTipoGto, Valor, EntryGastoMovil, Notas, IdTran)
                            VALUES ('".$data['entryFactMovil']."','".$data['entryLegMovil']."','".$data['entryPerfilMovil']."','". $data['idGasto']."','".$data['impuesto']."','". $data['info1']."',
							'". $data['info2']."','". $data['info3']."','".$data['tipoGasto']."','".$data['valor']."','".$data['entryGastoMovil']."',
							'".$data['notas']."', '". $data['idTransaccion']."');
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

            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function UpdateForaneas($data) {
        try {
            $sql = "UPDATE ok1_gto, (SELECT EntryFactWeb, EntryFactMovil FROM ok1_fact WHERE idTran = " . $data['idTransaccion'] . ") t1
                SET ok1_gto.EntryFactWeb = t1.EntryFactWeb WHERE ok1_gto.EntryFactWeb = t1.EntryFactMovil AND ok1_gto.idTran =" . $data['idTransaccion'];
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
    
    
    public function GetAllgastosFactura($idFact) {
        try {			
            $result = array();
			$query = "SELECT * FROM $this->table WHERE EntryFactWeb=".$idFact;
			
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }
    
    public function GetAllgastosLegalizacion($idLeg) {
        try {			
            $result = array();
			$query = "SELECT * FROM $this->table WHERE EntryLegWeb=".$idLeg;
			
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }
		
	  public function GetAllSincronizacionSAP($idFactura) {
        try {
            $result = array();
            $query = "SELECT * FROM $this->table WHERE EntryFactWeb=".$idFactura;		
            $stm = $this->db->prepare($query);
            $stm->execute();
            $array_result = json_decode(json_encode($stm->fetchAll()), true);
            return $array_result;
        } catch (Exception $e) {
            return array("error");
        }
    }

}
