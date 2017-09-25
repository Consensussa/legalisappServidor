<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Perfil;
use App\Model\Legalizacion;
use App\Model\Factura;
use App\Model\Gasto;
use App\Model\Servicio;
use App\Model\Tipo_Gto;
use App\Model\Requisicion;
use App\Model\Impuestos_Cia;
use App\Model\Monedas_Cia;

class Metadatos {

    private $response;
    private $db;
    private $servicio;

    public function __CONSTRUCT() {
        $this->db = Database::StartUp();
        $this->response = new Response();
        $this->servicio = new Servicio();
    }

    /* public function InsertOrUpdate($data) {
      try {
      $datos = json_encode($data);
      $datos = json_decode($datos);
      $datos = $datos->{'data'};
      $company = "";
      $docPerf="";
      $tipo_gto_consulta;
      $tipo_gto_array;
      $perfiles = $datos->{'perfiles'};
      $tipos_gto = $datos->{'tipos_gto'};
      $perfil = new Perfil();
      $tipo_gto = new Tipo_Gto();
      for ($i = 0; $i < count($perfiles); $i++) {
      $perfil_array = [
      "entryPerfilMovil" => $perfiles[$i]->{'entryPerfilMovil'},
      "entryPerfilWeb" => $perfiles[$i]->{'entryPerfilWeb'},
      "docPerfil" => $perfiles[$i]->{'docPerfil'},
      "perfil" => $perfiles[$i]->{'perfil'},
      "emailPerfil" => $perfiles[$i]->{'emailPerfil'},
      "proyecto" => $perfiles[$i]->{'proyecto'},
      "sn" => $perfiles[$i]->{'sn'},
      "company" => $perfiles[$i]->{'company'},
      "aprobador" => $perfiles[$i]->{'aprobador'},
      "dimension1" => $perfiles[$i]->{'dimension1'},
      "dimension2" => $perfiles[$i]->{'dimension2'},
      "dimension3" => $perfiles[$i]->{'dimension3'},
      "dimension4" => $perfiles[$i]->{'dimension4'},
      "dimension5" => $perfiles[$i]->{'dimension5'}
      ];
      $company = $company.$perfiles[$i]->{'company'}.',';
      $docPerf = $docPerf.$perfiles[$i]->{'docPerfil'}.',';
      $res = $perfil->GetPerfilCompany($perfiles[$i]->{'docPerfil'}, $perfiles[$i]->{'company'});

      if (!empty($res->{'result'})) {

      $perfil->Update($perfil_array);
      } else {


      $perfil->Insert($perfil_array);

      }
      }


      if ($tipos_gto !== null && $tipos_gto !== ''){
      $i = 0;
      for ($i = 0; $i < (count($tipos_gto) -1); $i++) {
      $tipo_gto_consulta =  $tipo_gto_consulta."'".$tipos_gto[$i]->{'tipoGasto'}."',";
      }
      $tipo_gto_consulta =  $tipo_gto_consulta."'".$tipos_gto[$i]->{'tipoGasto'}."'";
      $tipo_gto_array = $tipo_gto->GetNuevosTiposGto($tipo_gto_consulta);
      }

      $respuestaSincronizacion =  $this->responderSincronizacion($perfil, $company, $docPerf, $tipo_gto_array);
      if(!empty($respuestaSincronizacion)){
      $this->response->setResponse(true, $respuestaSincronizacion);
      return $this->response;
      }else{
      $this->response->setResponse(false, '0');
      return $this->response;
      }
      } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      return $this->response;
      }
      } */

    public function InsertOrUpdate($data) {
        try {
            $datos = json_encode($data);
            $datos = json_decode($datos);
            $datos = $datos->{'data'};
            $company = "";
            $docPerf = "";
            $tipo_gto_consulta;
            $tipo_gto_array;
            $grupo_gto_array;
            $monedas_array;
            $impuestos_array;
            $legalizacion_consulta;
            $legalizacion_array;
            $legalizacionWeb_array;
            $factura_consulta;
            $factura_array;
            $gasto_consulta;
            $gasto_array;
            $companies_consulta;
            $requisiciones_aprobar_consulta;
            $requisicion_array;
			$requisicionesCreador_consulta;
            $requisicionesCreador_array;
            $perfiles = $datos->{'perfiles'};
            $tipos_gto = $datos->{'tipos_gto'};
            $companies = $datos->{'company'};
            $legalizaciones = $datos->{'legalizaciones'};
			$requisicionesCreador = $datos->{'requisiciones'};
            $perfil = new Perfil();
            $tipo_gto = new Tipo_Gto();
            $monedas = new Monedas_Cia();
            $impuestos = new Impuestos_Cia();
            $legalizacion = new Legalizacion();
            $companyt = new Company();
            $grupo_gto = new Grupo_Gto();
            $requisicion = new Requisicion();
            for ($i = 0; $i < count($perfiles); $i++) {
                $perfil_array = [
                    "entryPerfilMovil" => $perfiles[$i]->{'entryPerfilMovil'},
                    "entryPerfilWeb" => $perfiles[$i]->{'entryPerfilWeb'},
                    "docPerfil" => $perfiles[$i]->{'docPerfil'},
                    "perfil" => $perfiles[$i]->{'perfil'},
                    "emailPerfil" => $perfiles[$i]->{'emailPerfil'},
                    "proyecto" => $perfiles[$i]->{'proyecto'},
                    "sn" => $perfiles[$i]->{'sn'},
                    "company" => $perfiles[$i]->{'company'},
                    "aprobador" => $perfiles[$i]->{'aprobador'},
                    "dimension1" => $perfiles[$i]->{'dimension1'},
                    "dimension2" => $perfiles[$i]->{'dimension2'},
                    "dimension3" => $perfiles[$i]->{'dimension3'},
                    "dimension4" => $perfiles[$i]->{'dimension4'},
                    "dimension5" => $perfiles[$i]->{'dimension5'},
                    "idGrupo" => $perfiles[$i]->{'idGrupo'},
                    "enviaRequisicion" => $perfiles[$i]->{'enviaRequisicion'},
                    "aprobadorRequisicion" => $perfiles[$i]->{'aprobadorRequisicion'},
                    "dimensionSap" => $perfiles[$i]->{'dimensionSap'},
                    "almacenSap" => $perfiles[$i]->{'almacenSap'},
                    "proyectoSap" => $perfiles[$i]->{'proyectoSap'},
                    "entryPerfilWebAprobador" => $perfiles[$i]->{'entryPerfilWebAprobador'},
                    "entryPerfilMovilAprobador" => $perfiles[$i]->{'entryPerfilMovilAprobador'}
                ];
                $company = $company . $perfiles[$i]->{'company'} . ',';
                $docPerf = $docPerf . $perfiles[$i]->{'docPerfil'} . ',';
                $res = $perfil->GetPerfilCompany($perfiles[$i]->{'docPerfil'}, $perfiles[$i]->{'company'});

                if (!empty($res->{'result'})) {

                 //   $perfil->Update($perfil_array);
                } else {
                    $perfil->Insert($perfil_array);
                }
            }

            if ($tipos_gto !== null && $tipos_gto !== '') {
                $i = 0;
                for ($i = 0; $i < (count($tipos_gto) - 1); $i++) {
                    $tipo_gto_consulta = $tipo_gto_consulta . "'" . $tipos_gto[$i]->{'tipoGasto'} . "',";
                }
                $tipo_gto_consulta = $tipo_gto_consulta . "'" . $tipos_gto[$i]->{'tipoGasto'} . "'";
                $tipo_gto_array = $tipo_gto->GetNuevosTiposGto($tipo_gto_consulta);
            }

            if ($companies !== null && $companies !== '') {
                $i = 0;
                for ($i = 0; $i < (count($companies) - 1); $i++) {
                    $companies_consulta = $companies_consulta . "'" . $companies[$i]->{'company'} . "',";
                }
                $companies_consulta = $companies_consulta . "'" . $companies[$i]->{'company'} . "'";
                $grupo_gto_array = $grupo_gto->GetAllGruposGto($companies_consulta);
            }

            if ($legalizaciones !== null && $legalizaciones !== '') {
                $i = 0;
                for ($i = 0; $i < (count($legalizaciones) - 1); $i++) {
                    $legalizacion_consulta = $legalizacion_consulta . "'" . $legalizaciones[$i]->{'entryLegWeb'} . "',";
                }
                $legalizacion_consulta = $legalizacion_consulta . "'" . $legalizaciones[$i]->{'entryLegWeb'} . "'";
                $legalizacion_array = $legalizacion->GetEnviadosLegalizacion($legalizacion_consulta);
            }


            $monedas_array = $monedas->GetTipoAll($companies_consulta);
            $impuestos_array = $impuestos->GetTipoAll($companies_consulta);
			
			
			 for ($i = 0; $i < (count($perfiles) - 1); $i++) {
                $requisiciones_aprobar_consulta = $requisiciones_aprobar_consulta . "'" . $perfiles[$i]->{'entryPerfilWeb'} . "',";
            }
			
            $requisiciones_aprobar_consulta = $requisiciones_aprobar_consulta . "'" . $perfiles[$i]->{'entryPerfilWeb'} . "'";

            $legalizacionWeb_array = $legalizacion->GetLegalizacionesWeb($requisiciones_aprobar_consulta);			
           
            $requisiciones_aprobar_array = $requisicion->GetRequisicionesAprobar($requisiciones_aprobar_consulta);

			    if ($requisicionesCreador !== null && $requisicionesCreador !== '') {
                $i = 0;
                for ($i = 0; $i < count($requisicionesCreador); $i++) {
                    $requisicionesCreador_consulta = $requisicionesCreador_consulta . "'" . $requisicionesCreador[$i]->{'entryReqWeb'} . "',";
                }
				$requisicionesCreador_consulta= substr($requisicionesCreador_consulta, 0, strlen($requisicionesCreador_consulta) - 1);                
                $requisicionesCreador_array = (array)$requisicion->GetRequisicionesEstado($requisicionesCreador_consulta);
				
				if($requisicionesCreador_array ['message']!==null && $requisicionesCreador_array ['message']!==''){					
				$requisicionesCreador_array= $requisicionesCreador_array['message'];				
				}
            }

			
            $respuestaSincronizacion = $this->responderSincronizacion($perfil, $company, $docPerf, $tipo_gto_array, $monedas_array, $impuestos_array, $legalizacion_array, $legalizacionWeb_array, $grupo_gto_array, $requisiciones_aprobar_array,$requisicionesCreador_array);
            if (!empty($respuestaSincronizacion)) {
                $this->response->setResponse(true, $respuestaSincronizacion);
                return $this->response;
            } else {
                $this->response->setResponse(false, '0');
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function InsertOrUpdateLegalizacion($data) {
        try {
            $datos = json_encode($data);
            $datos = json_decode($datos);
            $datos = $datos->{'data'};

            //$datos = json_decode($datos);
            $legalizaciones = $datos->{'legalizaciones'};

            $facturas = $datos->{'facturas'};
            $gastos = $datos->{'gastos'};
            $legalizacion_array;
            $factura_array;
            $gasto_array;
            $idTran;
            $json;
            $entryLegWeb;
            $result2;
            $legaExiste;

            $legalizacion = new Legalizacion();

            for ($i = 0; $i < count($legalizaciones); $i++) {
                $legalizacionAux = json_encode($legalizaciones[$i]);
                $legalizacionAux = json_decode($legalizacionAux);
                $entryLegWeb = $legalizacionAux->{'entryLegWeb'};

                $legalizacion_array = [
                    "sincronizado" => $legalizacionAux->{'sincronizado'},
                    "entryLegMovil" => $legalizacionAux->{'entryLegMovil'},
                    "cargado" => $legalizacionAux->{'cargado'},
                    "descripcion" => $legalizacionAux->{'descripcion'},
                    "entryPerfilMovil" => $legalizacionAux->{'entryPerfilMovil'},
                    "estado" => $legalizacionAux->{'estado'},
                    "fechaAutorizacion" => $legalizacionAux->{'fechaAutorizacion'},
                    "fechaSincronizacion" => $legalizacionAux->{'fechaSincronizacion'},
                    "iDLeg" => $legalizacionAux->{'iDLeg'},
                    "noAprobacion" => $legalizacionAux->{'noAprobacion'},
                    "valor" => $legalizacionAux->{'valor'},
                    "entryLegWeb" => $legalizacionAux->{'entryLegWeb'},
                    "idTransaccion" => $legalizacionAux->{'idTransaccion'}
                ];


                $idTran = $legalizacionAux->{'idTransaccion'};

                $legaExiste = $legalizacion->GetLegalizacionEnviar($legalizacion_array);

                $legaExiste = json_encode($legaExiste);
                $legaExiste = (array) json_decode($legaExiste);

                if (!empty($legaExiste)) {
                    if ($legaExiste ['message'] === null || $legaExiste ['message'] === '') {
                        $legalizacion->Insert($legalizacion_array);
                    } else {
                        return $legaExiste;
                    }
                }
            }


            if (!empty($legaExiste)) {
                if ($legaExiste ['message'] === null || $legaExiste ['message'] === '') {
                    $factura = new Factura();
                    for ($i = 0; $i < count($facturas); $i++) {
                        $facturaAux = json_encode($facturas[$i]);
                        $facturaAux = json_decode($facturaAux);

                         if ($facturaAux->{'fecha'}==='' || $facturaAux->{'fecha'}===null) {
                            $fecha3=getdate();
                            $fecha3 = $fecha3['year'].'-'.$fecha3['mon'].'-'.$fecha3['mday'];
                            $facturaAux->{'fecha'}=$fecha3;
                        } else {
                            $facturaAux->{'fecha'}= substr($facturaAux->{'fecha'}, 0, strlen($facturaAux->{'fecha'}) - 6); 
                            $facturaAux->{'fecha'} =date("Y-m-d",strtotime($facturaAux->{'fecha'}));
                            if ($facturaAux->{'fecha'}==='2016-01-01') {
                                $fecha3=getdate();
                                $fecha3 = $fecha3['year'].'-'.$fecha3['mon'].'-'.$fecha3['mday'];
                                $facturaAux->{'fecha'}=$fecha3;
                            }
                        }
                        $factura_array = [
                            "sincronizado" => $facturaAux->{'sincronizado'},
                            "entryFactMovil" => $facturaAux->{'entryFactMovil'},
                            "entryPerfilMovil" => $facturaAux->{'entryPerfilMovil'},
                            "entryLegMovil" => $facturaAux->{'entryLegMovil'},
                            "fecha" => $facturaAux->{'fecha'},
                            "iDLeg" => $facturaAux->{'iDLeg'},
                            "valor" => $facturaAux->{'valor'},
                            "moneda" => $facturaAux->{'moneda'},
                            "referencia" => $facturaAux->{'referencia'},
                            "documento" => $facturaAux->{'documento'},
                            "tipoDoc" => $facturaAux->{'tipoDoc'},
                            "adjunto" => $facturaAux->{'adjunto'},
                            "lineLegSAP" => $facturaAux->{'lineLegSAP'},
                            "comentarioLine" => $facturaAux->{'comentarioLine'},
                            "subTotalSinImpuesto" => $facturaAux->{'subTotalSinImpuesto'},
                            "subTotalImpuesto" => $facturaAux->{'subTotalImpuesto'},
                            "nombreSN" => $facturaAux->{'nombreSN'},
                            "entryFactWeb" => $facturaAux->{'entryFactWeb'},
                            "idTransaccion" => $facturaAux->{'idTransaccion'}
                        ];
                        $factura->Insert($factura_array);
                        $factura->UpdateForaneas($factura_array);
                    }

                    $gasto = new Gasto();
                    for ($i = 0; $i < count($gastos); $i++) {
                        $gastoAux = json_encode($gastos[$i]);
                        $gastoAux = json_decode($gastoAux);
                        $gasto_array = [
                            "sincronizado" => $gastoAux->{'sincronizado'},
                            "entryGastoMovil" => $gastoAux->{'entryGastoMovil'},
                            "entryFactMovil" => $gastoAux->{'entryFactMovil'},
                            "entryLegMovil" => $gastoAux->{'entryLegMovil'},
                            "entryPerfilMovil" => $gastoAux->{'entryPerfilMovil'},
                            "idGasto" => $gastoAux->{'idGasto'},
                            "impuesto" => $gastoAux->{'impuesto'},
                            "info1" => $gastoAux->{'info1'},
                            "info2" => $gastoAux->{'info2'},
                            "info3" => $gastoAux->{'info3'},
                            "tipoGasto" => $gastoAux->{'tipoGasto'},
                            "valor" => $gastoAux->{'valor'},
                            "entryGastoWeb" => $gastoAux->{'entryGastoWeb'},
                            "notas" => $gastoAux->{'notas'},
                            "idTransaccion" => $gastoAux->{'idTransaccion'}
                        ];
                        $gasto->Insert($gasto_array);
                        $gasto->UpdateForaneas($gasto_array);
                    }

                    $sql = "SELECT * FROM v_legalizacion WHERE IdTran = " . $idTran . " ORDER BY EntryFactWeb ASC";
                    $stm = $this->db->prepare($sql);
                    $stm->execute(array());
                    $result2 = $stm->fetchAll();
                    $result2 = (array) $result2;
                    $this->servicio->enviarEmail($result2);
                    $this->servicio->enviarEmailAprobador($result2);

                    $respuestaSincronizacion = $this->responderLegalizacion($legalizacion, $factura, $gasto, $idTran);
                    if (!empty($respuestaSincronizacion)) {
                        $this->response->setResponse(true, $respuestaSincronizacion);
                        return $this->response;
                    } else {
                        $this->response->setResponse(false, '0');
                        return $this->response;
                    }
                }
            } else {
                $this->response->setResponse(false, '0');
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function invocarSecuencia($data) {
        try {
            $result = array();
            $sql = "CALL seqNextVal('".$data."', @valor)";
            $stm = $this->db->prepare($sql);
            $stm->execute();
            $stm->closeCursor();
            $r = $this->db->query("SELECT @valor AS valor")->fetch();
            $array_result = json_decode(json_encode($r), true);
            $this->response->setResponse(true, 'true');
            $this->response->result = $array_result['valor'];
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            $this->response->result = '-1';
            return $this->response;
        }
    }
	


    public function responderLegalizacion($legalizacion, $factura, $gasto, $idTran) {

        $array_legalizacion = $legalizacion->GetTransaccion($idTran);
        $array_factura = $factura->GetAllTransaccion($idTran);
        $array_gasto = $gasto->GetAllTransaccion($idTran);

        $array_legalizacion = json_encode($array_legalizacion);
        $array_legalizacion = json_decode($array_legalizacion);

        $array_factura = json_encode($array_factura);
        $array_factura = json_decode($array_factura);

        $array_gasto = json_encode($array_gasto);
        $array_gasto = json_decode($array_gasto);

        $json = $json . "{\"legalizaciones\":[";
        $json = $json . "{";
        $json = $json . "\"sincronizado\":\"1\",";
        $json = $json . "\"entryLegMovil\":\"" . $array_legalizacion->{'EntryLegMovil'} . "\",";
        $json = $json . "\"cargado\":\"" . $array_legalizacion->{'Cargado'} . "\",";
        $json = $json . "\"descripcion\":\"" . $array_legalizacion->{'Descripcion'} . "\",";
        $json = $json . "\"entryPerfilMovil\":\"" . $array_legalizacion->{'EntryPerfilWeb'} . "\",";
        $json = $json . "\"estado\":\"" . $array_legalizacion->{'Estado'} . "\",";
        $json = $json . "\"fechaAutorizacion\":\"" . $array_legalizacion->{'FechaAutorizacion'} . "\",";
        $json = $json . "\"fechaSincronizacion\":\"" . $array_legalizacion->{'FechaSincronizacion'} . "\",";
        $json = $json . "\"iDLeg\":\"" . $array_legalizacion->{'IDLeg'} . "\",";
        $json = $json . "\"noAprobacion\":\"" . $array_legalizacion->{'NoAprobacion'} . "\",";
        $json = $json . "\"valor\":\"" . $array_legalizacion->{'Valor'} . "\",";
        $json = $json . "\"entryLegWeb\":\"" . $array_legalizacion->{'EntryLegWeb'} . "\",";
        $json = $json . "\"idTransaccion\":\"" . $array_legalizacion->{'IdTran'} . "\"";
        $json = $json . "}";
        $json = $json . "],";

        $i = 0;
        $json = $json . "\"facturas\":[";
        for ($i = 0; $i < (count($array_factura) - 1); $i++) {
            $factura_aux = $array_factura[$i];
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"entryFactMovil\":\"" . $factura_aux->{'EntryFactMovil'} . "\",";
            $json = $json . "\"entryPerfilMovil\":\"" . $factura_aux->{'EntryPerfilWeb'} . "\",";
            $json = $json . "\"entryLegMovil\":\"" . $factura_aux->{'EntryLegWeb'} . "\",";
            $json = $json . "\"fecha\":\"" . $factura_aux->{'Fecha'} . "\",";
            $json = $json . "\"iDLeg\":\"" . $factura_aux->{'IDLeg'} . "\",";
            $json = $json . "\"valor\":\"" . $factura_aux->{'Valor'} . "\",";
            $json = $json . "\"moneda\":\"" . $factura_aux->{'Moneda'} . "\",";
            $json = $json . "\"referencia\":\"" . $factura_aux->{'Referencia'} . "\",";
            $json = $json . "\"documento\":\"" . $factura_aux->{'Documento'} . "\",";
            $json = $json . "\"tipoDoc\":\"" . $factura_aux->{'TipoDoc'} . "\",";
            $json = $json . "\"adjunto\":\"" . $factura_aux->{'Adjunto'} . "\",";
            $json = $json . "\"lineLegSAP\":\"" . $factura_aux->{'LineLegalizacionSAP'} . "\",";
            $json = $json . "\"comentarioLine\":\"" . $factura_aux->{'ComentarioLine'} . "\",";
            $json = $json . "\"subTotalSinImpuesto\":\"" . $factura_aux->{'SubTotalSinImpuesto'} . "\",";
            $json = $json . "\"subTotalImpuesto\":\"" . $factura_aux->{'SubTotalImpuesto'} . "\",";
            $json = $json . "\"nombreSN\":\"" . $factura_aux->{'NombreSN'} . "\",";
            $json = $json . "\"entryFactWeb\":\"" . $factura_aux->{'EntryFactWeb'} . "\",";
            $json = $json . "\"idTransaccion\":\"" . $factura_aux->{'IdTran'} . "\"";
            $json = $json . "},";
        }
        $factura_aux = $array_factura[$i];
        $json = $json . "{";
        $json = $json . "\"sincronizado\":\"1\",";
        $json = $json . "\"entryFactMovil\":\"" . $factura_aux->{'EntryFactMovil'} . "\",";
        $json = $json . "\"entryPerfilMovil\":\"" . $factura_aux->{'EntryPerfilWeb'} . "\",";
        $json = $json . "\"entryLegMovil\":\"" . $factura_aux->{'EntryLegWeb'} . "\",";
        $json = $json . "\"fecha\":\"" . $factura_aux->{'Fecha'} . "\",";
        $json = $json . "\"iDLeg\":\"" . $factura_aux->{'IDLeg'} . "\",";
        $json = $json . "\"valor\":\"" . $factura_aux->{'Valor'} . "\",";
        $json = $json . "\"moneda\":\"" . $factura_aux->{'Moneda'} . "\",";
        $json = $json . "\"referencia\":\"" . $factura_aux->{'Referencia'} . "\",";
        $json = $json . "\"documento\":\"" . $factura_aux->{'Documento'} . "\",";
        $json = $json . "\"tipoDoc\":\"" . $factura_aux->{'TipoDoc'} . "\",";
        $json = $json . "\"adjunto\":\"" . $factura_aux->{'Adjunto'} . "\",";
        $json = $json . "\"lineLegSAP\":\"" . $factura_aux->{'LineLegalizacionSAP'} . "\",";
        $json = $json . "\"comentarioLine\":\"" . $factura_aux->{'ComentarioLine'} . "\",";
        $json = $json . "\"subTotalSinImpuesto\":\"" . $factura_aux->{'SubTotalSinImpuesto'} . "\",";
        $json = $json . "\"subTotalImpuesto\":\"" . $factura_aux->{'SubTotalImpuesto'} . "\",";
        $json = $json . "\"nombreSN\":\"" . $factura_aux->{'NombreSN'} . "\",";
        $json = $json . "\"entryFactWeb\":\"" . $factura_aux->{'EntryFactWeb'} . "\",";
        $json = $json . "\"idTransaccion\":\"" . $factura_aux->{'IdTran'} . "\"";
        $json = $json . "}";
        $json = $json . "],";
        $json = $json . "\"gastos\":[";
        $i = 0;
        for ($i = 0; $i < (count($array_gasto) - 1); $i++) {
            $gasto_aux = $array_gasto[$i];
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"entryGastoMovil\":\"" . $gasto_aux->{'EntryGastoMovil'} . "\",";
            $json = $json . "\"entryFactMovil\":\"" . $gasto_aux->{'EntryFactWeb'} . "\",";
            $json = $json . "\"entryLegMovil\":\"" . $gasto_aux->{'EntryLegWeb'} . "\",";
            $json = $json . "\"entryPerfilMovil\":\"" . $gasto_aux->{'EntryPerfilWeb'} . "\",";
            $json = $json . "\"idGasto\":\"" . $gasto_aux->{'IdGasto'} . "\",";
            $json = $json . "\"impuesto\":\"" . $gasto_aux->{'Impuesto'} . "\",";
            $json = $json . "\"info1\":\"" . $gasto_aux->{'Info1'} . "\",";
            $json = $json . "\"info2\":\"" . $gasto_aux->{'Info2'} . "\",";
            $json = $json . "\"info3\":\"" . $gasto_aux->{'Info3'} . "\",";
            $json = $json . "\"tipoGasto\":\"" . $gasto_aux->{'TipoGasto'} . "\",";
            $json = $json . "\"valor\":\"" . $gasto_aux->{'Valor'} . "\",";
            $json = $json . "\"entryGastoWeb\":\"" . $gasto_aux->{'EntryGastoWeb'} . "\",";
            $json = $json . "\"notas\":\"" . $gasto_aux->{'Notas'} . "\",";
            $json = $json . "\"idTransaccion\":\"" . $gasto_aux->{'IdTran'} . "\"";
            $json = $json . "},";
        }
        $json = $json . "{";
        $json = $json . "\"sincronizado\":\"1\",";
        $json = $json . "\"entryGastoMovil\":\"" . $gasto_aux->{'EntryGastoMovil'} . "\",";
        $json = $json . "\"entryFactMovil\":\"" . $gasto_aux->{'EntryFactWeb'} . "\",";
        $json = $json . "\"entryLegMovil\":\"" . $gasto_aux->{'EntryLegWeb'} . "\",";
        $json = $json . "\"entryPerfilMovil\":\"" . $gasto_aux->{'EntryPerfilWeb'} . "\",";
        $json = $json . "\"idGasto\":\"" . $gasto_aux->{'IdGasto'} . "\",";
        $json = $json . "\"impuesto\":\"" . $gasto_aux->{'Impuesto'} . "\",";
        $json = $json . "\"info1\":\"" . $gasto_aux->{'Info1'} . "\",";
        $json = $json . "\"info2\":\"" . $gasto_aux->{'Info2'} . "\",";
        $json = $json . "\"info3\":\"" . $gasto_aux->{'Info3'} . "\",";
        $json = $json . "\"tipoGasto\":\"" . $gasto_aux->{'TipoGasto'} . "\",";
        $json = $json . "\"valor\":\"" . $gasto_aux->{'Valor'} . "\",";
        $json = $json . "\"entryGastoWeb\":\"" . $gasto_aux->{'EntryGastoWeb'} . "\",";
        $json = $json . "\"notas\":\"" . $gasto_aux->{'Notas'} . "\",";
        $json = $json . "\"idTransaccion\":\"" . $gasto_aux->{'IdTran'} . "\"";
        $json = $json . "}";
        $json = $json . "]}";
        return $json;
    }

    public function responderSincronizacion($perfil, $company, $docPerf, $tipo_gto_array, $monedas_array, $impuestos_array, $legalizacion_array, $legalizacionWeb_array, $grupo_gto_array, $requisiciones_aprobar_array,$requisicionesCreador_array) {
    
        $array_company = explode(",", $company);
        $array_company = (array) $array_company;

        $array_docPerf = explode(",", $docPerf);
        $array_docPerf = (array) $array_docPerf;

        $cadena = "";
        $k = 0;
		
		
        for ($k = 0; $k < (count($array_company) - 2); $k++) {
            $cadena = $cadena . ' (Company = ' . $array_company[$k] . ' AND DocPerfil = \'' . $array_docPerf[$k] . '\') OR ';
        }
        $cadena = $cadena . '(Company = ' . $array_company[$k] . ' AND DocPerfil = \'' . $array_docPerf[$k] . '\')';

        $array_perfil = $perfil->GetAllCompanySincro($cadena);

        $array_perfil = json_encode($array_perfil);
        $array_perfil = json_decode($array_perfil);
        $array_perfil = $array_perfil->{'result'};

        $json = $json . "{\"perfiles\":[";
        $i = 0;
        for ($i = 0; $i < (count($array_perfil) - 1); $i++) {
            $perfil_aux = $array_perfil[$i];
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"entryPerfilMovil\":\"" . $perfil_aux->{'EntryPerfilMovil'} . "\",";
            $json = $json . "\"entryPerfilWeb\":\"" . $perfil_aux->{'EntryPerfilWeb'} . "\",";
            $json = $json . "\"docPerfil\":\"" . $perfil_aux->{'DocPerfil'} . "\",";
            $json = $json . "\"perfil\":\"" . $perfil_aux->{'Perfil'} . "\",";
            $json = $json . "\"emailPerfil\":\"" . $perfil_aux->{'EmailPerfil'} . "\",";
            $json = $json . "\"proyecto\":\"" . $perfil_aux->{'Proyecto'} . "\",";
            $json = $json . "\"sn\":\"" . $perfil_aux->{'SN'} . "\",";
            $json = $json . "\"company\":\"" . $perfil_aux->{'Company'} . "\",";
            $json = $json . "\"aprobador\":\"" . $perfil_aux->{'Aprobador'} . "\",";
            $json = $json . "\"dimension1\":\"" . $perfil_aux->{'Dimension1'} . "\",";
            $json = $json . "\"dimension2\":\"" . $perfil_aux->{'Dimension2'} . "\",";
            $json = $json . "\"dimension3\":\"" . $perfil_aux->{'Dimension3'} . "\",";
            $json = $json . "\"dimension4\":\"" . $perfil_aux->{'Dimension4'} . "\",";
            $json = $json . "\"dimension5\":\"" . $perfil_aux->{'Dimension5'} . "\",";
            $json = $json . "\"idGrupo\":\"" . $perfil_aux->{'IdGrupo'} . "\",";
            $json = $json . "\"enviaRequisicion\":\"" . $perfil_aux->{'EnviaRequisicion'} . "\",";
            $json = $json . "\"aprobadorRequisicion\":\"" . $perfil_aux->{'AprobadorRequisicion'} . "\",";
            $json = $json . "\"dimensionSap\":\"" . $perfil_aux->{'DimensionSap'} . "\",";
            $json = $json . "\"almacenSap\":\"" . $perfil_aux->{'AlmacenSap'} . "\",";
            $json = $json . "\"proyectoSap\":\"" . $perfil_aux->{'ProyectoSap'} . "\",";
            $json = $json . "\"entryPerfilWebAprobador\":\"" . $perfil_aux->{'EntryPerfilWebAprobador'} . "\",";
            $json = $json . "\"entryPerfilMovilAprobador\":\"" . $perfil_aux->{'EntryPerfilMovilAprobador'} . "\"";
            $json = $json . "},";
        }
        $perfil_aux = $array_perfil[$i];
        $json = $json . "{";
        $json = $json . "\"sincronizado\":\"1\",";
        $json = $json . "\"entryPerfilMovil\":\"" . $perfil_aux->{'EntryPerfilMovil'} . "\",";
        $json = $json . "\"entryPerfilWeb\":\"" . $perfil_aux->{'EntryPerfilWeb'} . "\",";
        $json = $json . "\"docPerfil\":\"" . $perfil_aux->{'DocPerfil'} . "\",";
        $json = $json . "\"perfil\":\"" . $perfil_aux->{'Perfil'} . "\",";
        $json = $json . "\"emailPerfil\":\"" . $perfil_aux->{'EmailPerfil'} . "\",";
        $json = $json . "\"proyecto\":\"" . $perfil_aux->{'Proyecto'} . "\",";
        $json = $json . "\"sn\":\"" . $perfil_aux->{'SN'} . "\",";
        $json = $json . "\"company\":\"" . $perfil_aux->{'Company'} . "\",";
        $json = $json . "\"aprobador\":\"" . $perfil_aux->{'Aprobador'} . "\",";
        $json = $json . "\"dimension1\":\"" . $perfil_aux->{'Dimension1'} . "\",";
        $json = $json . "\"dimension2\":\"" . $perfil_aux->{'Dimension2'} . "\",";
        $json = $json . "\"dimension3\":\"" . $perfil_aux->{'Dimension3'} . "\",";
        $json = $json . "\"dimension4\":\"" . $perfil_aux->{'Dimension4'} . "\",";
        $json = $json . "\"dimension5\":\"" . $perfil_aux->{'Dimension5'} . "\",";
        $json = $json . "\"idGrupo\":\"" . $perfil_aux->{'IdGrupo'} . "\",";
        $json = $json . "\"enviaRequisicion\":\"" . $perfil_aux->{'EnviaRequisicion'} . "\",";
        $json = $json . "\"aprobadorRequisicion\":\"" . $perfil_aux->{'AprobadorRequisicion'} . "\",";
        $json = $json . "\"dimensionSap\":\"" . $perfil_aux->{'DimensionSap'} . "\",";
        $json = $json . "\"almacenSap\":\"" . $perfil_aux->{'AlmacenSap'} . "\",";
        $json = $json . "\"proyectoSap\":\"" . $perfil_aux->{'ProyectoSap'} . "\",";
        $json = $json . "\"entryPerfilWebAprobador\":\"" . $perfil_aux->{'EntryPerfilWebAprobador'} . "\",";
        $json = $json . "\"entryPerfilMovilAprobador\":\"" . $perfil_aux->{'EntryPerfilMovilAprobador'} . "\"";
        $json = $json . "}]";

        $json = $json . ",\"tipos_gto\":[";
        if (count($tipo_gto_array) > 0) {

            $i = 0;
            for ($i = 0; $i < (count($tipo_gto_array) - 1); $i++) {
                $tipo_gto_Aux = $tipo_gto_array[$i];
                $tipo_gto_Aux = json_encode($tipo_gto_Aux);
                $tipo_gto_Aux = json_decode($tipo_gto_Aux);

                $json = $json . "{";
                $json = $json . "\"sincronizado\":\"1\",";
                $json = $json . "\"tipoGasto\":\"" . $tipo_gto_Aux->{'EntryTipoGto'} . "\",";
                $json = $json . "\"descripcion\":\"" . $tipo_gto_Aux->{'NombreGasto'} . "\",";
                $json = $json . "\"cuenta\":\"" . $tipo_gto_Aux->{'Cuenta'} . "\",";
                $json = $json . "\"company\":\"" . $tipo_gto_Aux->{'EntryComWeb'} . "\",";
                $json = $json . "\"exigeCampo1\":\"" . $tipo_gto_Aux->{'ExigeCampo1'} . "\",";
                $json = $json . "\"exigeCampo2\":\"" . $tipo_gto_Aux->{'ExigeCampo2'} . "\",";
                $json = $json . "\"exigeCampo3\":\"" . $tipo_gto_Aux->{'ExigeCampo3'} . "\",";
                $json = $json . "\"nombreCampo1\":\"" . $tipo_gto_Aux->{'NombreCampo1'} . "\",";
                $json = $json . "\"nombreCampo2\":\"" . $tipo_gto_Aux->{'NombreCampo2'} . "\",";
                $json = $json . "\"nombreCampo3\":\"" . $tipo_gto_Aux->{'NombreCampo3'} . "\",";
                $json = $json . "\"tipoCampo1\":\"" . $tipo_gto_Aux->{'TipoCampo1'} . "\",";
                $json = $json . "\"tipoCampo2\":\"" . $tipo_gto_Aux->{'TipoCampo2'} . "\",";
                $json = $json . "\"tipoCampo3\":\"" . $tipo_gto_Aux->{'TipoCampo3'} . "\",";
                $json = $json . "\"grupo01\":\"" . $tipo_gto_Aux->{'Grupo01'} . "\",";
                $json = $json . "\"grupo02\":\"" . $tipo_gto_Aux->{'Grupo02'} . "\",";
                $json = $json . "\"grupo03\":\"" . $tipo_gto_Aux->{'Grupo03'} . "\",";
                $json = $json . "\"grupo04\":\"" . $tipo_gto_Aux->{'Grupo04'} . "\",";
                $json = $json . "\"grupo05\":\"" . $tipo_gto_Aux->{'Grupo05'} . "\",";
                $json = $json . "\"grupo06\":\"" . $tipo_gto_Aux->{'Grupo06'} . "\",";
                $json = $json . "\"grupo07\":\"" . $tipo_gto_Aux->{'Grupo07'} . "\",";
                $json = $json . "\"grupo08\":\"" . $tipo_gto_Aux->{'Grupo08'} . "\",";
                $json = $json . "\"impuestoSugerido\":\"" . $tipo_gto_Aux->{'ImpuestoSugerido'} . "\"";
                $json = $json . "},";
            }

            $tipo_gto_Aux = $tipo_gto_array[$i];
            $tipo_gto_Aux = json_encode($tipo_gto_Aux);
            $tipo_gto_Aux = json_decode($tipo_gto_Aux);
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"tipoGasto\":\"" . $tipo_gto_Aux->{'EntryTipoGto'} . "\",";
            $json = $json . "\"descripcion\":\"" . $tipo_gto_Aux->{'NombreGasto'} . "\",";
            $json = $json . "\"cuenta\":\"" . $tipo_gto_Aux->{'Cuenta'} . "\",";
            $json = $json . "\"company\":\"" . $tipo_gto_Aux->{'EntryComWeb'} . "\",";
            $json = $json . "\"exigeCampo1\":\"" . $tipo_gto_Aux->{'ExigeCampo1'} . "\",";
            $json = $json . "\"exigeCampo2\":\"" . $tipo_gto_Aux->{'ExigeCampo2'} . "\",";
            $json = $json . "\"exigeCampo3\":\"" . $tipo_gto_Aux->{'ExigeCampo3'} . "\",";
            $json = $json . "\"nombreCampo1\":\"" . $tipo_gto_Aux->{'NombreCampo1'} . "\",";
            $json = $json . "\"nombreCampo2\":\"" . $tipo_gto_Aux->{'NombreCampo2'} . "\",";
            $json = $json . "\"nombreCampo3\":\"" . $tipo_gto_Aux->{'NombreCampo3'} . "\",";
            $json = $json . "\"tipoCampo1\":\"" . $tipo_gto_Aux->{'TipoCampo1'} . "\",";
            $json = $json . "\"tipoCampo2\":\"" . $tipo_gto_Aux->{'TipoCampo2'} . "\",";
            $json = $json . "\"tipoCampo3\":\"" . $tipo_gto_Aux->{'TipoCampo3'} . "\",";
            $json = $json . "\"grupo01\":\"" . $tipo_gto_Aux->{'Grupo01'} . "\",";
            $json = $json . "\"grupo02\":\"" . $tipo_gto_Aux->{'Grupo02'} . "\",";
            $json = $json . "\"grupo03\":\"" . $tipo_gto_Aux->{'Grupo03'} . "\",";
            $json = $json . "\"grupo04\":\"" . $tipo_gto_Aux->{'Grupo04'} . "\",";
            $json = $json . "\"grupo05\":\"" . $tipo_gto_Aux->{'Grupo05'} . "\",";
            $json = $json . "\"grupo06\":\"" . $tipo_gto_Aux->{'Grupo06'} . "\",";
            $json = $json . "\"grupo07\":\"" . $tipo_gto_Aux->{'Grupo07'} . "\",";
            $json = $json . "\"grupo08\":\"" . $tipo_gto_Aux->{'Grupo08'} . "\",";
            $json = $json . "\"impuestoSugerido\":\"" . $tipo_gto_Aux->{'ImpuestoSugerido'} . "\"";
            $json = $json . "}";
        } $json = $json . "]";


        $json = $json . ",\"grupos_gto\":[";
        if (count($grupo_gto_array) > 0) {

            $i = 0;
            for ($i = 0; $i < (count($grupo_gto_array) - 1); $i++) {
                $grupo_gto_Aux = $grupo_gto_array[$i];
                $grupo_gto_Aux = json_encode($grupo_gto_Aux);
                $grupo_gto_Aux = json_decode($grupo_gto_Aux);

                $json = $json . "{";
                $json = $json . "\"sincronizado\":\"1\",";
                $json = $json . "\"idGrupoWeb\":\"" . $grupo_gto_Aux->{'IdGrupoWeb'} . "\",";
                $json = $json . "\"nombreGrupo\":\"" . $grupo_gto_Aux->{'NombreGrupo'} . "\",";
                $json = $json . "\"company\":\"" . $grupo_gto_Aux->{'EntryComWeb'} . "\",";
                $json = $json . "\"idGrupoSAP\":\"" . $grupo_gto_Aux->{'IdGrupoSAP'} . "\"";
                $json = $json . "},";
            }

            $grupo_gto_Aux = $grupo_gto_array[$i];
            $grupo_gto_Aux = json_encode($grupo_gto_Aux);
            $grupo_gto_Aux = json_decode($grupo_gto_Aux);
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"idGrupoWeb\":\"" . $grupo_gto_Aux->{'IdGrupoWeb'} . "\",";
            $json = $json . "\"nombreGrupo\":\"" . $grupo_gto_Aux->{'NombreGrupo'} . "\",";
            $json = $json . "\"company\":\"" . $grupo_gto_Aux->{'EntryComWeb'} . "\",";
            $json = $json . "\"idGrupoSAP\":\"" . $grupo_gto_Aux->{'IdGrupoSAP'} . "\"";
            $json = $json . "}";
        } $json = $json . "]";

        $json = $json . ",\"impuestos\":[";
        
       
        if (count($impuestos_array) > 0) {
            $i = 0;
            for ($i = 0; $i < count($impuestos_array); $i++) {
                
                $impuestos_array1 = $impuestos_array[$i];				
                $impuestos_array1 = json_encode($impuestos_array1);
                $impuestos_array1 = json_decode($impuestos_array1);

                        $json = $json . "{";
                        $json = $json . "\"iterador\":\"" . $impuestos_array1->{'Iterador'} . "\",";
                        $json = $json . "\"company\":\"" . $impuestos_array1->{'EntryComWeb'} . "\",";
                        $json = $json . "\"impuesto\":\"" . $impuestos_array1->{'Porcentaje'} . "\"";
                        $json = $json . "},";
                
            }
            
			$json= substr($json, 0, strlen($json) - 1); 
        }
        

        $json = $json . "]";

       // echo "ANTESSSS";
        $json = $json . ",\"monedas\":[";
        
        if (count($monedas_array) > 0) {
            $i = 0;
           // echo "DESPUESSSS";
            for ($i = 0; $i < count($monedas_array); $i++) {
                
                $monedas_array1 = $monedas_array[$i];				
                $monedas_array1 = json_encode($monedas_array1);
                $monedas_array1 = json_decode($monedas_array1);

                        $json = $json . "{";
                        $json = $json . "\"iterador\":\"" . $monedas_array1->{'Iterador'} . "\",";
                        $json = $json . "\"company\":\"" . $monedas_array1->{'EntryComWeb'} . "\",";
                        $json = $json . "\"moneda\":\"" . $monedas_array1->{'Moneda'} . "\"";
                        $json = $json . "},";
                
            }
            
			$json= substr($json, 0, strlen($json) - 1); 
        }
        

        $json = $json . "]";

        $json = $json . ",\"legalizaciones\":[";
        if (count($legalizacion_array) > 0) {

            $i = 0;
            for ($i = 0; $i < (count($legalizacion_array) - 1); $i++) {
                $legalizacion_aux = $legalizacion_array[$i];
                $legalizacion_aux = json_encode($legalizacion_aux);
                $legalizacion_aux = json_decode($legalizacion_aux);

                $json = $json . "{";
                $json = $json . "\"sincronizado\":\"1\",";
                $json = $json . "\"cargado\":\"" . $legalizacion_aux->{'Cargado'} . "\",";
                $json = $json . "\"descripcion\":\"" . $legalizacion_aux->{'Descripcion'} . "\",";
                $json = $json . "\"entryPerfilWeb\":\"" . $legalizacion_aux->{'EntryPerfilWeb'} . "\",";
                $json = $json . "\"estado\":\"" . $legalizacion_aux->{'Estado'} . "\",";
                $json = $json . "\"fechaAutorizacion\":\"" . $legalizacion_aux->{'FechaAutorizacion'} . "\",";
                $json = $json . "\"fechaSincronizacion\":\"" . $legalizacion_aux->{'FechaSincronizacion'} . "\",";
                $json = $json . "\"iDLeg\":\"" . $legalizacion_aux->{'IDLeg'} . "\",";
                $json = $json . "\"noAprobacion\":\"" . $legalizacion_aux->{'NoAprobacion'} . "\",";
                $json = $json . "\"valor\":\"" . $legalizacion_aux->{'Valor'} . "\",";
                $json = $json . "\"entryLegWeb\":\"" . $legalizacion_aux->{'EntryLegWeb'} . "\",";
                $json = $json . "\"entryLegMovil\":\"" . $legalizacion_aux->{'EntryLegMovil'} . "\",";
                $json = $json . "\"idTran\":\"" . $legalizacion_aux->{'IdTran'} . "\",";
                $json = $json . "\"SincronizacionSAP\":\"" . $legalizacion_aux->{'SincronizacionSAP'} . "\"";
                $json = $json . "},";
            }

            $legalizacion_aux = $legalizacion_array[$i];
            $legalizacion_aux = json_encode($legalizacion_aux);
            $legalizacion_aux = json_decode($legalizacion_aux);
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"cargado\":\"" . $legalizacion_aux->{'Cargado'} . "\",";
            $json = $json . "\"descripcion\":\"" . $legalizacion_aux->{'Descripcion'} . "\",";
            $json = $json . "\"entryPerfilWeb\":\"" . $legalizacion_aux->{'EntryPerfilWeb'} . "\",";
            $json = $json . "\"estado\":\"" . $legalizacion_aux->{'Estado'} . "\",";
            $json = $json . "\"fechaAutorizacion\":\"" . $legalizacion_aux->{'FechaAutorizacion'} . "\",";
            $json = $json . "\"fechaSincronizacion\":\"" . $legalizacion_aux->{'FechaSincronizacion'} . "\",";
            $json = $json . "\"iDLeg\":\"" . $legalizacion_aux->{'IDLeg'} . "\",";
            $json = $json . "\"noAprobacion\":\"" . $legalizacion_aux->{'NoAprobacion'} . "\",";
            $json = $json . "\"valor\":\"" . $legalizacion_aux->{'Valor'} . "\",";
            $json = $json . "\"entryLegWeb\":\"" . $legalizacion_aux->{'EntryLegWeb'} . "\",";
            $json = $json . "\"entryLegMovil\":\"" . $legalizacion_aux->{'EntryLegMovil'} . "\",";
            $json = $json . "\"idTran\":\"" . $legalizacion_aux->{'IdTran'} . "\",";
            $json = $json . "\"SincronizacionSAP\":\"" . $legalizacion_aux->{'SincronizacionSAP'} . "\"";
            $json = $json . "}";
        } $json = $json . "]";

        $json = $json . ",\"legalizacionesWeb\":[";
        if (count($legalizacionWeb_array) > 0) {
            $i = 0;
            for ($i = 0; $i < (count($legalizacionWeb_array) - 1); $i++) {
                $legalizacion_aux = $legalizacionWeb_array[$i];				
                $legalizacion_aux = json_encode($legalizacion_aux);
                $legalizacion_aux = json_decode($legalizacion_aux);
			
                $json = $json . "{";
                $json = $json . "\"sincronizado\":\"1\",";
                $json = $json . "\"cargado\":\"" . $legalizacion_aux->{'Cargado'} . "\",";
                $json = $json . "\"descripcion\":\"" . $legalizacion_aux->{'Descripcion'} . "\",";
                $json = $json . "\"entryPerfilMovil\":\"" . $legalizacion_aux->{'EntryPerfilMovil'} . "\",";
                $json = $json . "\"entryPerfilWeb\":\"" . $legalizacion_aux->{'EntryPerfilWeb'} . "\",";
                $json = $json . "\"estado\":\"" . $legalizacion_aux->{'Estado'} . "\",";
                $json = $json . "\"fechaAutorizacion\":\"" . $legalizacion_aux->{'FechaAutorizacion'} . "\",";
                $json = $json . "\"fechaSincronizacion\":\"" . $legalizacion_aux->{'FechaSincronizacion'} . "\",";
                $json = $json . "\"iDLeg\":\"" . $legalizacion_aux->{'IDLeg'} . "\",";
                $json = $json . "\"noAprobacion\":\"" . $legalizacion_aux->{'NoAprobacion'} . "\",";
                $json = $json . "\"valor\":\"" . $legalizacion_aux->{'Valor'} . "\",";
                $json = $json . "\"entryLegWeb\":\"" . $legalizacion_aux->{'EntryLegWeb'} . "\",";
                $json = $json . "\"entryLegMovil\":\"" . $legalizacion_aux->{'EntryLegMovil'} . "\",";
                $json = $json . "\"idTran\":\"" . $legalizacion_aux->{'IdTran'} . "\",";
                $json = $json . "\"SincronizacionSAP\":\"" . $legalizacion_aux->{'SincronizacionSAP'} . "\"";
                $json = $json . "},";
            }

            $legalizacion_aux = $legalizacionWeb_array[$i];
            $legalizacion_aux = json_encode($legalizacion_aux);
            $legalizacion_aux = json_decode($legalizacion_aux);
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"cargado\":\"" . $legalizacion_aux->{'Cargado'} . "\",";
            $json = $json . "\"descripcion\":\"" . $legalizacion_aux->{'Descripcion'} . "\",";
                $json = $json . "\"entryPerfilMovil\":\"" . $legalizacion_aux->{'EntryPerfilMovil'} . "\",";
                $json = $json . "\"entryPerfilWeb\":\"" . $legalizacion_aux->{'EntryPerfilWeb'} . "\",";
            $json = $json . "\"estado\":\"" . $legalizacion_aux->{'Estado'} . "\",";
            $json = $json . "\"fechaAutorizacion\":\"" . $legalizacion_aux->{'FechaAutorizacion'} . "\",";
            $json = $json . "\"fechaSincronizacion\":\"" . $legalizacion_aux->{'FechaSincronizacion'} . "\",";
            $json = $json . "\"iDLeg\":\"" . $legalizacion_aux->{'IDLeg'} . "\",";
            $json = $json . "\"noAprobacion\":\"" . $legalizacion_aux->{'NoAprobacion'} . "\",";
            $json = $json . "\"valor\":\"" . $legalizacion_aux->{'Valor'} . "\",";
            $json = $json . "\"entryLegWeb\":\"" . $legalizacion_aux->{'EntryLegWeb'} . "\",";
            $json = $json . "\"entryLegMovil\":\"" . $legalizacion_aux->{'EntryLegMovil'} . "\",";
            $json = $json . "\"idTran\":\"" . $legalizacion_aux->{'IdTran'} . "\",";
            $json = $json . "\"SincronizacionSAP\":\"" . $legalizacion_aux->{'SincronizacionSAP'} . "\"";
            $json = $json . "}";
        } $json = $json . "]";		

        $json = $json . ",\"facturas\":[";
        
        
        if (count($legalizacionWeb_array) > 0) {
            $i = 0;
            for ($i = 0; $i < count($legalizacionWeb_array); $i++) {
                
                $legalizacion_aux = $legalizacionWeb_array[$i];				
                $legalizacion_aux = json_encode($legalizacion_aux);
                $legalizacion_aux = json_decode($legalizacion_aux);
    
                if($legalizacion_aux->{'Cargado'} == 3){					
                    $factura = new Factura();
                    $array_factura = $factura->GetAllLegalizacion($legalizacion_aux->{'EntryLegWeb'});
					
                     for ($j = 0; $j < count($array_factura); $j++) {
                        $factura_aux = $array_factura[$j];
					    $factura_aux = json_encode($factura_aux);
                        $factura_aux = json_decode($factura_aux);
                        $factura_aux->{'Fecha'} = str_replace('-','/',$factura_aux->{'Fecha'});
                        $factura_aux->{'Fecha'} = substr($factura_aux->{'Fecha'},0,10);
                        $json = $json . "{";
                        $json = $json . "\"sincronizado\":\"1\",";
                        $json = $json . "\"entryFactMovil\":\"" . $factura_aux->{'EntryFactMovil'} . "\",";
                        $json = $json . "\"entryPerfilMovil\":\"" . $factura_aux->{'EntryPerfilWeb'} . "\",";
                        $json = $json . "\"entryLegMovil\":\"" . $factura_aux->{'EntryLegWeb'} . "\",";
                        $json = $json . "\"fecha\":\"" . $factura_aux->{'Fecha'} . "\",";
                        $json = $json . "\"iDLeg\":\"" . $factura_aux->{'IDLeg'} . "\",";
                        $json = $json . "\"valor\":\"" . $factura_aux->{'Valor'} . "\",";
                        $json = $json . "\"moneda\":\"" . $factura_aux->{'Moneda'} . "\",";
                        $json = $json . "\"referencia\":\"" . $factura_aux->{'Referencia'} . "\",";
                        $json = $json . "\"documento\":\"" . $factura_aux->{'Documento'} . "\",";
                        $json = $json . "\"tipoDoc\":\"" . $factura_aux->{'TipoDoc'} . "\",";
                        $json = $json . "\"adjunto\":\"" . $factura_aux->{'Adjunto'} . "\",";
                        $json = $json . "\"lineLegSAP\":\"" . $factura_aux->{'LineLegalizacionSAP'} . "\",";
                        $json = $json . "\"comentarioLine\":\"" . $factura_aux->{'ComentarioLine'} . "\",";
                        $json = $json . "\"subTotalSinImpuesto\":\"" . $factura_aux->{'SubTotalSinImpuesto'} . "\",";
                        $json = $json . "\"subTotalImpuesto\":\"" . $factura_aux->{'SubTotalImpuesto'} . "\",";
                        $json = $json . "\"nombreSN\":\"" . $factura_aux->{'NombreSN'} . "\",";
                        $json = $json . "\"entryFactWeb\":\"" . $factura_aux->{'EntryFactWeb'} . "\",";
                        $json = $json . "\"idTransaccion\":\"" . $factura_aux->{'IdTran'} . "\"";
                        $json = $json . "},";
                    }
                    
                }
                
                
            }
            
			$json= substr($json, 0, strlen($json) - 1); 
        }
        

        $json = $json . "]";
        
       //echo $json; exit;
        


        $json = $json . ",\"gastos\":[";
        if (count($legalizacionWeb_array) > 0) {

            $i = 0;
            for ($i = 0; $i < count($legalizacionWeb_array); $i++) {
                $legalizacion_aux = $legalizacionWeb_array[$i];
                $legalizacion_aux = json_encode($legalizacion_aux);
                $legalizacion_aux = json_decode($legalizacion_aux);

                if($legalizacion_aux->{'Cargado'} == 3){
                    $gasto = new Gasto();
                    $array_gasto = $gasto->GetAllgastosLegalizacion($legalizacion_aux->{'EntryLegWeb'});
                    
                    for ($j = 0; $j < count($array_gasto); $j++) {
                        $gasto_aux = $array_gasto[$j];
                        $gasto_aux = json_encode($gasto_aux);
						$gasto_aux = json_decode($gasto_aux);
                        $json = $json . "{";
                        $json = $json . "\"sincronizado\":\"1\",";
                        $json = $json . "\"entryGastoMovil\":\"" . $gasto_aux->{'EntryGastoMovil'} . "\",";
                        $json = $json . "\"entryFactMovil\":\"" . $gasto_aux->{'EntryFactWeb'} . "\",";
                        $json = $json . "\"entryLegMovil\":\"" . $gasto_aux->{'EntryLegWeb'} . "\",";
                        $json = $json . "\"entryPerfilMovil\":\"" . $gasto_aux->{'EntryPerfilWeb'} . "\",";
                        $json = $json . "\"idGasto\":\"" . $gasto_aux->{'IdGasto'} . "\",";
                        $json = $json . "\"impuesto\":\"" . $gasto_aux->{'Impuesto'} . "\",";
                        $json = $json . "\"info1\":\"" . $gasto_aux->{'Info1'} . "\",";
                        $json = $json . "\"info2\":\"" . $gasto_aux->{'Info2'} . "\",";
                        $json = $json . "\"info3\":\"" . $gasto_aux->{'Info3'} . "\",";
                        $json = $json . "\"tipoGasto\":\"" . $gasto_aux->{'EntryTipoGto'} . "\",";
                        $json = $json . "\"valor\":\"" . $gasto_aux->{'Valor'} . "\",";
                        $json = $json . "\"entryGastoWeb\":\"" . $gasto_aux->{'EntryGastoWeb'} . "\",";
                        $json = $json . "\"notas\":\"" . $gasto_aux->{'Notas'} . "\",";
                        $json = $json . "\"idTransaccion\":\"" . $gasto_aux->{'IdTran'} . "\"";
                        $json = $json . "},";
                    }
                }

                
            }
            $json= substr($json, 0, strlen($json) - 1); 
        }

        $json = $json . "]";




        $json = $json . ",\"requisicionesAprobacion\":[";
        if (count($requisiciones_aprobar_array) > 0) {

            $i = 0;
			
            for ($i = 0; $i < (count($requisiciones_aprobar_array) - 1); $i++) {
                $requisicion_Aux = $requisiciones_aprobar_array[$i];
                $requisicion_Aux = json_encode($requisicion_Aux);
                $requisicion_Aux = json_decode($requisicion_Aux);				
				$mensaje= $this->mensajeRequisicion($requisicion_Aux);
				$mensaje= str_replace('"', "'", $mensaje);
                $json = $json . "{";
                $json = $json . "\"sincronizado\":\"1\",";
                $json = $json . "\"entryReqWeb\":\"" . $requisicion_Aux->{'entryReqWeb'} . "\",";
                $json = $json . "\"mensaje\":\"" . $mensaje . "\",";
                $json = $json . "\"fechaSincronizacion\":\"" . $requisicion_Aux->{'fechaSincronizacion'} . "\",";
                $json = $json . "\"entryPerfilWebAprobador\":\"" . $requisicion_Aux->{'entryPerfilWebAprobador'} . "\",";
				$json = $json . "\"entryPerfilMovilAprobador\":\"" . $requisicion_Aux->{'entryPerfilMovilAprobador'} . "\",";
				$json = $json . "\"entryPerfilWebCreador\":\"" . $requisicion_Aux->{'entryPerfilWebCreador'} . "\",";
				$json = $json . "\"entryPerfilMovilCreador\":\"" . $requisicion_Aux->{'entryPerfilMovilCreador'} . "\",";
				$json = $json . "\"perfilCreadorReq\":\"" . $requisicion_Aux->{'perfilCreadorReq'} . "\"";
                $json = $json . "},";
            }

            $requisicion_Aux = $requisiciones_aprobar_array[$i];
            $requisicion_Aux = json_encode($requisicion_Aux);
            $requisicion_Aux = json_decode($requisicion_Aux);
			$mensaje= $this->mensajeRequisicion($requisicion_Aux);
		    $mensaje= str_replace('"', "'", $mensaje);
            $json = $json . "{";
            $json = $json . "\"sincronizado\":\"1\",";
            $json = $json . "\"entryReqWeb\":\"" . $requisicion_Aux->{'entryReqWeb'} . "\",";
            $json = $json . "\"mensaje\":\"" . $mensaje . "\",";
            $json = $json . "\"fechaSincronizacion\":\"" . $requisicion_Aux->{'fechaSincronizacion'} . "\",";
            $json = $json . "\"entryPerfilWebAprobador\":\"" . $requisicion_Aux->{'entryPerfilWebAprobador'} . "\",";
            $json = $json . "\"entryPerfilMovilAprobador\":\"" . $requisicion_Aux->{'entryPerfilMovilAprobador'} . "\",";
			$json = $json . "\"entryPerfilWebCreador\":\"" . $requisicion_Aux->{'entryPerfilWebCreador'} . "\",";
			$json = $json . "\"entryPerfilMovilCreador\":\"" . $requisicion_Aux->{'entryPerfilMovilCreador'} . "\",";
			$json = $json . "\"perfilCreadorReq\":\"" . $requisicion_Aux->{'perfilCreadorReq'} . "\"";
            $json = $json . "}";
        } $json = $json . "]";		
		$json = $json . ",\"requisiciones\":[";
        if (count($requisicionesCreador_array) > 0) {			
            $i = 0;			
            for ($i = 0; $i < count($requisicionesCreador_array); $i++) {
			
                $requisicionCreador_Aux = $requisicionesCreador_array[$i];				
                $requisicionCreador_Aux = json_encode($requisicionCreador_Aux);
                $requisicionCreador_Aux = json_decode($requisicionCreador_Aux);					
                $json = $json . "{";
                $json = $json . "\"entryReqWeb\":\"" . $requisicionCreador_Aux->{'EntryReqWeb'} . "\",";
				$json = $json . "\"estado\":\"" . $requisicionCreador_Aux->{'Estado'} . "\"";
                $json = $json . "},";
				
            }
				$json= substr($json, 0, strlen($json) - 1); 

        } $json = $json . "]";
		
        $json = $json . "}";

        return $json;
    }

    /*  public function verificarAprobacion($data) {
      try {

      $result = array();
      $sql = "SELECT CASE WHEN NoAprobacion = ".$data[1]." THEN true ELSE false END AS NoAprobacion FROM ok1_leg WHERE EntryLegWeb = ".$data[0];
      $stm = $this->db->prepare($sql);
      $stm->execute(array());
      $this->response->result = $stm->fetch();
      $this->response->setResponse(true);
      return $this->response;
      } catch (Exception $e) {
      $this->response->setResponse(false, $e->getMessage());
      $this->response->result = 'false';
      return $this->response;
      }
      } */

    public function verificarAprobacion($data) {
        try {

            $result = array();
            $result2 = array();
            $sql = "SELECT CASE WHEN NoAprobacion = " . $data[1] . " THEN true ELSE false END AS NoAprobacion FROM ok1_leg WHERE EntryLegWeb = " . $data[0];
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result = $stm->fetch();
            $result = (array) $result;
            if ($result['NoAprobacion'] === '1') {
                $sql = "UPDATE ok1_leg SET Estado ='aprobado' WHERE EntryLegWeb=" . $data[0];
                $stm = $this->db->prepare($sql);
                $stm->execute(array());
            }
            $this->response->result = $result;
            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function sincronizarSAP($data) {
        try {
            $result = array();
            $cad = "[";

            $data['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nit']);
            $data['Nit'] = $this->servicio->limpiarCadena($data['Nit']);
            $data['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nombre']);
            $data['Nombre'] = $this->servicio->limpiarCadena($data['Nombre']);
            $data['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['CodigoVerificacion']);
            $data['CodigoVerificacion'] = $this->servicio->limpiarCadena($data['CodigoVerificacion']);
            $data['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['DocEntryCompany']);
            $data['DocEntryCompany'] = $this->servicio->limpiarCadena($data['DocEntryCompany']);

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
                $json;
                $lineas_array = (array) $this->GetLineas($data['DocEntryCompany']);
                for ($i = 0; $i < (count($lineas_array) - 1); $i++) {
                    try {
                        $lineasAux = (array) $lineas_array[$i];
                        $info = $lineasAux['Info1'];
                        if ($lineasAux['Info2'] !== null && $lineasAux['Info2'] !== '' && $lineasAux['Info2'] !== 'null') {
                            $info = $info . " - " . $lineasAux['Info2'];
                        }
                        if ($lineasAux['Info3'] !== null && $lineasAux['Info3'] !== '' && $lineasAux['Info3'] !== 'null') {
                            $info = $info . " - " . $lineasAux['Info3'];
                        }
                        $linea = '{'
                                . '"entryLegWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryLegWeb']) . '",'
                                . '"entryLegMovil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryLegMovil']) . '",'
                                . '"entryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryPerfilWeb']) . '",'
                                . '"idLeg":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['IDLeg']) . '",'
                                . '"descripcionLeg":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['DescripcionLega']) . '",'
                                . '"entryFactWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryFactWeb']) . '",'
                                . '"referencia":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Referencia']) . '",'
                                . '"fecha":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Fecha']) . '",'
                                . '"documento":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Documento']) . '",'
                                . '"tipoDoc":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['TipoDoc']) . '",'
                                . '"moneda":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Moneda']) . '",'
                                . '"entryGastoWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryGastoWeb']) . '",'
                                . '"entryTipoGtoSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryTipoGtoSAP']) . '",'
                                . '"entryTipoGtoWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryTipoGto']) . '",'
                                . '"valor":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Valor']) . '",'
                                . '"impuesto":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Impuesto']) . '",'
                                . '"notas":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Notas']) . '",'
                                . '"notasFact":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['ComentarioLine']) . '",'
                                . '"info1":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info1']) . '",'
                                . '"info2":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info2']) . '",'
                                . '"info3":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info3']) . '"'
                                . '},';
                        $cad = $cad . $linea;
                    } catch (Exception $e) {
                        
                    }
                }
                $lineasAux = (array) $lineas_array[$i];
                $info = $lineasAux['Info1'];
                if ($lineasAux['Info2'] !== null && $lineasAux['Info2'] !== '' && $lineasAux['Info2'] !== 'null') {
                    $info = $info . " - " . $lineasAux['Info2'];
                }
                if ($lineasAux['Info3'] !== null && $lineasAux['Info3'] !== '' && $lineasAux['Info3'] !== 'null') {
                    $info = $info . " - " . $lineasAux['Info3'];
                }
                $linea = '{'
                        . '"entryLegWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryLegWeb']) . '",'
                        . '"entryLegMovil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryLegMovil']) . '",'
                        . '"entryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryPerfilWeb']) . '",'
                        . '"idLeg":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['IDLeg']) . '",'
                        . '"descripcionLeg":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['DescripcionLega']) . '",'
                        . '"entryFactWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryFactWeb']) . '",'
                        . '"referencia":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Referencia']) . '",'
                        . '"fecha":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Fecha']) . '",'
                        . '"documento":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Documento']) . '",'
                        . '"tipoDoc":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['TipoDoc']) . '",'
                        . '"moneda":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Moneda']) . '",'
                        . '"entryGastoWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryGastoWeb']) . '",'
                        . '"entryTipoGtoSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryTipoGtoSAP']) . '",'
                        . '"entryTipoGtoWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryTipoGto']) . '",'
                        . '"valor":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Valor']) . '",'
                        . '"impuesto":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Impuesto']) . '",'
                        . '"notas":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Notas']) . '",'
                        . '"notasFact":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['ComentarioLine']) . '",'
                        . '"info1":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info1']) . '",'
                        . '"info2":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info2']) . '",'
                        . '"info3":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Info3']) . '"'
                        . '}';
                $cad = $cad . $linea;
                $cad = $cad . "]";
                $cad = str_replace('"null"', '""', $cad);
			
                $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al sincronizar lineas');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function GetLineas($data) {
        try {
            $sql = "SELECT * FROM v_legalizacion WHERE LOWER(Estado) = 'aprobado' AND SincronizacionSAP = 0  AND EntryComWeb = " . $data;
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            return $stm->fetchAll();
        } catch (Exception $e) {
            return null;
        }
    }

    public function confirmarSincronizacionLineas($data) {

        try {
            $result = array();
            $cad = "[";
            $gastoAux;

//print_r ($data); exit;
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
                    $gastoAux = $dtdata[$i];
                    $gastoAux['Sincronizado'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $gastoAux['Sincronizado']);
                    $gastoAux['Sincronizado'] = $this->servicio->limpiarCadena($gastoAux['Sincronizado']);

                    $gastoAux['EntryGastoWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $gastoAux['EntryGastoWeb']);
                    $gastoAux['EntryGastoWeb'] = $this->servicio->limpiarCadena($gastoAux['EntryGastoWeb']);

                    $sql = "UPDATE ok1_gto SET SincronizacionSAP = '" . $this->servicio->limpiarCadena($gastoAux['Sincronizado']) . "' WHERE EntryGastoWeb = '" . $this->servicio->limpiarCadena($gastoAux['EntryGastoWeb']) . "'";

                    try {
                        $this->db->prepare($sql)
                                ->execute(array());
                    } catch (Exception $e) {
                        
                    }
                }

                $sql2 = "UPDATE ok1_fact,
						(SELECT t2.EntryFactWeb FROM (SELECT COUNT(1) AS cuenta, EntryFactWeb FROM ok1_gto WHERE EntryFactWeb IN (SELECT DISTINCT (EntryFactWeb) FROM ok1_gto) GROUP BY EntryFactWeb)t1, (SELECT COUNT(1) AS cuenta, EntryFactWeb FROM ok1_gto WHERE SincronizacionSAP = 1 GROUP BY EntryFactWeb)t2 
						WHERE t1.EntryFactWeb = t2.EntryFactWeb AND t1.cuenta=t2.cuenta) t3
						SET SincronizacionSAP = '1' WHERE ok1_fact.EntryFactWeb = t3.EntryFactWeb";
                try {
                    $this->db->prepare($sql2)
                            ->execute(array());
                } catch (Exception $e) {
                    
                }

                $sql3 = "UPDATE ok1_leg,
						     (SELECT t2.EntryLegWeb FROM (SELECT COUNT(1) AS cuenta, EntryLegWeb FROM ok1_fact WHERE EntryLegWeb IN (SELECT DISTINCT (EntryLegWeb) FROM ok1_fact) GROUP BY EntryLegWeb)t1, (SELECT COUNT(1) AS cuenta, EntryLegWeb FROM ok1_fact WHERE SincronizacionSAP = 1 GROUP BY EntryLegWeb)t2 
							  WHERE t1.EntryLegWeb = t2.EntryLegWeb AND t1.cuenta=t2.cuenta) t3
							  SET SincronizacionSAP = '1' WHERE ok1_leg.EntryLegWeb = t3.EntryLegWeb";

                try {
                    $this->db->prepare($sql3)
                            ->execute(array());
                } catch (Exception $e) {
                    
                }


                $this->response->setResponse('1', 'Registros confirmados');
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function reenviarEmail($data) {
        try {
            $sql = "SELECT * FROM v_legalizacion WHERE EntryLegWeb = " . $data . " ORDER BY EntryFactWeb ASC";
            $stm = $this->db->prepare($sql);
            $stm->execute(array());
            $result2 = $stm->fetchAll();
            $result2 = (array) $result2;
            //echo $sql; exit;
            $this->servicio->enviarEmail($result2);
            $this->servicio->enviarEmailAprovador($result2);
            $this->response->setResponse('1', 'Reenvio');
            $this->response->result = 'true';
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }

    public function InsertOrUpdateRequisicion($data) {
        try {
			
            $datos = json_encode($data);
            $datos = json_decode($datos);
            $datos = $datos->{'data'};

            //$datos = json_decode($datos);
            $requisicionAux = $datos->{'requisiciones'};
            $metadatReqAux = $datos->{'metadataRequisicion'};
			$items=$datos->{'items'};

            $requisicion_array;
            $reqExiste;
            $lastId;

            $requisicion = new Requisicion();

            $requisicionAux = json_encode($requisicionAux[0]);
            $requisicionAux = json_decode($requisicionAux);
			
			$metadatReqAux = json_encode($metadatReqAux[0]);
            $metadatReqAux = json_decode($metadatReqAux);
			
			$requisicion_array = [
                "sincronizado" => $metadatReqAux->{'sincronizado'},
                "entryReqWeb" => $metadatReqAux->{'entryReqWeb'},
                "entryReqMovil" => $metadatReqAux->{'entryReqMovil'},
                "estado" => $metadatReqAux->{'estado'},
                "entryPerfilWebAprobador" => $metadatReqAux->{'entryPerfilWebAprobador'},
                "entryPerfilWeb" => $metadatReqAux->{'entryPerfilWeb'},
                "entryPerfilMovil" => $metadatReqAux->{'entryPerfilMovil'},
                "fechaSincronizacion" => $metadatReqAux->{'fechaSincronizacion'},
				"descripcion" => $requisicionAux->{'descripcion'},
				"mensaje" => "",
				"idTran" => $requisicionAux->{'idTran'}
            ];
			

            $reqExiste = $requisicion->GetRequisicionEnviar($requisicion_array);

            $reqExiste = json_encode($reqExiste);
            $reqExiste = (array) json_decode($reqExiste);

            if (!empty($reqExiste)) {
                if ($reqExiste ['message'] === null || $reqExiste ['message'] === '') {					
                    $lastId = $requisicion->Insert($requisicion_array);
					$lastId = (array) $lastId;
                    if ($lastId ['message'] !== null && $lastId ['message'] !== '') {
                        $requisicion_array ["entryReqWeb"] = $lastId ['message'];
						
						for ($i = 0; $i < count($items); $i++) {
                        $itemAux = json_encode($items[$i]);
                        $itemAux = json_decode($itemAux);
                        $item_array = [
                            "sincronizado" => $itemAux->{'sincronizado'},
                            "entryItemMovil" => $itemAux->{'entryItemMovil'},
                            "descripcion" => $itemAux->{'descripcion'},
                            "articulo" => $itemAux->{'articulo'},
                            "articuloCodigo" => $itemAux->{'articuloCodigo'},
                            "articuloNombre" => $itemAux->{'articuloNombre'},
                            "tipo" => $itemAux->{'tipo'},
                            "reqTipo" => $itemAux->{'reqTipo'},
                            "fecha" => $itemAux->{'fecha'},
                            "cantidadSolicitada" => $itemAux->{'cantidadSolicitada'},
                            "cantidadAprobada" => $itemAux->{'cantidadAprobada'},
                            "proveedor" => $itemAux->{'proveedor'},
                            "almacen" => $itemAux->{'almacen'},
                            "grupoArticuloReq" => $itemAux->{'grupoArticuloReq'},
                            "proyecto" => $itemAux->{'proyecto'},
                            "entryReqMovil" => $itemAux->{'entryReqMovil'},
							"entryReqWeb" => $requisicion_array ["entryReqWeb"],
							"entryItemMovilCreador" => $itemAux->{'entryItemMovilCreador'},
                            "idTran" => $itemAux->{'idTran'}
                        ];					
					

                        $requisicion->InsertItem($item_array);
                        //$requisicion->UpdateForaneas($item_array);
                    }
						
                    } else {
                        return $reqExiste;
                    }
                } else {
                    return $reqExiste;
                }
            }
			
			$requisicion_array ["fechaSincronizacion"] = date('Y-m-d H:i:s');			
             $respuestaSincronizacion = $this->responderRequisicion($requisicion_array);
					
            if (!empty($respuestaSincronizacion)) {
                $this->response->setResponse(true, $respuestaSincronizacion);
                return $this->response;
            } else {
                $this->response->setResponse(false, '0');
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function responderRequisicion($requisicion) {
		$requisicion=(array) $requisicion;		
		$mensaje= $this->mensajeRequisicion($requisicion);
		$mensaje= str_replace('"', "'", $mensaje);
        $json = $json . "{";
        $json = $json . "\"sincronizado\":\"1\",";
        $json = $json . "\"entryReqMovil\":\"" . $requisicion['entryReqMovil'] . "\",";
        $json = $json . "\"estado\":\"" . $requisicion['estado'] . "\",";
        $json = $json . "\"entryPerfilWebAprobador\":\"" . $requisicion['entryPerfilWebAprobador'] . "\",";
        $json = $json . "\"entryPerfilWeb\":\"" . $requisicion['entryPerfilWeb'] . "\",";
        $json = $json . "\"entryPerfilMovil\":\"" . $requisicion['entryPerfilMovil'] . "\",";
        $json = $json . "\"fechaAutorizacion\":\"" . $requisicion['fechaAutorizacion'] . "\",";
        $json = $json . "\"fechaSincronizacion\":\"" . $requisicion['fechaSincronizacion'] . "\",";
        $json = $json . "\"sincronizacionSAP\":\"" . $requisicion['sincronizacionSAP'] . "\",";
        $json = $json . "\"sincronizacionAprobador\":\"" . $requisicion['sincronizacionAprobador'] . "\",";
        $json = $json . "\"entryReqWeb\":\"" . $requisicion['entryReqWeb'] . "\",";
		$json = $json . "\"mensaje\":\"" . $mensaje . "\",";
        $json = $json . "\"descripcion\":\"" . $requisicion['descripcion'] . "\"";
        $json = $json . "}";
        return $json;
    }
	
	    public function GetLineasReq($data) {
        try {
            $sql = "SELECT * FROM ok1_ite WHERE EntryReqWeb = " . $data;
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            return $stm->fetchAll();
        } catch (Exception $e) {
            return null;
        }
    }
	
	
	 public function mensajeRequisicion($requisicion_Aux) {		
				$requisicion_Aux=(array)$requisicion_Aux;
												
				$json='{';
				$json=$json .'"metadataRequisicion":[{';
				$json=$json .'"entryReqWeb":"'.$requisicion_Aux["entryReqWeb"].'",';
				$json=$json .'"entryReqMovil":"'.$requisicion_Aux["entryReqMovil"].'",';
				$json=$json .'"estado":"'.$requisicion_Aux["estado"].'",';
				$json=$json .'"entryPerfilWebAprobador":"'.$requisicion_Aux["entryPerfilWebAprobador"].'",';
				$json=$json .'"entryPerfilWeb":"'.$requisicion_Aux["entryPerfilWeb"].'",';
				$json=$json .'"entryPerfilMovil":"'.$requisicion_Aux["entryPerfilMovil"].'",';
				$json=$json .'"sincronizado":"'.$requisicion_Aux["sincronizado"].'",';
				$json=$json .'"fechaSincronizacion":"'.$requisicion_Aux["fechaSincronizacion"].'",';
				$json=$json .'"idTran":"'.$requisicion_Aux["idTran"].'"';
				$json=$json .'}]';
				$json=$json .',"requisiciones":[{';
				$json=$json .'"entryReqMovil":"'.$requisicion_Aux["entryReqMovil"].'",';
				$json=$json .'"cargado":"0",';
				$json=$json .'"descripcion":"'.$requisicion_Aux["descripcion"].'",';
				$json=$json .'"entryPerfilMovil":"'.$requisicion_Aux["entryPerfilMovil"].'",';
				$json=$json .'"estado":"'.$requisicion_Aux["estado"].'",';
				$json=$json .'"fechaAutorizacion":"'.$requisicion_Aux["fechaAutorizacion"].'",';
				$json=$json .'"fechaSincronizacion":"'.$requisicion_Aux["fechaSincronizacion"].'",';
				$json=$json .'"iDReq":"0",';
				$json=$json .'"noAprobacion":"0",';
				$json=$json .'"entryReqWeb":"'.$requisicion_Aux["entryReqWeb"].'",';
				$json=$json .'"idTran":"'.$requisicion_Aux["idTran"].'"';	
				$json=$json .'}]';
				$json=$json .',"items":[';
				
				$items = $this->GetLineasReq($requisicion_Aux["entryReqWeb"]);	

				if (count($items) > 0) {					
					for ($i = 0; $i < count($items); $i++) {
						$item_Aux = (array)$items[$i];						
						$json=$json .'{';
						$json=$json .'"sincronizado":"'.$item_Aux["Sincronizado"].'",';
						$json=$json .'"entryItemMovil":"'.$item_Aux["EntryItemMovil"].'",';
						$json=$json .'"descripcion":"'.$item_Aux["Descripcion"].'",';
						$json=$json .'"articulo":"'.$item_Aux["Articulo"].'",';
						$json=$json .'"articuloCodigo":"'.$item_Aux["ArticuloCodigo"].'",';
						$json=$json .'"articuloNombre":"'.$item_Aux["ArticuloNombre"].'",';
						$json=$json .'"tipo":"'.$item_Aux["Tipo"].'",';
						$json=$json .'"reqTipo":"'.$item_Aux["ReqTipo"].'",';
						$json=$json .'"fecha":"'.$item_Aux["Fecha"].'",';
						$json=$json .'"cantidadSolicitada":"'.$item_Aux["CantidadSolicitada"].'",';
						$json=$json .'"cantidadAprobada":"'.$item_Aux["CantidadAprobada"].'",';
						$json=$json .'"proveedor":"'.$item_Aux["Proveedor"].'",';
						$json=$json .'"almacen":"'.$item_Aux["Almacen"].'",';
					    $json=$json .'"grupoArticuloReq":"'.$item_Aux["GrupoArticuloReq"].'",';
						$json=$json .'"proyecto":"'.$item_Aux["Proyecto"].'",';
						$json=$json .'"proveedor":"'.$item_Aux["Proveedor"].'",';
						$json=$json .'"entryReqMovil":"'.$item_Aux["EntryReqMovil"].'",';
						$json=$json .'"idTran":"'.$item_Aux["IdTran"].'"';
						$json=$json .'},';												
					}
					$json= substr($json, 0, strlen($json) - 1);
				}
				$json=$json .']';				
				$json=$json .'}';          
        return $json;
    }
	
	public function InsertOrUpdateRequisicionAprobacion($data) {
        try {		 	
            $datos = json_encode($data);
            $datos = json_decode($datos);
			
            $datos= (array)$datos->{'data'};
			
		    $json="[";					
            //$datos = json_decode($datos);
            $requisiciones = $datos['requisiciones'];			
			$items=$datos['items'];
            $requisicion_array;
            $requisicion = new Requisicion();
			      			
			/*for ($i = 0; $i < count($requisiciones); $i++) {
		    $requisicionAux = $requisiciones[$i];
			$requisicion_array = [
                "sincronizado" => $requisicionAux['sincronizado'],
                "entryReqWeb" => $requisicionAux['entryReqWeb'],
                "entryReqMovil" => $requisicionAux['entryReqMovil'],
                "estado" => $requisicionAux['estado'],
                "entryPerfilWebAprobador" => $requisicionAux['entryPerfilWebAprobador'],
                "entryPerfilWeb" => $requisicionAux['entryPerfilWeb'],
                "entryPerfilMovil" => $requisicionAux['entryPerfilMovil'],
                "fechaSincronizacion" => $requisicionAux['fechaSincronizacion'],
				"descripcion" => $requisicionAux['descripcion'],
				"idTran" => $requisicionAux['idTran']
            ];}*/
			
			$entryReqWeb='';
			for ($i = 0; $i < count($items); $i++) {			
            $itemAux = (array)$items[$i];
				for ($j = 0; $j < count($requisiciones); $j++) {
					$requisicionAux=(array)$requisiciones[$j];
					if($itemAux['entryReqMovil']=== $requisicionAux['entryReqMovil']){
						$entryReqWeb=$requisicionAux['entryReqWeb'];
					}
				}		
					$item_array = [
                            "sincronizado" => $itemAux['sincronizado'],
                            "entryItemMovil" => $itemAux['entryItemMovil'],							
                            "descripcion" => $itemAux['descripcion'],
                            "articulo" => $itemAux['articulo'],
                            "articuloCodigo" => $itemAux['articuloCodigo'],
                            "articuloNombre" => $itemAux['articuloNombre'],
                            "tipo" => $itemAux['tipo'],
                            "reqTipo" => $itemAux['reqTipo'],
                            "fecha" => $itemAux['fecha'],
                            "cantidadSolicitada" => $itemAux['cantidadSolicitada'],
                            "cantidadAprobada" => $itemAux['cantidadAprobada'],
                            "proveedor" => $itemAux['proveedor'],
                            "almacen" => $itemAux['almacen'],
                            "grupoArticuloReq" => $itemAux['grupoArticuloReq'],
                            "proyecto" => $itemAux['proyecto'],
                            "entryReqMovil" => $itemAux['entryReqMovil'],
							"entryReqWeb" => $entryReqWeb,
							"entryItemMovilCreador" => $itemAux['entryItemMovilCreador'],
                            "idTran" => $itemAux['idTran']
                        ];				
					
						if($item_array['entryItemMovilCreador']==='-1'){
                            $requisicion->InsertItem($item_array);
						}else{
					        $requisicion->UpdateItemAprobacion($item_array);
						}
                        //$requisicion->UpdateForaneas($item_array);						
                    }	
					
					for ($j = 0; $j < count($requisiciones); $j++) {
					$requisicionAux=(array)$requisiciones[$j];
					try{
							$requisicion->UpdateReqAprobacion($requisicionAux);
								$json = $json . '{"entryReqWeb":"' . $requisicionAux ["entryReqWeb"] . '","sincronizado":"1"},';					
						}catch(Exception $e1){
								$json = $json . '{"entryReqWeb":"' . $requisicionAux ["entryReqWeb"] . '","sincronizado":"0"},';
						} 
				}
				$json= substr($json, 0, strlen($json) - 1); 
				$json=$json."]";
                $this->response->setResponse(true, $json);
                return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
	
	
    public function GetLineasRequisicion($data) {
        try {
            $sql = "SELECT * FROM v_requisicion WHERE LOWER(Estado) = 'aprobada' AND SincronizacionSAP = 0  AND EntryComWeb = " . $data;
			//echo($sql); exit;
            $stm = $this->db->prepare($sql);
            $stm->execute(array($data));
            return $stm->fetchAll();
        } catch (Exception $e) {
            return null;
        }
    }
    
    public function sincronizarLineasReqSAP($data) {
        try {
            $result = array();
            $cad = "[";
		

            $data['Nit'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nit']);
            $data['Nit'] = $this->servicio->limpiarCadena($data['Nit']);
            $data['Nombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['Nombre']);
            $data['Nombre'] = $this->servicio->limpiarCadena($data['Nombre']);
            $data['CodigoVerificacion'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['CodigoVerificacion']);
            $data['CodigoVerificacion'] = $this->servicio->limpiarCadena($data['CodigoVerificacion']);
            $data['DocEntryCompany'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $data['DocEntryCompany']);
            $data['DocEntryCompany'] = $this->servicio->limpiarCadena($data['DocEntryCompany']);

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
                $json;
                $lineas_array = (array) $this->GetLineasRequisicion($data['DocEntryCompany']);
                if(count($lineas_array)>0){
				for ($i = 0; $i < count($lineas_array); $i++) {
                    try {
                        $lineasAux = (array) $lineas_array[$i];
                      
                        $linea = '{'
                                . '"entryReqWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryReqWeb']) . '",'
                                . '"entryReqMovil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryReqMovil']) . '",'
                                . '"estado":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Estado']) . '",'
                                . '"entryPerfilWebAprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryPerfilWebAprobador']) . '",'
                                . '"entryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryPerfilWeb']) . '",'
                                . '"entryPerfilMovil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryPerfilMovil']) . '",'
                                . '"sincronizado":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Sincronizado']) . '",'
                                . '"sincronizacionSAP":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['SincronizacionSAP']) . '",'
                                . '"sincronizacionAprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['SincronizacionAprobador']) . '",'
                                . '"fechaSincronizacion":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['FechaSincronizacion']) . '",'
                                . '"fechaAutorizacion":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['FechaAutorizacion']) . '",'
                                . '"mensaje":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Mensaje']) . '",'
                                . '"descripcionReq":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['DescripcionReq']) . '",'
                                . '"idTran":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['IdTran']) . '",'
                                . '"descripcionItem":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['DescripcionItem']) . '",'
                                . '"articulo":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Articulo']) . '",'
                                . '"articuloCodigo":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['ArticuloCodigo']) . '",'
                                . '"articuloNombre":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['ArticuloNombre']) . '",'
                                . '"tipo":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Tipo']) . '",'
                                . '"reqTipo":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['ReqTipo']) . '",'
                                . '"fecha":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Fecha']) . '",'
                                . '"cantidadSolicitada":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['CantidadSolicitada']) . '",'
                                . '"cantidadAprobada":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['CantidadAprobada']) . '",'
                                . '"proveedor":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Proveedor']) . '",'
                                . '"almacen":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['Almacen']) . '",'
                                . '"grupoArticuloReq":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['GrupoArticuloReq']) . '",'
                                . '"entryItemMovil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryItemMovil']) . '",'
                                . '"entryItemWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryItemWeb']) . '",'
                                . '"entryItemMovilCreador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $lineasAux['EntryItemMovilCreador']) . '"'
                                . '},';
                        $cad = $cad . $linea;
                    } catch (Exception $e) {
                        
                    }
                }
				 $cad= substr($cad, 0, strlen($cad) - 1); 
			}
               
                $cad = $cad . "]";
                $cad = str_replace('"null"', '""', $cad);
                $this->response->setResponse('1', $cad);
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al sincronizar lineas');
            $this->response->result = 'false';
            return $this->response;
        }
    }
    
    
    public function confirmarSincronizacionLineasReq($data) {

        try {
            $result = array();
            $cad = "[";
            $gastoAux;

//print_r ($data); exit;
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
                    $gastoAux = $dtdata[$i];
                    $gastoAux['Sincronizado'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $gastoAux['Sincronizado']);
                    $gastoAux['Sincronizado'] = $this->servicio->limpiarCadena($gastoAux['Sincronizado']);

                    $gastoAux['EntryItemWeb'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $gastoAux['EntryItemWeb']);
                    $gastoAux['EntryItemWeb'] = $this->servicio->limpiarCadena($gastoAux['EntryItemWeb']);

                    $sql = "UPDATE ok1_ite SET SincronizacionSAP = '" . $this->servicio->limpiarCadena($gastoAux['Sincronizado']) . "' WHERE EntryItemWeb = '" . $this->servicio->limpiarCadena($gastoAux['EntryItemWeb']) . "'";

                    try {
                        $this->db->prepare($sql)
                                ->execute(array());
                    } catch (Exception $e) {
                        
                    }
                }

                    $sql2 = "UPDATE ok1_req,
			(SELECT t2.EntryReqWeb FROM (SELECT COUNT(1) AS cuenta, 
                        EntryReqWeb FROM ok1_ite WHERE EntryReqWeb IN 
                        (SELECT DISTINCT (EntryReqWeb) FROM ok1_ite) GROUP BY EntryReqWeb)t1, 
                        (SELECT COUNT(1) AS cuenta,EntryReqWeb FROM ok1_ite 
                        WHERE SincronizacionSAP = 1 GROUP BY EntryReqWeb)t2
                        WHERE t1.EntryReqWeb = t2.EntryReqWeb AND t1.cuenta=t2.cuenta) t3
                        SET SincronizacionSAP = '1', Estado = 'enviada' WHERE ok1_req.EntryReqWeb = t3.EntryReqWeb";

                try {
                    $this->db->prepare($sql2)
                            ->execute(array());
                } catch (Exception $e) {
                    
                }

               
                $this->response->setResponse('1', 'Registros confirmados');
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }
	
	 public function sincronizarDatosConexion($data) {

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
                for ($i = 0; $i < count($dtdata); $i++) {
                    $objAux = $dtdata[$i];
                    $objAux['Servidor'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['Servidor']);
                    $objAux['Servidor'] = $this->servicio->limpiarCadena($objAux['Servidor']);

                    $objAux['ServidorDeLicencias'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['ServidorDeLicencias']);
                    $objAux['ServidorDeLicencias'] = $this->servicio->limpiarCadena($objAux['ServidorDeLicencias']);

                    $objAux['ServidorTipo'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['ServidorTipo']);
                    $objAux['ServidorTipo'] = $this->servicio->limpiarCadena($objAux['ServidorTipo']);

                    $objAux['ServidorTipoNombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['ServidorTipoNombre']);
                    $objAux['ServidorTipoNombre'] = $this->servicio->limpiarCadena($objAux['ServidorTipoNombre']);

                    $objAux['ServidorNombre'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['ServidorNombre']);
                    $objAux['ServidorNombre'] = $this->servicio->limpiarCadena($objAux['ServidorNombre']);

                    $objAux['Usuario'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['Usuario']);
                    $objAux['Usuario'] = $this->servicio->limpiarCadena($objAux['Usuario']);

                    $objAux['Clave'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['Clave']);
                    $objAux['Clave'] = $this->servicio->limpiarCadena($objAux['Clave']);

                    $objAux['NombreBD'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $objAux['NombreBD']);
                    $objAux['NombreBD'] = $this->servicio->limpiarCadena($objAux['NombreBD']);

                    $sql = "INSERT INTO ok1_data_con (EntryComWeb,Driver,Servidor,ServidorLicencia,
                                                      ServidorTipo,ServidorTipoNombre,ServidorNombre,
                                                      Usuario,Clave,BaseDatos) VALUES ("
                            . "'" . $dtcompany['DocEntryCompany'] . "',"
                            . "'SAPbobsCOM.Company',"
                            . "'" . $objAux['Servidor'] . "',"
                            . "'" . $objAux['ServidorDeLicencias'] . "',"
                            . "'" . $objAux['ServidorTipo'] . "',"
                            . "'" . $objAux['ServidorTipoNombre'] . "',"
                            . "'" . $objAux['ServidorNombre'] . "',"
                            . "'" . $objAux['Usuario'] . "',"
                            . "'" . $objAux['Clave'] . "',"
                            . "'" . $objAux['NombreBD'] . "')";

                    try {
                        $this->db->prepare($sql)
                                ->execute(array());
                    } catch (Exception $e) {
                        
                    }
                }
                $this->response->setResponse('1', 'registrados datos de conexion');
                $this->response->result = 'true';
                return $this->response;
            }
        } catch (Exception $e) {
            $this->response->setResponse('0', 'Error al confirmar sincronizacion');
            $this->response->result = 'false';
            return $this->response;
        }
    }
    

}
