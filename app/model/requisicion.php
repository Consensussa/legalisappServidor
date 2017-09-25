<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;
use App\Lib\DatabaseDIAPI;

class Requisicion {

    private $db; // Variable Conexion
    private $table = ''; //Variable tabla principal de la clase
    private $response; //Variable respuesta de invocacion a metodo
    private $primary = ''; // Variable campo llave primaria de tabla principal
    private $servicio; // Variable clase Servicio
    private $bdname; // Variable Nombre de base de datos
    private $dbDIAPI;
    private $bdnameDIAPI;
    private $servidorTipoDIAPI;

    //Constructor Clase Productos
    public function __CONSTRUCT() {
        $this->db = Database::StartUp(); //Instancia de variable conexion
        //$this->bdname = Database::$base_datos; //Instancia de variable nombre de base de datos
        $this->response = new Response(); // Instancia de variable respuesta 
        $this->servicio = new Servicio(); // Instancia de la clase servicio        
    }

    /*
      //GetAll, este metodo retorna todos los registros de la tabla @OK1_LQPAD_BASCULA
      public function GetAll() {
      try {
      //declaracion vector de respuesta
      $result = array();
      //ejecucion de consulta
      $stm = $this->db->prepare("SELECT * FROM $this->table");
      $stm->execute();
      //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con los registros consultados
      $this->response->setResponse(true);
      $this->response->result = $stm->fetchAll();
      //Retorno de respuesta
      return $this->response;
      } catch (Exception $e) {
      //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
      $this->response->setResponse(false, $e->getMessage());
      //Retorno de respuesta
      return $this->response;
      }
      }

      //Get, Este metodo retorna el registro especifico que coincide con el dato entrante en la columna CardCode de la tabla @OK1_LQPAD_BASCULA
      public function Get($data) {
      try {
      //declaracion vector de respuesta
      $result = array();
      //ejecucion de consulta
      $stm = $this->db->prepare("SELECT * FROM $this->table WHERE $this->primary = ?");
      $stm->execute(array($data));
      //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con el registro consultado
      $this->response->setResponse(true);
      //Retorno de respuesta
      $this->response->result = $stm->fetch();
      return $this->response;
      } catch (Exception $e) {
      //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
      $this->response->setResponse(false, $e->getMessage());
      //Retorno de respuesta
      return $this->response;
      }
      } */

    public function GetMetadataBD($data) {
        try {
            //declaracion vector de respuesta			
            $result = array();
            $sql = "SELECT T1.EntryComWeb,T1.Driver,T1.Servidor,T1.ServidorLicencia,
                    T1.ServidorTipo,T1.ServidorTipoNombre,T1.ServidorNombre, 
                    T1.Usuario,T1.Clave,T1.UsuarioDB,T1.ClaveDB,T1.BaseDatos
                    FROM ok1_data_con T1 INNER JOIN ok1_company T2
                    ON (T1.EntryComWeb = T2.EntryComWeb)
                    WHERE T1.EntryComWeb = (SELECT T3.Company FROM ok1_perf T3 WHERE T3.EntryPerfilWeb='" . $data . "')";

            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;
            return $result;
        } catch (Exception $e) {
            //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
            $this->response->setResponse(false, $e->getMessage());
            //Retorno de respuesta 
            return null;
        }
    }

    public function GetItems($data) {
        try {
            //declaracion vector de respuesta

            $result = array();
            $oRecordSet = null;
            $cad = "[";
            $metadataDB = $this->GetMetadataBD($data);

            if ($metadataDB['Usuario'] !== '' && $metadataDB['Usuario'] !== null) {

                $this->dbDIAPI = new DatabaseDIAPI();

                $this->dbDIAPI->__CONSTRUCT_ALL($metadataDB['BaseDatos'], $metadataDB['Servidor'], $metadataDB['UsuarioDB'], $metadataDB['ClaveDB'], $metadataDB['Usuario'], $metadataDB['Clave'], $metadataDB['Driver'], $metadataDB['ServidorLicencia'], $metadataDB['ServidorTipo']);

                $conn = $this->dbDIAPI->openConn();

                $sql = 'SELECT T1."DocEntry" AS "DocEntryPerfil", T2."DocEntry" AS "DocEntryItem",T2."U_PrcCode", 
                          T2."U_PrcName", T2."U_DimCode", T2."U_InvntItem", T2."U_TypeReqItem",T2."U_ItemCode",T2."U_ItemName",T2."U_FrgnName",T2."U_ItmsGrpCod" 
                           FROM "@OK1_REQUIS_CCOART" T2, "@OK1_2LE_MOVPER_H" T1
                           WHERE T1."U_Dim1" = T2."U_PrcCode" AND T1."U_DocEntryW"= \'' . $data . '\''
                        . 'UNION ALL SELECT \'0\',\'0\',\'0\',\'N-A\',\'0\',\'N\',\'N\',\'0\',\'Item\',\'Item\',\'0\'';

             
                $oRecordSet = $this->dbDIAPI->executeQuery($sql);
                $oRecordSet->MoveFirst;
                while ($oRecordSet->EOF != 1) {
                    $cad = $cad . '{"DocEntryPerfil": "' . $oRecordSet->Fields->Item("DocEntryPerfil")->value . '", "DocEntryItem":"' . $oRecordSet->Fields->Item("DocEntryItem")->value . '","U_ItemName":"' . $oRecordSet->Fields->Item("U_ItemName")->value . '"},';
                    $oRecordSet->MoveNext;
                }
                $this->dbDIAPI->closeConn();

                $cad = substr($cad, 0, strlen($cad) - 1);
            }
            $cad = $cad . "]";
			//echo $cad;exit;
            //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con el registro consultado
            $this->response->setResponse('true', $cad);
            $this->response->result = 'true';
            //Retorno de respuesta
            return $this->response;
        } catch (Exception $e) {
            //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
            $this->response->setResponse('false', $e->getMessage());
            $this->response->result = 'false';
            //Retorno de respuesta 
            return $this->response;
        }
    }

    public function GetRequisicionEnviar($data) {
        try {
            $result = array();
            $sql = "SELECT * FROM ok1_req WHERE EntryReqMovil = '" . $data['entryReqMovil'] . "' AND 
                                        EntryPerfilWeb = '" . $data['entryPerfilWeb'] . "' AND Estado = '" . $data['estado'] . "' AND
                                        EntryPerfilWebAprobador = '" . $data['entryPerfilWebAprobador'] . "'  AND EntryPerfilMovil = '" . $data['entryPerfilMovil'] . "' AND IdTran = '" . $data['idTran'] . "'";

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

    public function Insert($data) {		
        $sql = "SELECT EntryPerfilWebAprobador FROM ok1_perf WHERE EntryPerfilWeb =" . $data['entryPerfilWeb'];
		
		
		$stm = $this->db->prepare($sql);
        $stm->execute(array());
        $result = (array) $stm->fetch();
		$entryPerilWebAprobador=$result['EntryPerfilWebAprobador'];
        if ($entryPerilWebAprobador !== null && $entryPerilWebAprobador !== '') {
			$entryPerilWebAprobador=(integer)$entryPerilWebAprobador;
			if($entryPerilWebAprobador > 0){
				 $data['estado'] = 'pendiente';
			}else{
				$data['estado'] = 'aprobada';
			}            
        } else {
           $data['estado'] = 'aprobada';
        }	
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
			    INSERT INTO ok1_req (EntryReqMovil,Estado,EntryPerfilWebAprobador,EntryPerfilWeb,
                            EntryPerfilMovil,Sincronizado,SincronizacionSAP,SincronizacionAprobador,Descripcion,IdTran)
							VALUES ('" . $data['entryReqMovil'] . "','" . $data['estado'] .
                    "','" . $data['entryPerfilWebAprobador'] . "','" . $data['entryPerfilWeb'] .
                    "','" . $data['entryPerfilMovil'] . "','1','0','0','".$data['descripcion']."','".$data['idTran']."'); 
					SET FOREIGN_KEY_CHECKS=1;";
					
			$this->db->beginTransaction(); 		
	$this->db->prepare($sql)
                    ->execute(array());
				$this->db->commit(); 
 $sql="SELECT EntryReqWeb FROM ok1_req WHERE IdTran='".$data['idTran'] . "'";
 $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;
			if ($result['EntryReqWeb'] != null && $result['EntryReqWeb'] != "" ) {				
				 $this->response->setResponse("true",$result['EntryReqWeb']);
			}else{
				 $this->response->setResponse("false","0");				
			}
			return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
	
	
	 public function InsertItem($data) {      
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;
			    INSERT INTO ok1_ite (Sincronizado,Descripcion,Articulo,ArticuloCodigo,ArticuloNombre,Tipo,ReqTipo,Fecha,
									CantidadSolicitada,CantidadAprobada,Proveedor,Almacen,GrupoArticuloReq,Proyecto,
									EntryReqMovil,EntryReqWeb,EntryItemMovil,IdTran,EntryItemMovilCreador)
							VALUES ('" . $data['sincronizado'] . "','" . $data['descripcion'] ."','" . $data['articulo']. "','" 
							. $data['articuloCodigo'] ."','" . $data['articuloNombre'] . "','".$data['tipo']."','".$data['reqTipo']."','"
							.$data['fecha']."','".$data['cantidadSolicitada']."','".$data['cantidadAprobada']."','".$data['proveedor']."','"
							.$data['almacen']."','".$data['grupoArticuloReq']."','".$data['proyecto']."','".$data['entryReqMovil']."','"
							.$data['entryReqWeb']."','".$data['entryItemMovil']."','".$data['idTran']."','".$data['entryItemMovilCreador']."'); 
					SET FOREIGN_KEY_CHECKS=1;";
			$this->db->beginTransaction(); 		
	$this->db->prepare($sql)
                    ->execute(array());
				$this->db->commit();			
				 $this->response->setResponse("true","true");
			return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
	 

    public function GetRequisicionesAprobar($data) {
		
        try {
            $result = array();
            $sql = "SELECT r.EntryReqWeb AS entryReqWeb,
r.EntryReqMovil AS entryReqMovil,
r.Estado AS estado,
r.EntryPerfilWebAprobador AS entryPerfilWebAprobador,
r.EntryPerfilWeb AS entryPerfilWebCreador,
r.EntryPerfilMovil AS entryPerfilMovilCreador,
r.Sincronizado AS sincronizado,
r.SincronizacionSAP AS sincronizacionSAP,
r.SincronizacionAprobador AS sincronizacionAprobador,
r.FechaSincronizacion AS fechaSincronizacion,
r.FechaAutorizacion AS fechaAutorizacion,
r.Descripcion AS descripcion,
r.IdTran AS idTran,
p.EntryPerfilMovil AS entryPerfilMovilAprobador,
p2.Perfil AS perfilCreadorReq
FROM ok1_req r, ok1_perf p, ok1_perf p2 WHERE 
p.EntryPerfilWeb = r.EntryPerfilWebAprobador
AND p2.EntryPerfilWeb = r.EntryPerfilWeb
AND r.EntryPerfilWebAprobador "
                    . "IN (" . $data . ") AND SincronizacionAprobador = '0'";



            $stm = $this->db->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
            $result = (array) $result;
            return $result;
        } catch (Exception $e) {
            return '-1';
        }
    }
	
	  public function GetRequisicionRespuesta($data) {
      try {
      //declaracion vector de respuesta
      $result = array();
      //ejecucion de consulta
      $stm = $this->db->prepare("SELECT * FROM ok1_req WHERE EntryReqWeb = $data");
      $stm->execute(array($data));
      //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con el registro consultado
      $this->response->setResponse(true);
      //Retorno de respuesta
      $this->response->result = $stm->fetch();
      return $this->response;
      } catch (Exception $e) {
      //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
      $this->response->setResponse(false, $e->getMessage());
      //Retorno de respuesta
      return $this->response;
      }
      }

	   public function UpdateResSincroAprobacion($data) {		  
        try {
            $result = array();
            $sql = "UPDATE ok1_req SET SincronizacionAprobador='" . $data[1] . "' WHERE entryReqWeb = '" . $data[0]."'";
			 
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
	
	  public function GetStock($data) {
        try {
            //declaracion vector de respuesta
            $result = array();
            $oRecordSet = null;
            $cad = "";
            if ($data[0] === "0") {
                $cad = $cad . '{"CodigoArticulo":"0","NombreArticulo":"Item","Almacen":"N-A","Disponible":"0","Comprometido":"0","Pedido":"0","Optimo":"0"}';
            } else {
                $metadataDB = $this->GetMetadataBD($data[1]);
                if ($metadataDB['Usuario'] !== '' && $metadataDB['Usuario'] !== null) {
                    $this->dbDIAPI = new DatabaseDIAPI();
                    $this->dbDIAPI->__CONSTRUCT_ALL($metadataDB['BaseDatos'], $metadataDB['Servidor'], $metadataDB['UsuarioDB'], $metadataDB['ClaveDB'], $metadataDB['Usuario'], $metadataDB['Clave'], $metadataDB['Driver'], $metadataDB['ServidorLicencia'], $metadataDB['ServidorTipo']);
                    $conn = $this->dbDIAPI->openConn();

                    $sql = 'SELECT T0."ItemCode" AS "CodigoArticulo", T1."ItemName" AS "NombreArticulo", 
                    T0."WhsCode" AS "Almacen", T0."OnHand" AS "Disponible", 
                    T0."IsCommited" AS "Comprometido", T0."OnOrder" AS "Pedido", 
                    ABS(T0."OnHand"- T0."IsCommited"- T0."OnOrder") AS "Optimo" 
                    FROM "OITW" T0 INNER JOIN "OITM" T1 ON (T0."ItemCode"= T1."ItemCode")
                    WHERE T0."ItemCode"=\'' . $data[0] . '\' AND T0."WhsCode"= 
                    (SELECT "U_AlmacenReq" FROM "@OK1_2LE_MOVPER_H" WHERE "U_DocEntryW" =\'' . $data[1] . '\')';
                    
                    $oRecordSet = $this->dbDIAPI->executeQuery($sql);
                    $oRecordSet->MoveFirst;
                    while ($oRecordSet->EOF != 1) {
                        $cad = $cad . '{"CodigoArticulo":"' . $oRecordSet->Fields->Item("CodigoArticulo")->value . '","NombreArticulo":"' . $oRecordSet->Fields->Item("NombreArticulo")->value . '","Almacen":"' . $oRecordSet->Fields->Item("Almacen")->value . '","Disponible":"' . $oRecordSet->Fields->Item("Disponible")->value . '","Comprometido":"' . $oRecordSet->Fields->Item("Comprometido")->value . '","Pedido":"' . $oRecordSet->Fields->Item("Pedido")->value . '","Optimo":"' . $oRecordSet->Fields->Item("Optimo")->value . '"},';
                        $oRecordSet->MoveNext;
                    }
                    $this->dbDIAPI->closeConn();
                    $cad = substr($cad, 0, strlen($cad) - 1);
                }
            }
            //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con el registro consultado
            $this->response->setResponse('true', $cad);
            $this->response->result = 'true';
            //Retorno de respuesta
            return $this->response;
        } catch (Exception $e) {
            //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
            $this->response->setResponse('false', $e->getMessage());
            $this->response->result = 'false';
            //Retorno de respuesta 
            return $this->response;
        }
    }
	
	 public function UpdateItemAprobacion($data) {		
        try {
			 if($data['cantidadAprobada']===null || $data['cantidadAprobada']===''){
				$data['cantidadAprobada']='0';
			}
            $sql = "UPDATE ok1_ite SET 
                            Sincronizado = '" . $data['sincronizado'] .
                    "', CantidadAprobada='".$data['cantidadAprobada']."' WHERE EntryItemMovil = '" . $data['entryItemMovilCreador']. "' AND EntryReqWeb = '" . $data['entryReqWeb']. "'";
            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
	}
		
		 public function UpdateReqAprobacion($data) {		
        try {			
			
            $sql = "UPDATE ok1_req SET 
                            Estado = 'aprobada', FechaAutorizacion = CURRENT_TIMESTAMP WHERE EntryReqWeb = '" . $data['entryReqWeb']. "'";

            $this->db->prepare($sql)
                    ->execute(array());
            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
	}
	
	    
      //GetRequisicionesEstado, este metodo retorna los registros indicados de la tabla ok1_req 
      public function GetRequisicionesEstado($data) {
      try {
      //declaracion vector de respuesta
      $result = array();
      //ejecucion de consulta
	  $sql= "SELECT * FROM ok1_req WHERE entryReqWeb IN (".$data.")";	 
      $stm = $this->db->prepare($sql);
      $stm->execute();
      //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con los registros consultados
      $this->response->setResponse(true,$stm->fetchAll());
      $this->response->result = 'true';
      //Retorno de respuesta
      return $this->response;
      } catch (Exception $e) {
      //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
      $this->response->setResponse(false, $e->getMessage());
	  $this->response->result = 'false';
      //Retorno de respuesta
      return $this->response;
      }
      }
	  
	  
	  public function sincronizarItemsSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $objAux;
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
                if (count($dtdata) > 0) {
			$sql = "DELETE FROM ok1_art WHERE EntryComWeb='".$dtcompany['DocEntryCompany']."'";
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
										
                    for ($i = 0; $i < count($dtdata); $i++) {
                        $objAux = $dtdata[$i];
                     
   					 if ($objAux['DocEntryGrupo'] !== null && $objAux['DocEntryGrupo'] !== '') {
                            $objAux['DocEntryGrupo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryGrupo']);
                            $objAux['DocEntryGrupo'] = $this->servicio->limpiarCadena($objAux['DocEntryGrupo']);
                        } else {
                            $objAux['DocEntryGrupo'] = "0";
                        }

                        if ($objAux['U_GrpName'] !== null && $objAux['U_GrpName'] !== '') {
                            $objAux['U_GrpName'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['U_GrpName']);
                            $objAux['U_GrpName'] = $this->servicio->limpiarCadena($objAux['U_GrpName']);
                        } else {
                            $objAux['U_GrpName'] = "0";
                        }

						 if ($objAux['DocEntryItemGrupo'] !== null && $objAux['DocEntryItemGrupo'] !== '') {
                            $objAux['DocEntryItemGrupo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryItemGrupo']);
                            $objAux['DocEntryItemGrupo'] = $this->servicio->limpiarCadena($objAux['DocEntryItemGrupo']);
                        } else {
                            $objAux['DocEntryItemGrupo'] = "0";
                        }
						
						 if ($objAux['U_ItemName'] !== null && $objAux['U_ItemName'] !== '') {
                            $objAux['U_ItemName'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['U_ItemName']);
                            $objAux['U_ItemName'] = $this->servicio->limpiarCadena($objAux['U_ItemName']);
                        } else {
                            $objAux['U_ItemName'] = "0";
                        }
						
						 if ($objAux['U_ItemCode'] !== null && $objAux['U_ItemCode'] !== '') {
                            $objAux['U_ItemCode'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['U_ItemCode']);
                            $objAux['U_ItemCode'] = $this->servicio->limpiarCadena($objAux['U_ItemCode']);
                        } else {
                            $objAux['U_ItemCode'] = "0";
                        }
						
						 if ($objAux['U_FrgnName'] !== null && $objAux['U_FrgnName'] !== '') {
                            $objAux['U_FrgnName'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['U_FrgnName']);
                            $objAux['U_FrgnName'] = $this->servicio->limpiarCadena($objAux['U_FrgnName']);
                        } else {
                            $objAux['U_FrgnName'] = "0";
                        }
						
						 if ($objAux['U_InvntItem'] !== null && $objAux['U_InvntItem'] !== '') {
                            $objAux['U_InvntItem'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['U_InvntItem']);
                            $objAux['U_InvntItem'] = $this->servicio->limpiarCadena($objAux['U_InvntItem']);
                        } else {
                            $objAux['U_InvntItem'] = "0";
                        }
						
						 if ($objAux['EntryComWeb'] !== null && $objAux['EntryComWeb'] !== '') {
                            $objAux['EntryComWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['EntryComWeb']);
                            $objAux['EntryComWeb'] = $this->servicio->limpiarCadena($objAux['EntryComWeb']);
                        } else {
                            $objAux['EntryComWeb'] = "0";
                        }
						
                        $sql = "INSERT INTO ok1_art (DocEntryGrupo,U_GrpName,DocEntryItemGrupo,"
                                . "U_ItemName,U_ItemCode,U_FrgnName,U_InvntItem,EntryComWeb) "
                                . "VALUES ("
                                . "'" . $objAux['DocEntryGrupo'] . "'"
                                . ",'" . $objAux['U_GrpName'] . "'"
                                . ",'" . $objAux['DocEntryItemGrupo'] . "'"
                                . ",'" . $objAux['U_ItemName'] . "'"
                                . ",'" . $objAux['U_ItemCode'] . "'"
                                . ",'" . $objAux['U_FrgnName'] . "'"
                                . ",'" . $objAux['U_InvntItem'] . "'"
                                . ",'" . $objAux['EntryComWeb'] . "'"
                                . ")";

                        $sql = str_replace("''", "null", $sql);

                        try {
                            $this->db->prepare($sql)
                                    ->execute(array());
                            $resId = $this->db->lastInsertId();
                            $cad = $cad . '{"idArticuloWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $resId) . '", "idGrupoArticuloSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryGrupo']) . '", "idArticuloSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryItemGrupo']) . '"},';
                        } catch (Exception $e) {
                            $cad = $cad . '{"idArticuloWeb": "' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), '0') . '", "idGrupoArticuloSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryGrupo']) . '", "idArticuloSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['DocEntryItemGrupo']) . '"},';
                        }
                    }
                    $cad = substr($cad, 0, strlen($cad) - 1);
                }
                $cad = $cad . ']';
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
	
	 public function GetItemsWs($data) {
		 
        try {
            //declaracion vector de respuesta
            $sql = "";
            $result = array();
			$data=$data['data'];
			$data=(array)$data;
            $dataQuery = "'-1'";	
		
                for ($i = 0; $i < count($data); $i++) {				
                    $dataQueryAux=$data[$i];						
                    $dataQuery = $dataQuery . ",'" . $dataQueryAux['entryPerfilWeb'] . "'";
                }  
            
		  $sql ="SELECT T0.* FROM
(SELECT a.*, p.EntryPerfilWeb AS DocEntryPerfil, p.EntryPerfilMovil AS DocEntryPerfilMovil
FROM ok1_art a, ok1_perf p 
 WHERE p.EntryPerfilWeb IN (" . $dataQuery . ")
 AND a.DocEntryGrupo = p.DimensionSap 
 AND p.Company IN (SELECT EntryComWeb FROM ok1_perf WHERE EntryPerfilWeb IN (" . $dataQuery . "))
 UNION ALL 
 SELECT a.*, '0', '0'
 FROM ok1_art a
 WHERE a.DocEntryGrupo='0') T0
  ORDER BY T0.DocEntryPerfil ASC";
  
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetchAll();
            $datos = (array) $result;			
            $cad = "[";
            if (count($datos)) {
                for ($i = 0; $i < count($datos); $i++) {
                    $objAux = (array)$datos[$i];
                     $cad = $cad
                            . '{"DocEntryGrupo":"' . $objAux['DocEntryGrupo'] 
                            . '","U_GrpName":"' . $objAux['U_GrpName'] 
                            . '","DocEntryItemGrupo":"' . $objAux['DocEntryItemGrupo'] 
                            . '","U_ItemName":"' . $objAux['U_ItemName'] 
                            . '","U_ItemCode":"' . $objAux['U_ItemCode'] 
                            . '","U_FrgnName":"' . $objAux['U_FrgnName'] 
                            . '","U_InvntItem":"' . $objAux['U_InvntItem'] 
                            . '","EntryComWeb":"' . $objAux['EntryComWeb'] 
							. '","DocEntryPerfilMovil":"' . $objAux['DocEntryPerfilMovil'] 
                            . '","DocEntryPerfil":"' . $objAux['DocEntryPerfil'] . '"},';							
                }
				
                $cad = substr($cad, 0, strlen($cad) - 1);
				
            }
            $cad = $cad . "]";
            // echo $cad;exit;
            //Modificacion de respuesta de retorno, SetResponse primer parametro en true, result segundo parametro, mostrara json con el registro consultado
            $this->response->setResponse('true', $cad);
            $this->response->result = 'true';

            //Retorno de respuesta
            return $this->response;
        } catch (Exception $e) {
            //Modificacion de respuesta de retorno, SetResponse primer parametro en flase, result segundo parametro, mostrara json con el error arrojado
            $this->response->setResponse('false', $e->getMessage());
            $this->response->result = 'false';
            //Retorno de respuesta 
            return $this->response;
        }
    }
}
