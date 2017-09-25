<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Grupo_Gto {

    private $db;
    private $table = 'ok1_grupo_gto';
    private $response;
    private $primary = 'IdGrupoWeb';
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

    public function GetGrupoAll($data) {
        try {
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE EntryComWeb = " . $data);
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
	
	public function GetGrupoCompany($data, $dataCompany) {
        try {
            $result = array();
		    $sql= "SELECT CASE WHEN IdGrupoSAP = ".$data." AND EntryComWeb = ".$dataCompany. " THEN 1 ELSE 0 END AS valor FROM $this->table WHERE IdGrupoSAP = ".$data." AND EntryComWeb = ".$dataCompany;
			$stm = $this->db->prepare($sql);
            $stm->execute(array());                     
			$result = $stm->fetch();
			$result = (array) $result;
            $this->response->result = $result['valor'];
            $this->response->setResponse(true);
            return $this->response;				
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
	
	
	

    public function sincronizarGrupoGtoSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $grupoAux;
            $dtcompany = $data['dtcompany'];
            $dtcompany = $dtcompany[0];
            $dtdata = $data['dtdata'];

            $dtcompany['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nit']);
            $dtcompany['Nit'] = $this->servicio->limpiarCadena($dtcompany['Nit']);
            $dtcompany['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nombre']);
            $dtcompany['Nombre'] = $this->servicio->limpiarCadena($dtcompany['Nombre']);
            $dtcompany['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['CodigoVerificacion']);
            $dtcompany['CodigoVerificacion'] = $this->servicio->limpiarCadena($dtcompany['CodigoVerificacion']);
            $dtcompany['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['DocEntryCompany']);
            $dtcompany['DocEntryCompany'] = $this->servicio->limpiarCadena($dtcompany['DocEntryCompany']);

            $sql = "SELECT EntryComWeb FROM ok1_company WHERE Nit='" . $dtcompany['Nit'] . "' AND Nombre='" . $dtcompany['Nombre'] . "'";

            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;

            if ($dtcompany['DocEntryCompany'] !== $result['EntryComWeb']) {
                $this->response->setResponse('2', 'Los datos de compania no coinciden');
                $this->response->result = 'false';
                return $this->response;
            } else {
                $i = 0;
                for ($i = 0; $i < count($dtdata); $i++) {
                    $grupoAux = $dtdata[$i];
                    $grupoAux['NombreGrupo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['NombreGrupo']);
                    $grupoAux['NombreGrupo'] = $this->servicio->limpiarCadena($grupoAux['NombreGrupo']);

                   
                    if ($grupoAux['IdGrupoSAP'] !== null && $grupoAux['IdGrupoSAP'] !== '') {
                        $grupoAux['IdGrupoSAP'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['IdGrupoSAP']);
                        $grupoAux['IdGrupoSAP'] = $this->servicio->limpiarCadena($grupoAux['IdGrupoSAP']);
                    }else{
                        $grupoAux['IdGrupoSAP'] = "0";
                    }
					
					
					$res =  $this->GetGrupoCompany($grupoAux['IdGrupoSAP'],  $dtcompany['DocEntryCompany']);
				    $res = $res->{'result'}; 
					
				
						if (!empty($res)) {
						 $sql = "UPDATE $this->table SET NombreGrupo = '" 
						 . $grupoAux['NombreGrupo'] . "' WHERE IdGrupoSAP = '" 
						 . $grupoAux['IdGrupoSAP'] . "' AND EntryComWeb="
						 . $dtcompany['DocEntryCompany'];
						 
						  $sql = str_replace("''", "null", $sql);
						  
                  try {
                    $this->db->prepare($sql)
                            ->execute(array());                    
					$cad = $cad . '{"IdGrupoWeb":"0", "IdGrupoSAP":"0"},';
					} catch (Exception $e) {
                    $cad = $cad . '{"IdGrupoWeb":"0", "IdGrupoSAP":"0"},';
					}
                }else{
							$sql = "INSERT INTO ok1_grupo_gto (NombreGrupo,EntryComWeb,IdGrupoSAP) VALUES ('" 
                            . $grupoAux['NombreGrupo'] . "','" 
                            . $dtcompany['DocEntryCompany'] . "','"                    
                            . $grupoAux['IdGrupoSAP'] . "')";
							 $sql = str_replace("''", "null", $sql);
						
                    try {
                    $this->db->prepare($sql)
                            ->execute(array());
                    $resId = $this->db->lastInsertId();
                    $cad = $cad . '{"IdGrupoWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $resId) . '", "IdGrupoSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['IdGrupoSAP']) . '"}';
                } catch (Exception $e) {
                    $cad = $cad . '{"IdGrupoWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '0') . '", "IdGrupoSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['IdGrupoSAP']) . '"}';
                }
                $cad = $cad . ']';
							}
				}
				 $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
			return $this->response;}
            
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    
     public function actualizarGrupoGtoSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $grupoAux;

            $dtcompany = $data['dtcompany'];
            $dtcompany = $dtcompany[0];
            $dtdata = $data['dtdata'];

            $dtcompany['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nit']);
            $dtcompany['Nit'] = $this->servicio->limpiarCadena($dtcompany['Nit']);
            $dtcompany['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nombre']);
            $dtcompany['Nombre'] = $this->servicio->limpiarCadena($dtcompany['Nombre']);
            $dtcompany['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['CodigoVerificacion']);
            $dtcompany['CodigoVerificacion'] = $this->servicio->limpiarCadena($dtcompany['CodigoVerificacion']);
            $dtcompany['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['DocEntryCompany']);
            $dtcompany['DocEntryCompany'] = $this->servicio->limpiarCadena($dtcompany['DocEntryCompany']);

            $sql = "SELECT EntryComWeb FROM ok1_company WHERE Nit='" . $dtcompany['Nit'] . "' AND Nombre='" . $dtcompany['Nombre'] . "'";

            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;

            if ($dtcompany['DocEntryCompany'] !== $result['EntryComWeb']) {
                $this->response->setResponse('2', 'Los datos de compania no coinciden');
                $this->response->result = 'false';
                return $this->response;
            } else {
                $i = 0;
                for ($i = 0; $i < count($dtdata); $i++) {
                    $grupoAux = $dtdata[$i];

                   /* $grupoAux['IdGrupoWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['idGrupoWeb']);
                    $grupoAux['idGrupoWeb'] = $this->servicio->limpiarCadena($grupoAux['idGrupoWeb']);*/
                    $grupoAux['NombreGrupo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['NombreGrupo']);
                    $grupoAux['NombreGrupo'] = $this->servicio->limpiarCadena($grupoAux['NombreGrupo']);
                    $grupoAux['IdGrupoSAP'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['IdGrupoSAP']);
                    $grupoAux['IdGrupoSAP'] = $this->servicio->limpiarCadena($grupoAux['IdGrupoSAP']);
                
                    $sql = "UPDATE $this->table SET NombreGrupo = '" . $grupoAux['NombreGrupo'] . "' WHERE IdGrupoSAP = '" . $grupoAux['IdGrupoSAP'] . "' AND EntryComWeb=". $dtcompany['DocEntryCompany'];
                    try {
                        $this->db->prepare($sql)
                                ->execute(array());
                    } catch (Exception $e) {                      
                    }
                }
                
                $this->response->setResponse('1', 'Operacion exitosa');
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

	 public function GetAllGruposGto($data) {

        try {
            $result = array();

            $sql = "SELECT * FROM ok1_grupo_gto 
					WHERE EntryComWeb IN (" . $data . ")";
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
