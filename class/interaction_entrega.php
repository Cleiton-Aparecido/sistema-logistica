<?php
class interaction_entrega
{
    private $objectSector = array();
    private $objectUser = array();
    private $objectRegister = array();
    private $datacorreio = array();
    private $controle = array();

    public function __construct()
    {
        $this->objectSector = new setor();
        $this->objectUser = new usuario();
        $this->objectRegister = new registro();
        $this->datacorreio = new datacorreio();
        $this->controle = new controle();
    }
    public function listpendente($list){
        // controle.idstatusentrega
        foreach ($list as $row) {
            // $row['idstatusentrega'];
            echo '<option value="'.$row['idcontrole'].'">'.$row['idcontrole'].'</option>';
            
        }
    }
}
