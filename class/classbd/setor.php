<?php

class setor{
    private $idsetor;
    private $dessetor;
    private $statusAtivacao;
    private $listasetores = array();
    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
        $this->listSectorG();
    }

    public function getidsetor(){
        return $this->idsetor;
    }
    public function setidsetor($value){
        $this->idsetor = $value;
    }
    public function getdessetor(){
        return $this->dessetor;
    }
    public function setdessetor($value){
        $this->dessetor = $value;
    }
    public function getstatusAtivacao(){
        return $this->statusAtivacao;
    }
    public function setstatusAtivacao($value){
        $this->statusAtivacao = $value;
    }


    public function getlistasetores(){
        return $this->listasetores;
    }
    public function setlistasetores($value){
        $this->listasetores = $value;
    }
     // Alterar status de um setor
    public function alterarStatus($setor,$status){
        $comando = "UPDATE setor SET statusAtivo =  (SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = '$status')  WHERE descsetor = '$setor';";
        $this->sql->query($comando);
    }
    public function inserirNOvoSetor($setor){
        $comando = "INSERT INTO setor (descsetor,statusAtivo)  
        VALUES  ('$setor',(SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = 'Ativo'))";
        $this->sql->query($comando);
    }
    // Lista de todos setores
    private function listSectorG(){
        $resultado = $this->sql->select("SELECT * FROM setor
        INNER JOIN  statusativacao ON statusativacao.idStatusAtivacao = setor.statusAtivo");
        $dados = array();
        
        foreach ($resultado as $row) {
           array_push($dados,array(
                "id"=>$row['idsetor'],
                "nome"=>$row['descsetor'],
                "status"=>$row['descStatus']
           ));
        }
        $this->setlistasetores($dados);
    }

    // fazer busca do setor
    private function setorSeach($setor){
        $resultado = $this->sql->select("SELECT * FROM setor 
        INNER JOIN  statusativacao ON statusativacao.idStatusAtivacao = setor.statusAtivo
        WHERE descsetor = '$setor'");


        if(count($resultado)>0){
            $row = $resultado[0];
            $this->setidsetor($row['idsetor']);
            $this->setdessetor($row['descsetor']);
            $this->setstatusAtivacao($row['descStatus']);
        }

    }
    // Buscar status de um um setor especifico
    public function statusSector($setor){
        $this->setorSeach($setor);
        return $this->getstatusAtivacao();
    } 
    // Verificar se o setor que será adionado já existe
    public function VerificarSetorExistente($setor){
        $this->setorSeach($setor);
       if ($this->getdessetor() == ''){
            return false;
       }else{
            return true;
       }
        
    }
    // Lista de setores
    public function listSectordesc(){ 
        $this->listSectorG();
        $list = array();
        foreach ($this->getlistasetores() as $row) {
                array_push($list,$row['nome']);
        }
        return $list;
    }
    public function listSectordescAtivo(){ 
        $this->listSectorG();

        $list = array();
        foreach ($this->getlistasetores() as $row) {
            if($row['status'] == 'Ativo'){
                array_push($list,$row['nome']);
            }
        }
        return $list;
    }

    //Lista com dados dos setores
    public function listSector(){
        return $this->getlistasetores();
    }
    //Buscar id do setor
    public function SearchSector($sector){
        $this->setorSeach($sector);
        return $this->getidsetor();
    }
    
    
}

?>