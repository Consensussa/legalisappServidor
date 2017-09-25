<?php



namespace App\Model;



use App\Lib\Database;

use App\Lib\Response;

use App\Model\Servicio;



class Monedas_Cia {



    private $db;

    private $table = 'ok1_monedas';

    private $response;

    private $primary = 'Id_moneda';

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
    //echo $data;exit;
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



    public function sincronizarMonedasNube($data) {

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

                for ($i = 0; $i < (count($dtdata)); $i++) {
                    $legConfMovilAux = $dtdata[$i];
                     try {



                        $sql = "SELECT EntryComWeb FROM ok1_monedas WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "'";

                        $sql2 = "SELECT Iterador FROM ok1_monedas WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "' AND Iterador = '" . $legConfMovilAux['Iterador'] . "'";

                        $stm = $this->db->prepare($sql);

                        $stm->execute(array());

                        $result = $stm->fetch();

                        $result = (array) $result;

                        $stm2 = $this->db->prepare($sql2);

                        $stm2->execute(array());

                        $result2 = $stm2->fetch();

                        $result2 = (array) $result2;

                        if ($dtcompany['DocEntryCompany'] == $result['EntryComWeb'] && $legConfMovilAux['Iterador'] == $result2['Iterador']) {

                            $sql1="UPDATE ok1_monedas SET Moneda ='" . $legConfMovilAux['Moneda'] . "' WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "' AND Iterador = '" . $legConfMovilAux['Iterador'] . "'";

                        }else{

                            $sql1 = "INSERT INTO ok1_monedas (Iterador, Moneda, EntryComWeb) VALUES ('" . $legConfMovilAux['Iterador'] . "','" . $legConfMovilAux['Moneda'] . "','" . $dtcompany['DocEntryCompany'] . "')";

                        }





                         $this->db->prepare($sql1)

                                ->execute(array()); 

                         $resId = $this->db->lastInsertId();

                           $cad= $cad.'{"Moneda": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$resId).'", "Moneda":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['Moneda']).'"},';

                    } catch (Exception $e) {

                         $cad= $cad.'{"Moneda": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),'0').'", "Moneda":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['Moneda']).'"},';

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