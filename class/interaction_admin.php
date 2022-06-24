<?php
require_once("config.php");
class interaction_admin  extends interaction
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $encomenda = array();
    private $statusentrega = array();
    private $RegistroEnvioEncomenda = array();
    private $disabled_inf_registro;
    private $disabled_atualizacao_registro;

    public function __construct()
    {
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->encomenda = new encomenda();
        $this->statusentrega = new statusentrega();
        $this->RegistroEnvioEncomenda = new registroEnvio();
        $this->disabled_inf_registro = 'disabled';
        $this->disabled_atualizacao_registro = 'disabled';
    }
    
}
