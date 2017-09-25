<?php

namespace App\Lib;

class DatabaseDIAPI {

    private $baseDatos = '';
    private $servidor = '';
    private $usuarioDB = '';
    private $claveDB = '';
    private $usuario = '';
    private $clave = '';
    private $driver = '';
    private $servidorLicencia = '';
    private $servidorTipo = '';
    private $oComp = null;

    public function __CONSTRUCT_ALL($baseDatos, $servidor, $usuarioDB, $claveDB, $usuario, $clave, $driver, $servidorLicencia, $servidorTipo) {
		
        $this->baseDatos = $baseDatos;
        $this->servidor = $servidor;
        $this->usuarioDB = $usuarioDB;
        $this->claveDB = $claveDB;
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->driver = $driver;
        $this->servidorLicencia = $servidorLicencia;
        $this->servidorTipo = $servidorTipo;
    }

    public function getBaseDatos() {
        return $this->baseDatos;
    }

    public function setBaseDatos($baseDatos) {
        $this->baseDatos = $baseDatos;
    }

    public function getServidor() {
        return $this->servidor;
    }

    public function setServidor($servidor) {
        $this->servidor = $servidor;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function getDriver() {
        return $this->driver;
    }

    public function setDriver($driver) {
        $this->driver = $driver;
    }

    public function getUsuarioDB() {
        return $this->usuarioDB;
    }

    public function setUsuarioDB($usuarioDB) {
        $this->usuarioDB = $usuarioDB;
    }

    public function getClaveDB() {
        return $this->claveDB;
    }

    public function setClaveDB($claveDB) {
        $this->claveDB = $claveDB;
    }

    public function getServidorTipo() {
        return $this->servidorTipo;
    }

    public function setServidorTipo($servidorTipo) {
        $this->servidorTipo = $servidorTipo;
    }

    public function getServidorLicencia() {
        return $this->servidorLicencia;
    }

    public function setServidorLicencia($servidorLicencia) {
        $this->servidorLicencia = $servidorLicencia;
    }

    public function getOComp() {
        return $this->oComp;
    }

    public function setOComp($oComp) {
        $this->oComp = $oComp;
    }

    public function openConn() {
        try {			
            $this->oComp = new COM($this->getDriver());
			//echo 'llego1'; exit;
            $this->oComp->Server = $this->getServidor();
            $this->oComp->LicenseServer = $this->getServidorLicencia();
            $this->oComp->DBServerType = $this->getServidorTipo();
            $this->oComp->UserName = $this->getUsuario();
            $this->oComp->Password = $this->getClave();
            $this->oComp->CompanyDB = $this->getBaseDatos();
			echo 'llego';
            $this->oComp->Connect;
            return true;
        } catch (com_exception $expt) {
            echo "An error occured";
            echo $expt->getMessage();
            echo $this->oComp->GetLastErrorDescription;
            return false;
        } catch (exception $expt) {
            echo $expt->getMessage();
            return false;
        }
    }

    public function closeConn() {
        try {
            $this->oComp->Disconnect();
            return true;
        } catch (com_exception $expt) {
            echo "An error occured";
            echo $expt->getMessage();
            echo $this->oComp->GetLastErrorDescription;
            return false;
        } catch (exception $expt) {
            echo $expt->getMessage();
            return false;
        }
    }

    public function executeQuery($sql) {
        try {
            if ($this->getOComp()->Connected) {
                $oRecordSet = $this->getOComp()->GetBusinessObject(300);
                return $oRecordSet->DoQuery($sql);
            } else {
                return false;
            }
        } catch (exception $expt) {
            echo $expt->getMessage();
            return null;
        }
    }

}
