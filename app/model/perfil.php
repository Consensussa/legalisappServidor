<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Perfil {

    private $db;
    private $table = 'ok1_perf';
    private $response;
    private $primary = 'DocPerfil';
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

    public function GetAllCompany($company) {
        try {
            $result = array();
            $sql = "SELECT * FROM $this->table WHERE Company = " . $company;
			
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
	
	public function GetAllCompanySincro($company) {
        try {
            $result = array();
            $sql = "SELECT * FROM $this->table WHERE " . $company;
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

    public function GetPerfilCompany($data, $company) {
        try {
            $result = array();
            $sql = "SELECT * FROM $this->table WHERE $this->primary = '" . $data . "' AND Company = " . $company;
            
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
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
                            Aprobador          = '" . $data['aprobador'] .
                    "' WHERE EntryPerfilWeb = " . $data['entryPerfilWeb'];

            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
    public function UpdateJoomla($data) {
        try {
            //print_r($data); exit;
            //$data = $data['data'];
            $sql = "UPDATE $this->table SET 
                            PerfilJoomla  = '" . $data['userJoomla'] .
                    "' WHERE EntryPerfilWeb = " . $data['entryPerfilWeb'];
            //echo $sql; exit;
            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Insert($data) {

        try {

		
		$sql = "SELECT '1'  valor FROM ok1_company WHERE EntryComWeb='" . $data['company']."'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;
		    
			if($result['valor']==='1'){
		
            $sql = "INSERT INTO $this->table
                            (EntryPerfilMovil, DocPerfil, Perfil, EmailPerfil, Proyecto, SN, Company, Aprobador, Dimension1, Dimension2, Dimension3, Dimension4, Dimension5, IdGrupo, EnviaRequisicion, AprobadorRequisicion)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['entryPerfilMovil'],
                                $data['docPerfil'],
                                $data['perfil'],
                                $data['emailPerfil'],
                                $data['proyecto'],
                                $data['sn'],
                                $data['company'],
                                $data['aprobador'],
                                $data['dimension1'],
                                $data['dimension2'],
                                $data['dimension3'],
                                $data['dimension4'],
                                $data['dimension5'],
                                $data['idGrupo'],
                                $data['enviaRequisicion'],
                                $data['aprobadorRequisicion']
                            )
            );
            array_push($data, 'insert');
			}else{
				array_push($data, 'no insert');
			}
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

    public function sincronizarPerfilSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $perfilAux;

            $data['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nit']);
            $data['Nit'] = $this->servicio->limpiarCadena($data['Nit']);
            $data['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nombre']);
            $data['Nombre'] = $this->servicio->limpiarCadena($data['Nombre']);
            $data['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['CodigoVerificacion']);
            $data['CodigoVerificacion'] = $this->servicio->limpiarCadena($data['CodigoVerificacion']);
            $data['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['DocEntryCompany']);
            $data['DocEntryCompany'] = $this->servicio->limpiarCadena($data['DocEntryCompany']);
			$data['NombreCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['NombreCompany']);
            $data['NombreCompany'] = $this->servicio->limpiarCadena($data['NombreCompany']);
			
            $sql = "SELECT EntryComWeb FROM ok1_company WHERE Nit='" . $data['Nit'] . "' AND Nombre='" . $data['Nombre'] . "'";

            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;

            if ($data['DocEntryCompany'] !== $result['EntryComWeb']) {
                $this->response->setResponse('2', 'Los datos de compania no coinciden');
                $this->response->result = 'false';
                return $this->response;
            } else {
                $sql = "SELECT p.EntryPerfilWeb, p.DocPerfil, p.Aprobador, p.EmailPerfil, p.Perfil, g.IdGrupoSAP AS IdGrupo
						FROM ok1_perf p INNER JOIN ok1_grupo_gto g ON (p.IdGrupo=g.IdGrupoWeb) WHERE SincronizacionSAP=0 
						AND Company=" . $data['DocEntryCompany'];
                $stm = $this->db->prepare($sql);
                $stm->execute();
                $this->response->setResponse(true);
                $result = $stm->fetchAll();
                $result = (array) $result;
                $i = 0;
                for ($i = 0; $i < (count($result) - 1); $i++) {
                    $perfilAux = (array) $result[$i];
                    $aprobador = $perfilAux['Aprobador'];
                    $emailPerfil = $perfilAux['EmailPerfil'];
                    $entryPerfilWeb = $perfilAux['EntryPerfilWeb'];
                    $docPerfil = $perfilAux['DocPerfil'];
                    $nombrePerfil = $perfilAux['Perfil'];
                    $grupoPerfil = $perfilAux['IdGrupo'];
                    $cad = $cad . '{"aprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $aprobador) . '", '
                            . '"emailPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $emailPerfil) . '",'
                            . '"docEntryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $entryPerfilWeb) . '",'
                            . '"docPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $docPerfil) . '",'
                            . '"nombrePerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $nombrePerfil) . '",'
                            . '"grupoPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoPerfil) . '"},';
                }
                $perfilAux = (array) $result[$i];
                $aprobador = $perfilAux['Aprobador'];
                $emailPerfil = $perfilAux['EmailPerfil'];
                $entryPerfilWeb = $perfilAux['EntryPerfilWeb'];
                $docPerfil = $perfilAux['DocPerfil'];
                $nombrePerfil = $perfilAux['Perfil'];
                $grupoPerfil = $perfilAux['IdGrupo'];
                $cad = $cad . '{"aprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $aprobador) . '", '
                        . '"emailPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $emailPerfil) . '",'
                        . '"docEntryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $entryPerfilWeb) . '",'
                        . '"docPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $docPerfil) . '",'
                        . '"nombrePerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $nombrePerfil) . '",'
                        . '"grupoPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoPerfil) . '"}';
                $cad = $cad . "]";

                $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al sincronizar');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function confirmarSincronizarPerfilSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $perfilAux;

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
                    $perfilAux = $dtdata[$i];
                    $perfilAux['Sincronizado'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['Sincronizado']);
                    $perfilAux['Sincronizado'] = $this->servicio->limpiarCadena($perfilAux['Sincronizado']);
                    $perfilAux['EntryPerfilWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['EntryPerfilWeb']);
                    $perfilAux['EntryPerfilWeb'] = $this->servicio->limpiarCadena($perfilAux['EntryPerfilWeb']);

                    $sql = "UPDATE $this->table SET SincronizacionSAP = '" . $perfilAux['Sincronizado'] . "' WHERE EntryPerfilWeb = '" . $perfilAux['EntryPerfilWeb'] . "'";
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

    public function InsertPerfilMovil($data) {
        $data = $data['data'];	
		
        try {			
			$sql = "SELECT IdGrupoWeb FROM ok1_grupo_gto WHERE EntryComWeb='" . $data['company'] . "' AND IdGrupoSAP='" . $data['idGrupo'] . "'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;
			
            $sql = " INSERT INTO $this->table
                            (EntryPerfilMovil, DocPerfil, Perfil, Proyecto, SN, Company, Aprobador, EmailPerfil, Dimension1, Dimension2, Dimension3, Dimension4, Dimension5, IdGrupo, EnviaRequisicion, AprobadorRequisicion)
                            VALUES ('" . $data['entryPerfilMovil'] . "','" . $data['docPerfil'] . "','" . $data['perfil'] . "','" . $data['proyecto'] . "','" .
                    $data['sn'] . "','" . $data['company'] . "','" . $data['aprobador'] . "','" . $data['emailPerfil'] . "','" . $data['dimension1'] . "','" .
                    $data['dimension2'] . "','" . $data['dimension3'] . "','" . $data['dimension4'] . "','" . $data['dimension5'] . "','" . $result['IdGrupoWeb'] . "','" . $data['enviaRequisicion'] . "','" . $data['aprobadorRequisicion'] . "');
					";
            $sql = str_replace("''", "null", $sql);
            $this->db->prepare($sql)
                    ->execute(array());
            $data['entryPerfilWeb'] = $this->db->lastInsertId();
            $this->response->setResponse('1', $data);
            $this->response->result = 'true';
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al insertar perfil');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function UpdatePerfilSAP($data) {
        try {
            $sql = "UPDATE $this->table SET 
                            Aprobador          = '" . $data['aprobador'] .
                    "' WHERE EntryPerfilWeb = " . $data['entryPerfilWeb'];

            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function UpdatePerfilSAP2($data) {
        try {
			 if($data['entryPerfilWebAprobador']!==null && $data['entryPerfilWebAprobador']!==''){
				//if($data['entryPerfilWebAprobador']!==null && $data['entryPerfilWebAprobador']!=='' ){
				$aprobadorReq='0'; 
				//}
			 }else{
				 $aprobadorReq='1';
			 }
			
            $sql = "UPDATE $this->table SET " .
                    "Aprobador  = '" . $data['aprobador'] . "'" .
                    "DimensionSap  = '" . $data['dimensionSap'] . "'" .
                    "ProyectoSap  = '" . $data['proyectoSap'] . "'" .
                    "AlmacenSap  = '" . $data['almacenSap'] . "'" .
					"AprobadorRequisicion  = '" . $aprobadorReq . "'" .
                    "EntryPerfilWebAprobador  = '" . $data['entryPerfilWebAprobador'] . "'" .
                    "' WHERE EntryPerfilWeb = " . $data['entryPerfilWeb'];
            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

     public function actualizarPerfilSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $perfilAux;

            $dtcompany = $data['dtcompany'];
            $dtcompany = $dtcompany[0];
            $dtdata = $data['dtdata'];
			if($dtcompany['Nit']!==null && $dtcompany['Nit']!==''){
            $dtcompany['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nit']);			
            $dtcompany['Nit'] = $this->servicio->limpiarCadena($dtcompany['Nit']);
			}
			if($dtcompany['Nombre']!==null && $dtcompany['Nombre']!==''){
            $dtcompany['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['Nombre']);
            $dtcompany['Nombre'] = $this->servicio->limpiarCadena($dtcompany['Nombre']);
			}
			if($dtcompany['CodigoVerificacion']!==null && $dtcompany['CodigoVerificacion']!==''){
            $dtcompany['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['CodigoVerificacion']);
            $dtcompany['CodigoVerificacion'] = $this->servicio->limpiarCadena($dtcompany['CodigoVerificacion']);
			}
			if($dtcompany['DocEntryCompany']!==null && $dtcompany['DocEntryCompany']!==''){
            $dtcompany['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $dtcompany['DocEntryCompany']);
            $dtcompany['DocEntryCompany'] = $this->servicio->limpiarCadena($dtcompany['DocEntryCompany']);
			}
			
			$sql = "SELECT EntryComWeb FROM ok1_company WHERE Nit='" . $dtcompany['Nit'] . "' AND CodigoVerificacion='" . $dtcompany['CodigoVerificacion'] . "'";

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
                    $perfilAux = $dtdata[$i];
					if($perfilAux['EntryPerfilWeb']!==null && $perfilAux['EntryPerfilWeb']!==''){
                    $perfilAux['EntryPerfilWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['EntryPerfilWeb']);					
                    $perfilAux['EntryPerfilWeb'] = $this->servicio->limpiarCadena($perfilAux['EntryPerfilWeb']);					
                    }
					if($perfilAux['Aprobador']!==null && $perfilAux['Aprobador']!==''){
					$perfilAux['Aprobador'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['Aprobador']);
					$perfilAux['Aprobador'] = $this->servicio->limpiarCadena($perfilAux['Aprobador']);
                    }
					if($perfilAux['RequiereAprobacion']!==null && $perfilAux['RequiereAprobacion']!==''){
					$perfilAux['RequiereAprobacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['RequiereAprobacion']);
                    $perfilAux['RequiereAprobacion'] = $this->servicio->limpiarCadena($perfilAux['RequiereAprobacion']);
                    }
					if($perfilAux['IdGrupo']!==null && $perfilAux['IdGrupo']!==''){
					$perfilAux['IdGrupo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $perfilAux['IdGrupo']);
                    $perfilAux['IdGrupo'] = $this->servicio->limpiarCadena($perfilAux['IdGrupo']);
					}
					try{
						
						$sql = "SELECT IdGrupoWeb FROM ok1_grupo_gto WHERE EntryComWeb='" . $dtcompany['DocEntryCompany'] . "' AND IdGrupoSAP='" . $perfilAux['IdGrupo'] . "'";

						
					$stm = $this->db->prepare($sql);
					$stm->execute(array());
					$result = $stm->fetch();
					$result = (array) $result;
					
					if ($result['IdGrupoWeb'] !== null && $result['IdGrupoWeb'] !=='') {
						$perfilAux['IdGrupo'] = $result['IdGrupoWeb']; 
						
					}
					
					}catch (Exception $e) {
						
					}			
					
					$sql = "UPDATE $this->table SET aprobador = '" . $perfilAux['Aprobador'] . "', Dimension2 = '" . $perfilAux['RequiereAprobacion'] . "',"
                            . "idGrupo = '" . $perfilAux['IdGrupo'] . "' WHERE EntryPerfilWeb = '" . $perfilAux['EntryPerfilWeb'] . "'";
					
				
					
					try {
                        $this->db->prepare($sql)
                                ->execute(array());
                    } catch (Exception $e) {
                        try{
                             $sqle = "UPDATE $this->table SET SincronizacionSAP = 0 WHERE EntryPerfilWeb = '" . $perfilAux['EntryPerfilWeb'] . "'";
                            echo $sqle;

							$this->db->prepare($sqle)
                                ->execute(array());
                        } catch (Exception $e){
                            
                        }
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
	
	  public function GetNombreWeb($data) {
		
        try {
            $result = array();
            $sql = "SELECT COUNT(1) AS valor FROM ok1_perf p, ok1_company c WHERE p.Perfil = '" . $data[0] . "' AND p.Company = c.EntryComWeb AND
 SUBSTRING(c.Nit, 1, (LENGTH(c.Nit)-2)) = '" . $data[1]."'";
			            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $this->response->setResponse(true, 'true');
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
	
	
	 public function sincronizarPerfilRequisicionSAP($data) {
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
                for ($i = 0; $i < (count($dtdata) - 1); $i++) {
                    $grupoAux = $dtdata[$i];
                    if ($grupoAux['EntryPerfilWeb'] !== null && $grupoAux['EntryPerfilWeb'] !== '') {
                        $grupoAux['EntryPerfilWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['EntryPerfilWeb']);
                        $grupoAux['EntryPerfilWeb'] = $this->servicio->limpiarCadena($grupoAux['EntryPerfilWeb']);
                    } else {
                        $grupoAux['EntryPerfilWeb'] = "-1";
                    }

                    if ($grupoAux['Almacen'] !== null && $grupoAux['Almacen'] !== '') {
                        $grupoAux['Almacen'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['Almacen']);
                        $grupoAux['Almacen'] = $this->servicio->limpiarCadena($grupoAux['Almacen']);
                    } else {
                        $grupoAux['Almacen'] = "-1";
                    }

                    if ($grupoAux['GrupoArticulo'] !== null && $grupoAux['GrupoArticulo'] !== '') {
                        $grupoAux['GrupoArticulo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['GrupoArticulo']);
                        $grupoAux['GrupoArticulo'] = $this->servicio->limpiarCadena($grupoAux['GrupoArticulo']);
                    } else {
                        $grupoAux['GrupoArticulo'] = "-1";
                    }
                    if ($grupoAux['GeneraRequisicion'] !== null && $grupoAux['GeneraRequisicion'] !== '') {
                        $grupoAux['GeneraRequisicion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['GeneraRequisicion']);
                        $grupoAux['GeneraRequisicion'] = $this->servicio->limpiarCadena($grupoAux['GeneraRequisicion']);
                    } else {
                        $grupoAux['GeneraRequisicion'] = "-1";
                    }

                    if ($grupoAux['Proyecto'] !== null && $grupoAux['Proyecto'] !== '') {
                        $grupoAux['Proyecto'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['Proyecto']);
                        $grupoAux['Proyecto'] = $this->servicio->limpiarCadena($grupoAux['Proyecto']);
                    } else {
                        $grupoAux['Proyecto'] = "-1";
                    }
                    if ($grupoAux['EntryPerfilWebAutorizador'] !== null && $grupoAux['EntryPerfilWebAutorizador'] !== '') {
                        $grupoAux['EntryPerfilWebAutorizador'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['EntryPerfilWebAutorizador']);
                        $grupoAux['EntryPerfilWebAutorizador'] = $this->servicio->limpiarCadena($grupoAux['EntryPerfilWebAutorizador']);
                    } else {
                        $grupoAux['EntryPerfilWebAutorizador'] = "-1";
                    }

                    if ($grupoAux['ApruebaRequisicion'] !== null && $grupoAux['ApruebaRequisicion'] !== '') {
                        $grupoAux['ApruebaRequisicion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['ApruebaRequisicion']);
                        $grupoAux['ApruebaRequisicion'] = $this->servicio->limpiarCadena($grupoAux['ApruebaRequisicion']);
                    } else {
                        $grupoAux['ApruebaRequisicion'] = "-1";
                    }

                    $sql = "UPDATE ok1_perf SET EnviaRequisicion = '" . $grupoAux['GeneraRequisicion'] . "',"
                            . "EntryPerfilWebAprobador= '" . $grupoAux['EntryPerfilWebAutorizador'] . "',"
                            . "AlmacenSap= '" . $grupoAux['Almacen'] . "',"
                            . "ProyectoSap= '" . $grupoAux['Proyecto'] . "',"
                            . "DimensionSap= '" . $grupoAux['GrupoArticulo'] . "',"
                            . "AprobadorRequisicion= '" . $grupoAux['ApruebaRequisicion'] . "'"
                            . " WHERE EntryPerfilWeb='"
                            . $grupoAux['EntryPerfilWeb'] . "'";

                    $sql = str_replace("''", "null", $sql);
												
                    try {
                        $this->db->prepare($sql)
                                ->execute(array());
                        $cad = $cad . '{"EntryPerfilWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '1') . '"},';
                    } catch (Exception $e) {
                        $cad = $cad . '{"EntryPerfilWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '0') . '"},';
                    }
					
                    $sql = "UPDATE ok1_perf SET AprobadorRequisicion= 'Y'"
                            . " WHERE EntryPerfilWeb='"
                            . $grupoAux['EntryPerfilWebAutorizador'] . "'";

                    $sql = str_replace("''", "null", $sql);
					
					 try {
                        $this->db->prepare($sql)
                                ->execute(array());                       
                    } catch (Exception $e) {
						
                    }
                }

                $grupoAux = $dtdata[$i];
                if ($grupoAux['EntryPerfilWeb'] !== null && $grupoAux['EntryPerfilWeb'] !== '') {
                    $grupoAux['EntryPerfilWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['EntryPerfilWeb']);
                    $grupoAux['EntryPerfilWeb'] = $this->servicio->limpiarCadena($grupoAux['EntryPerfilWeb']);
                } else {
                    $grupoAux['EntryPerfilWeb'] = "-1";
                }

                if ($grupoAux['Almacen'] !== null && $grupoAux['Almacen'] !== '') {
                    $grupoAux['Almacen'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['Almacen']);
                    $grupoAux['Almacen'] = $this->servicio->limpiarCadena($grupoAux['Almacen']);
                } else {
                    $grupoAux['Almacen'] = "-1";
                }

                if ($grupoAux['GrupoArticulo'] !== null && $grupoAux['GrupoArticulo'] !== '') {
                    $grupoAux['GrupoArticulo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['GrupoArticulo']);
                    $grupoAux['GrupoArticulo'] = $this->servicio->limpiarCadena($grupoAux['GrupoArticulo']);
                } else {
                    $grupoAux['GrupoArticulo'] = "-1";
                }
                if ($grupoAux['GeneraRequisicion'] !== null && $grupoAux['GeneraRequisicion'] !== '') {
                    $grupoAux['GeneraRequisicion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['GeneraRequisicion']);
                    $grupoAux['GeneraRequisicion'] = $this->servicio->limpiarCadena($grupoAux['GeneraRequisicion']);
                } else {
                    $grupoAux['GeneraRequisicion'] = "-1";
                }

                if ($grupoAux['Proyecto'] !== null && $grupoAux['Proyecto'] !== '') {
                    $grupoAux['Proyecto'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['Proyecto']);
                    $grupoAux['Proyecto'] = $this->servicio->limpiarCadena($grupoAux['Proyecto']);
                } else {
                    $grupoAux['Proyecto'] = "-1";
                }
                 if ($grupoAux['EntryPerfilWebAutorizador'] !== null && $grupoAux['EntryPerfilWebAutorizador'] !== '') {
                    $grupoAux['EntryPerfilWebAutorizador'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $grupoAux['EntryPerfilWebAutorizador']);
                    $grupoAux['EntryPerfilWebAutorizador'] = $this->servicio->limpiarCadena($grupoAux['EntryPerfilWebAutorizador']);
                   // $grupoAux['ApruebaRequisicion'] = "0";
                    } else {
                    $grupoAux['EntryPerfilWebAutorizador'] = "-1";
                    //$grupoAux['ApruebaRequisicion'] = "1";
                }

              
                $sql = "UPDATE ok1_perf SET EnviaRequisicion = '" . $grupoAux['GeneraRequisicion'] . "',"
                        . "EntryPerfilWebAprobador= '" . $grupoAux['EntryPerfilWebAutorizador'] . "',"
                        . "AlmacenSap= '" . $grupoAux['Almacen'] . "',"
                        . "ProyectoSap= '" . $grupoAux['Proyecto'] . "',"
                        . "DimensionSap= '" . $grupoAux['GrupoArticulo'] . "',"
                        . "AprobadorRequisicion= '" . $grupoAux['ApruebaRequisicion'] . "'"
                        . " WHERE EntryPerfilWeb='"
                        . $grupoAux['EntryPerfilWeb'] . "'";

                $sql = str_replace("''", "null", $sql);
                try {
                    $this->db->prepare($sql)
                            ->execute(array());

                    $cad = $cad . '{"EntryPerfilWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '1') . '"}';
                } catch (Exception $e) {
                    $cad = $cad . '{"EntryPerfilWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '0') . '"}';
                }
                $cad = $cad . ']';
				
				$sql = "UPDATE ok1_perf SET AprobadorRequisicion= 'Y'"
                            . " WHERE EntryPerfilWeb='"
                            . $grupoAux['EntryPerfilWebAutorizador'] . "'";

                    $sql = str_replace("''", "null", $sql);
					
					 try {
                        $this->db->prepare($sql)
                                ->execute(array());                       
                    } catch (Exception $e) {
						
                    }
				
                $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar requisición sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

}
