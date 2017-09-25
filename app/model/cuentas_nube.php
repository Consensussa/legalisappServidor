<?php



namespace App\Model;



use App\Lib\Database;

use App\Lib\Response;

use App\Model\Servicio;



class Cuentas_Nube {



    private $db;

    private $table = 'ok1_cuentas_nube';

    private $response;

    private $primary = 'Id_cuenta';

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



    public function sincronizarCuentasNube($data) {

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

                    $legConfMovilAux['CuentaUsuario'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['CuentaUsuario']);

                    $legConfMovilAux['CuentaUsuario'] = $this->servicio->limpiarCadena($legConfMovilAux['CuentaUsuario']);

                    if ($legConfMovilAux['Password'] !==null && $legConfMovilAux['Password']!=='') {

				    $legConfMovilAux['Password'] = $this->servicio->descifrar($this->servicio->getKey(), $this->servicio->getIv(), $legConfMovilAux['Password']);

                    $legConfMovilAux['Password'] = $this->servicio->limpiarCadena($legConfMovilAux['Password']);

                    }

					

				   

				    

					

							

					//$sql= 	str_replace("''", "null", $sql);

					

                     try {



                        $sql = "SELECT EntryComWeb FROM ok1_cuentas_nube WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "'";

                        $stm = $this->db->prepare($sql);

                        $stm->execute(array());

                        $result = $stm->fetch();

                        $result = (array) $result;

                        if ($dtcompany['DocEntryCompany'] == $result['EntryComWeb']) {

                            $sql1="UPDATE ok1_cuentas_nube SET UserId ='" . $legConfMovilAux['CuentaUsuario'] . "', Password ='" . $legConfMovilAux['Password'] . "' WHERE EntryComWeb = '" . $dtcompany['DocEntryCompany'] . "'";

                        }else{

                            $sql1 = "INSERT INTO ok1_cuentas_nube (UserId,Password, EntryComWeb) VALUES ('" . $legConfMovilAux['CuentaUsuario'] . "','" . $legConfMovilAux['Password'] . "','" . $dtcompany['DocEntryCompany'] . "')";

                        }





                         $this->db->prepare($sql1)

                                ->execute(array()); 

                         $resId = $this->db->lastInsertId();

                           $cad= $cad.'{"CuentaUsuario": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$resId).'", "CuentaUsuario":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['CuentaUsuario']).'"},';

                    } catch (Exception $e) {

                         $cad= $cad.'{"CuentaUsuario": "'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),'0').'", "CuentaUsuario":"'.$this->servicio->cifrar($this->servicio->getKey(), $this->servicio->getIv(),$legConfMovilAux['CuentaUsuario']).'"},';

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