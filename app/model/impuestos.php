<?php



namespace App\Model;



use App\Lib\Database;

use App\Lib\Response;

use App\Model\Servicio;



class Impuestos_Cia {



    private $db;

    private $table = 'ok1_impuestos';

    private $response;

    private $primary = 'Id_impuesto';

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
            $sql = "SELECT * FROM $this->table WHERE EntryComWeb IN (" . $data.")";
            //echo $sql;exit;
            $stm = $this->db->prepare($sql);

            $stm->execute();
            $result = $stm->fetchAll();
            $result = (array) $result;
            return $result;
        } catch (Exception $e) {
            return '-1';
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



    public function sincronizarImpuestosNube($data) {
    
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
                //print_r($dtdata);exit;
                for ($i = 0; $i < (count($dtdata)); $i++) {
                    $legConfMovilAux = $dtdata[$i];
                     try {



                        $sql = "SELECT EntryComWeb FROM ok1_impuestos WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "'";

                        $sql2 = "SELECT Iterador FROM ok1_impuestos WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "' AND Iterador = '" . $legConfMovilAux['Iterador'] . "'";

                        $stm = $this->db->prepare($sql);

                        $stm->execute(array());

                        $result = $stm->fetch();

                        $result = (array) $result;

                        $stm2 = $this->db->prepare($sql2);

                        $stm2->execute(array());

                        $result2 = $stm2->fetch();

                        $result2 = (array) $result2;

                         if ($dtcompany['DocEntryCompany'] == $result['EntryComWeb'] && $legConfMovilAux['Iterador'] == $result2['Iterador']) {

                            $sql1="UPDATE ok1_impuestos SET Porcentaje ='" . $legConfMovilAux['Porcentaje'] . "' WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "' AND Iterador = '" . $legConfMovilAux['Iterador'] . "'";

                        }else{

                            $sql1 = "INSERT INTO ok1_impuestos (Iterador, Porcentaje, EntryComWeb) VALUES ('" . $legConfMovilAux['Iterador'] . "','" . $legConfMovilAux['Porcentaje'] . "','" . $dtcompany['DocEntryCompany'] . "')";

                        }

                        
                        


                         $this->db->prepare($sql1)

                                ->execute(array()); 

                         $resId = $this->db->lastInsertId();

                           $cad= $cad.'{"PorcentajeImpusto": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$resId).'", "PorcentajeImpusto":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['PorcentajeImpusto']).'"},';

                    } catch (Exception $e) {

                         $cad= $cad.'{"PorcentajeImpusto": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),'0').'", "PorcentajeImpusto":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['PorcentajeImpusto']).'"},';

                    }

                }

                $cad= substr($cad, 0, strlen($cad) - 1); 

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