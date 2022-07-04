<?php

class encomenda{
    private $idencomenda;
    private $descencomenda;
    private $status;
    private $listaGEralEncomenda;

    private $sql = array();

    public function __construct()
    {
        $this->sql = new sql();
    }

    public function getidencomenda(){
        return $this->idencomenda;
    }
    public function setidencomenda($value){
        $this->idencomenda = $value;
    }

    public function getdescencomenda(){
        return $this->descencomenda;
    }
    public function setdescencomenda($value){
        $this->descencomenda = $value;
    }

    public function getstatus(){
        return $this->status;
    }
    public function setstatus($value){
        $this->status = $value;
    }


    public function getlistaGEralEncomenda(){
        return $this->listaGEralEncomenda;
    }
    public function setlistaGEralEncomenda($value){
        $this->listaGEralEncomenda = $value;
    }
    public function inserirNovaEncomenda($encomenda){
        $comando = "INSERT INTO tipoencomenda SET desctipoencomenda = '$encomenda', statusAtivo = (SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = 'Ativo')";
        $this->sql->query($comando);
    }

    public function alterarStatusEncomenda($encomenda,$status){
        $comando = "UPDATE tipoencomenda SET statusAtivo =  (SELECT idStatusAtivacao FROM statusativacao WHERE descStatus = '$status')  WHERE desctipoencomenda = '$encomenda';";
        $this->sql->query($comando);
    }

    private function searchencomenda($descricao){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda 
        INNER JOIN  statusativacao ON statusativacao.idStatusAtivacao = tipoencomenda.statusAtivo
        WHERE desctipoencomenda = '$descricao';");

        if(count($resultado)>0){
            $row = $resultado[0];
            $this->setidencomenda($row['idtipoencomenda']);
            $this->idencomenda($row['desctipoencomenda']);
            $this->setstatus($row['descStatus']);
        }

    }

    public function statusencomenda($encomenda){
        $this->searchencomenda($encomenda);
        return $this->getstatus();
    }

    // listar todas opções de encomenda
    private function SelectGeralnome(){
        $resultado = $this->sql->select("SELECT desctipoencomenda FROM tipoencomenda");
        $list = array();
        if (count($resultado)>0) {
            foreach ($resultado as $row) {
                array_push($list,$row['desctipoencomenda']);
            }
        }
        $this->setlistaGEralEncomenda($list);
    }
    // gerar atributo todos os dados de encomenda
    private function listaTodosDadosEncomenda(){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda 
        INNER JOIN  statusativacao ON statusativacao.idStatusAtivacao = tipoencomenda.statusAtivo");
        $dados = array();
        foreach ($resultado as $row) {
            array_push($dados,array(
                "id"=>$row['idtipoencomenda'],
                "nome"=>$row['desctipoencomenda'],
                "status"=>$row['descStatus']
            ));
        }
        $this->setlistaGEralEncomenda($dados);
    }
    
    // retornar lista de opções de encomendas
    public function listcencomenda(){
        $this->SelectGeralnome();
        return $this->getlistaGEralEncomenda();
    }
    // bucar o id de um encomenda atravez do nome
    public function idencomenda($cencomenda){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda
        where desctipoencomenda= '".$cencomenda."'");
        $x = $resultado[0]['idtipoencomenda'];
        return $x;
    }
    // bucar o nome de uma encomenda atravez do id
    public function searchcencomendaid($id){
        $resultado = $this->sql->select("SELECT * FROM tipoencomenda
        where idtipoencomenda = ".$id."");
        if(!isset($resultado[0]['desctipoencomenda'])){
            $resultado = 'Sem info';
        }
        else{
            $resultado = $resultado[0]['desctipoencomenda'];
        }
        return $resultado;
    }
    // Requisitar lista com todos os dados da encomenda
    public function listatotal(){
        $this->listaTodosDadosEncomenda();
        return $this->getlistaGEralEncomenda();
    }
    // verifiacr se existe o tipo da encomenda 
    public function verificarEncomendaExiste($encomenda){
        $this->searchencomenda($encomenda);
        if ($this->getstatus() == ''){
            return false;
       }else{
            return true;
       }
    }
    
}

?>