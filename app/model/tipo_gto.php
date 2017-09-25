<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Tipo_Gto {

    private $db;
    private $table = 'ok1_tipo_gto';
    private $response;
    private $primary = 'EntryTipoGto';
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
	
	public function GetTipoAll($data) {
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

    public function sincronizarLegConfMovilSAP($data) {
        try {
			$result = array();
            $cad = "[";            
			$legConfMovilAux;            
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
                for ($i = 0; $i < (count($dtdata)-1); $i++) {
                    $legConfMovilAux = $dtdata[$i];
                    $legConfMovilAux['EntryTipoGtoSAP'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['EntryTipoGtoSAP']);
                    $legConfMovilAux['EntryTipoGtoSAP'] = $this->servicio->limpiarCadena($legConfMovilAux['EntryTipoGtoSAP']);
                    if ($legConfMovilAux['NombreGasto'] !==null && $legConfMovilAux['NombreGasto']!=='') {
				    $legConfMovilAux['NombreGasto'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreGasto']);
                    $legConfMovilAux['NombreGasto'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreGasto']);
                    }
					if ($legConfMovilAux['NombreCampo1'] !==null && $legConfMovilAux['NombreCampo1']!=='') {
				    $legConfMovilAux['NombreCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo1']);
                    $legConfMovilAux['NombreCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo1']);                    
					}
					if ($legConfMovilAux['TipoCampo1'] !==null && $legConfMovilAux['TipoCampo1']!=='') {
				    $legConfMovilAux['TipoCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo1']);
                    $legConfMovilAux['TipoCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo1']);
                    }
					 if ($legConfMovilAux['ExigeCampo1'] !==null && $legConfMovilAux['ExigeCampo1']!=='') {
				    $legConfMovilAux['ExigeCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo1']);
                    $legConfMovilAux['ExigeCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo1']);
                    }
					if ($legConfMovilAux['NombreCampo2'] !==null && $legConfMovilAux['NombreCampo2']!=='') {
				    $legConfMovilAux['NombreCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo2']);
                    $legConfMovilAux['NombreCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo2']);
                    }
					if ($legConfMovilAux['TipoCampo2'] !==null && $legConfMovilAux['TipoCampo2']!=='') {
				    $legConfMovilAux['TipoCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo2']);
                    $legConfMovilAux['TipoCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo2']);
                    }
					 if ($legConfMovilAux['ExigeCampo2'] !==null && $legConfMovilAux['ExigeCampo2']!=='') {
				    $legConfMovilAux['ExigeCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo2']);
                    $legConfMovilAux['ExigeCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo2']);
                    }
					if ($legConfMovilAux['NombreCampo3'] !==null && $legConfMovilAux['NombreCampo3']!=='') {
				    $legConfMovilAux['NombreCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo3']);
                    $legConfMovilAux['NombreCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo3']);
                    }
					if ($legConfMovilAux['TipoCampo3'] !==null && $legConfMovilAux['TipoCampo3']!=='') {
				    $legConfMovilAux['TipoCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo3']);
                    $legConfMovilAux['TipoCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo3']);
                    }
					 if ($legConfMovilAux['ExigeCampo3'] !==null && $legConfMovilAux['ExigeCampo3']!=='') {
				    $legConfMovilAux['ExigeCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo3']);
                    $legConfMovilAux['ExigeCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo3']);
                   }				   
				    if ($legConfMovilAux['Grupo01'] !==null && $legConfMovilAux['Grupo01']!=='') {
				    $legConfMovilAux['Grupo01'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo01']);
                    $legConfMovilAux['Grupo01'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo01']);
                   }
				   if ($legConfMovilAux['Grupo02'] !==null && $legConfMovilAux['Grupo02']!=='') {
				    $legConfMovilAux['Grupo02'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo02']);
                    $legConfMovilAux['Grupo02'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo02']);
                   }
				   if ($legConfMovilAux['Grupo03'] !==null && $legConfMovilAux['Grupo03']!=='') {
				    $legConfMovilAux['Grupo03'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo03']);
                    $legConfMovilAux['Grupo03'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo03']);
                   }
				   if ($legConfMovilAux['Grupo04'] !==null && $legConfMovilAux['Grupo04']!=='') {
				    $legConfMovilAux['Grupo04'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo04']);
                    $legConfMovilAux['Grupo04'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo04']);
                   }
				   if ($legConfMovilAux['Grupo05'] !==null && $legConfMovilAux['Grupo05']!=='') {
				    $legConfMovilAux['Grupo05'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo05']);
                    $legConfMovilAux['Grupo05'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo05']);
                   }
				   if ($legConfMovilAux['Grupo06'] !==null && $legConfMovilAux['Grupo06']!=='') {
				    $legConfMovilAux['Grupo06'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo06']);
                    $legConfMovilAux['Grupo06'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo06']);
                   }
				   if ($legConfMovilAux['Grupo07'] !==null && $legConfMovilAux['Grupo07']!=='') {
				    $legConfMovilAux['Grupo07'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo07']);
                    $legConfMovilAux['Grupo07'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo07']);
                   }
				   if ($legConfMovilAux['Grupo08'] !==null && $legConfMovilAux['Grupo08']!=='') {
				    $legConfMovilAux['Grupo08'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo08']);
                    $legConfMovilAux['Grupo08'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo08']);
                   }
				   if ($legConfMovilAux['ImpuestoSugerido'] !==null && $legConfMovilAux['ImpuestoSugerido']!=='') {					   
				    $legConfMovilAux['ImpuestoSugerido'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ImpuestoSugerido']);					
                    $legConfMovilAux['ImpuestoSugerido'] = $this->servicio->limpiarCadena($legConfMovilAux['ImpuestoSugerido']);
					$legConfMovilAux['ImpuestoSugerido'] = str_replace(",", ".", $legConfMovilAux['ImpuestoSugerido']);
                   }
				   
				   
					$sql = "INSERT INTO ok1_tipo_gto (NombreGasto,EntryTipoGtoSAP,NombreCampo1,TipoCampo1,ExigeCampo1,NombreCampo2,TipoCampo2,ExigeCampo2,"
                                . "NombreCampo3,TipoCampo3,ExigeCampo3,EntryComWeb,Grupo01,Grupo02,Grupo03,Grupo04,Grupo05,Grupo06,Grupo07,Grupo08,ImpuestoSugerido) VALUES ('" . $legConfMovilAux['NombreGasto'] . "','" . $legConfMovilAux['EntryTipoGtoSAP'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo1'] . "','" . $legConfMovilAux['TipoCampo1'] . "','" . $legConfMovilAux['ExigeCampo1'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo2'] . "','" . $legConfMovilAux['TipoCampo2'] . "','" . $legConfMovilAux['ExigeCampo2'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo3'] . "','" . $legConfMovilAux['TipoCampo3'] . "','" . $legConfMovilAux['ExigeCampo3'] . "',"
								. "'" . $dtcompany['DocEntryCompany'] . "','" . $legConfMovilAux['Grupo01'] . "','" . $legConfMovilAux['Grupo02'] . "',"
								. "'" . $legConfMovilAux['Grupo03'] . "','" . $legConfMovilAux['Grupo04'] . "','" . $legConfMovilAux['Grupo05'] . "',"
                                . "'" . $legConfMovilAux['Grupo06']  . "','" . $legConfMovilAux['Grupo07'] . "','" . $legConfMovilAux['Grupo08'] . "','" . $legConfMovilAux['ImpuestoSugerido'] . "')";
							
					//$sql= 	str_replace("''", "null", $sql);
					
                     try {    
                         $this->db->prepare($sql)
                                ->execute(array()); 
                         $resId = $this->db->lastInsertId();
                           $cad= $cad.'{"EntryTipoGtoWeb": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$resId).'", "EntryTipoGtoSAP":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['EntryTipoGtoSAP']).'"},';
                    } catch (Exception $e) {
                         $cad= $cad.'{"EntryTipoGtoWeb": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),'0').'", "EntryTipoGtoSAP":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['EntryTipoGtoSAP']).'"},';
                    }
                }
                
                $legConfMovilAux = $dtdata[$i];
                    $legConfMovilAux['EntryTipoGtoSAP'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['EntryTipoGtoSAP']);
                    $legConfMovilAux['EntryTipoGtoSAP'] = $this->servicio->limpiarCadena($legConfMovilAux['EntryTipoGtoSAP']);
                    if ($legConfMovilAux['NombreGasto'] !==null && $legConfMovilAux['NombreGasto']!=='') {
				    $legConfMovilAux['NombreGasto'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreGasto']);
                    $legConfMovilAux['NombreGasto'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreGasto']);
                    }
					if ($legConfMovilAux['NombreCampo1'] !==null && $legConfMovilAux['NombreCampo1']!=='') {
				    $legConfMovilAux['NombreCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo1']);
                    $legConfMovilAux['NombreCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo1']);                    
					}
					if ($legConfMovilAux['TipoCampo1'] !==null && $legConfMovilAux['TipoCampo1']!=='') {
				    $legConfMovilAux['TipoCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo1']);
                    $legConfMovilAux['TipoCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo1']);
                    }
					 if ($legConfMovilAux['ExigeCampo1'] !==null && $legConfMovilAux['ExigeCampo1']!=='') {
				    $legConfMovilAux['ExigeCampo1'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo1']);
                    $legConfMovilAux['ExigeCampo1'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo1']);
                    }
					if ($legConfMovilAux['NombreCampo2'] !==null && $legConfMovilAux['NombreCampo2']!=='') {
				    $legConfMovilAux['NombreCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo2']);
                    $legConfMovilAux['NombreCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo2']);
                    }
					if ($legConfMovilAux['TipoCampo2'] !==null && $legConfMovilAux['TipoCampo2']!=='') {
				    $legConfMovilAux['TipoCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo2']);
                    $legConfMovilAux['TipoCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo2']);
                    }
					 if ($legConfMovilAux['ExigeCampo2'] !==null && $legConfMovilAux['ExigeCampo2']!=='') {
				    $legConfMovilAux['ExigeCampo2'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo2']);
                    $legConfMovilAux['ExigeCampo2'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo2']);
                    }
					if ($legConfMovilAux['NombreCampo3'] !==null && $legConfMovilAux['NombreCampo3']!=='') {
				    $legConfMovilAux['NombreCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['NombreCampo3']);
                    $legConfMovilAux['NombreCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['NombreCampo3']);
                    }
					if ($legConfMovilAux['TipoCampo3'] !==null && $legConfMovilAux['TipoCampo3']!=='') {
				    $legConfMovilAux['TipoCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['TipoCampo3']);
                    $legConfMovilAux['TipoCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['TipoCampo3']);
                    }
					 if ($legConfMovilAux['ExigeCampo3'] !==null && $legConfMovilAux['ExigeCampo3']!=='') {
				    $legConfMovilAux['ExigeCampo3'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ExigeCampo3']);
                    $legConfMovilAux['ExigeCampo3'] = $this->servicio->limpiarCadena($legConfMovilAux['ExigeCampo3']);
                  

				    if ($legConfMovilAux['Grupo01'] !==null && $legConfMovilAux['Grupo01']!=='') {
				    $legConfMovilAux['Grupo01'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo01']);
                    $legConfMovilAux['Grupo01'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo01']);
                   }
				   if ($legConfMovilAux['Grupo02'] !==null && $legConfMovilAux['Grupo02']!=='') {
				    $legConfMovilAux['Grupo02'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo02']);
                    $legConfMovilAux['Grupo02'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo02']);
                   }
				   if ($legConfMovilAux['Grupo03'] !==null && $legConfMovilAux['Grupo03']!=='') {
				    $legConfMovilAux['Grupo03'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo03']);
                    $legConfMovilAux['Grupo03'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo03']);
                   }
				   if ($legConfMovilAux['Grupo04'] !==null && $legConfMovilAux['Grupo04']!=='') {
				    $legConfMovilAux['Grupo04'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo04']);
                    $legConfMovilAux['Grupo04'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo04']);
                   }
				   if ($legConfMovilAux['Grupo05'] !==null && $legConfMovilAux['Grupo05']!=='') {
				    $legConfMovilAux['Grupo05'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo05']);
                    $legConfMovilAux['Grupo05'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo05']);
                   }
				   if ($legConfMovilAux['Grupo06'] !==null && $legConfMovilAux['Grupo06']!=='') {
				    $legConfMovilAux['Grupo06'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo06']);
                    $legConfMovilAux['Grupo06'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo06']);
                   }
				   if ($legConfMovilAux['Grupo07'] !==null && $legConfMovilAux['Grupo07']!=='') {
				    $legConfMovilAux['Grupo07'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo07']);
                    $legConfMovilAux['Grupo07'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo07']);
                   }
				   if ($legConfMovilAux['Grupo08'] !==null && $legConfMovilAux['Grupo08']!=='') {
				    $legConfMovilAux['Grupo08'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Grupo08']);
                    $legConfMovilAux['Grupo08'] = $this->servicio->limpiarCadena($legConfMovilAux['Grupo08']);
                   }
				   if ($legConfMovilAux['ImpuestoSugerido'] !==null && $legConfMovilAux['ImpuestoSugerido']!=='') {
				    $legConfMovilAux['ImpuestoSugerido'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['ImpuestoSugerido']);
                    $legConfMovilAux['ImpuestoSugerido'] = $this->servicio->limpiarCadena($legConfMovilAux['ImpuestoSugerido']);
					$legConfMovilAux['ImpuestoSugerido'] = str_replace(",", ".", $legConfMovilAux['ImpuestoSugerido']);
                   }
				   
				  }
						$sql = "INSERT INTO ok1_tipo_gto (NombreGasto,EntryTipoGtoSAP,NombreCampo1,TipoCampo1,ExigeCampo1,NombreCampo2,TipoCampo2,ExigeCampo2,"
                                . "NombreCampo3,TipoCampo3,ExigeCampo3,EntryComWeb,Grupo01,Grupo02,Grupo03,Grupo04,Grupo05,Grupo06,Grupo07,Grupo08,ImpuestoSugerido) VALUES ('" . $legConfMovilAux['NombreGasto'] . "','" . $legConfMovilAux['EntryTipoGtoSAP'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo1'] . "','" . $legConfMovilAux['TipoCampo1'] . "','" . $legConfMovilAux['ExigeCampo1'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo2'] . "','" . $legConfMovilAux['TipoCampo2'] . "','" . $legConfMovilAux['ExigeCampo2'] . "',"
                                . "'" . $legConfMovilAux['NombreCampo3'] . "','" . $legConfMovilAux['TipoCampo3'] . "','" . $legConfMovilAux['ExigeCampo3'] . "',"
								. "'" . $dtcompany['DocEntryCompany'] . "','" . $legConfMovilAux['Grupo01'] . "','" . $legConfMovilAux['Grupo02'] . "',"
								. "'" . $legConfMovilAux['Grupo03'] . "','" . $legConfMovilAux['Grupo04'] . "','" . $legConfMovilAux['Grupo05'] . "',"
                                . "'" . $legConfMovilAux['Grupo06']  . "','" . $legConfMovilAux['Grupo07'] . "','" . $legConfMovilAux['Grupo08'] . "','" . $legConfMovilAux['ImpuestoSugerido'] . "')";
							
                    
					try {    
                         $this->db->prepare($sql)
                                ->execute(array());
                         $resId = $this->db->lastInsertId();
                         $cad= $cad.'{"EntryTipoGtoWeb": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$resId).'", "EntryTipoGtoSAP":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['EntryTipoGtoSAP']).'"}';
                    } catch (Exception $e) {
                         $cad= $cad.'{"EntryTipoGtoWeb": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),'0').'", "EntryTipoGtoSAP":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['EntryTipoGtoSAP']).'"}';
                    }
                $cad=$cad.']';
                $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

		public function GetNuevosTiposGto($data) {
			
		try {
            $result = array();
			
			$sql = "SELECT * FROM ok1_tipo_gto 
					WHERE EntryTipoGto NOT IN (".$data.") AND 
					EntryComWeb IN (SELECT c.EntryComWeb FROM ok1_company c, ok1_tipo_gto t 
					WHERE t.EntryComWeb = c.EntryComWeb AND t.EntryTipoGto IN (".$data."))";
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
