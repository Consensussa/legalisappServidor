<?php

namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Model\Servicio;

class Leg_ConfMovil {

    private $db;
    private $table = 'ok1_leg_confmovil';
    private $response;
    private $primary = 'EntryLegConfWeb';
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
                            Descripcion          = ?
                        WHERE $this->primary = ?";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['Descripcion'],
                                $data['TipoGasto']
                            )
            );

            $this->response->setResponse($data);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Insert($data) {
        print_r($data);
        exit;

        try {

            $sql = "INSERT INTO $this->table
                     VALUES (?,?)";

            $this->db->prepare($sql)
                    ->execute(
                            array(
                                $data['TipoGasto'],
                                $data['Descripcion']
                            )
            );
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

    public function sincronizarLegConfMovilSAP($data) {
        try {
            $result = array();
            $cad = "[";
            $legConfMovilAux;

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
                $sql = "SELECT EntryPerfilWeb, DocPerfil, Aprobador FROM $this->table WHERE SincronizacionSAP=0 AND Company=" . $data['DocEntryCompany'];
                $stm = $this->db->prepare($sql);
                $stm->execute();
                $this->response->setResponse(true);
                $result = $stm->fetchAll();
                $result = (array) $result;
                $i = 0;
                for ($i = 0; $i < (count($result) - 1); $i++) {
                    $legConfMovilAux = $result[$i];
                    $legConfMovilAux = json_encode($legConfMovilAux);
                    $cad = $cad . '{"aprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'Aprobador'}) . '", '
                            . '"docEntryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'EntryPerfilWeb'}) . '",'
                            . '"DocPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'DocPerfil'}) . '"},';
                }
                $legConfMovilAux = $result[$i];
                $legConfMovilAux = json_encode($legConfMovilAux);
                $cad = $cad . '{"aprobador":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'Aprobador'}) . '", '
                        . '"docEntryPerfilWeb":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'EntryPerfilWeb'}) . '",'
                        . '"docPerfil":"' . $this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux->{'DocPerfil'} . DocPerfil) . '"}';
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

}
