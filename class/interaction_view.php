<?php
class interaction_view{
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
    public function dadosView($id){
        $x = $this->objectRegister->consultRegister($id);
        
        if(!isset($x)){
            echo 'não encontrado';
        }

        $date = new DateTime($x[0]['dataregistro']);
        $x[0]['dataregistro'] = $date->format('d/m/Y H:i:s');
        $date = new DateTime($x[0]['descdata']);
        $x[0]['descdata'] = $date->format('d/m/Y');

        $dados = array(
            "ID Registro"=>$x[0]['idregistroenc'],
            "Codigo"=>$x[0]['codigo'],
            "Remetente"=>$x[0]['remetente'],
            "Data Registro"=>$x[0]['dataregistro'],
            "Grupo"=>$x[0]['idcontrole'],
            "Data Coleta"=>$x[0]['descdata'],
            "Status"=>$x[0]['descstatusentrega'],
            "Data entrega"=>$x[0]['dataentregasetor']
        );
       return $dados;
    }
    public function presentation($dados){

        foreach ($dados as $key => $value) {
            if($key == 'Status'){
                if($value == 'Pendente'){

                    echo '<p class="item"><strong>'.$key.':</strong> <span class="badge badge-danger status">'.$value.'<span></p>';   
                }
                if($value == 'Entregue'){

                    echo '<p class="item"><strong>'.$key.':</strong> <span class="badge badge-success status">'.$value.'<span></p>';   
                }
            }
            else if($value == ''){
                echo '';
            }
            else{
                echo '<p class="item"><strong>'.$key.':</strong> '.$value.'</p>';
            }
        }
    }


}
