<?php

/**
 * Read.class [ TIPO ]
 * Descricao
 * @copyright (c) year, Oroaldo Esmerio
 */
class Delete extends Conn {
    
    private $tabela;
    private $termos;
    private $places;
    private $result;
    
    /** Var PDO Stantements**/
    private $delete;
    
    /** var PDO */
    private $conn;
    
    public function ExeDelete($tabela,$termos,$parsestring) {
       $this->tabela = (string) $tabela;
       $this->termos = $termos;
       
       parse_str($parsestring, $this->places);
       $this->getSyntax();
       $this->execute();
    }
    
    public function GetResult() {
        return $this->result;
    }
    
    public function getRowCount() {
        return $this->delete->rowCount();
    }
    
    public function setPlaces($parsestring) {
        parse_str($parsestring, $this->places);
        $this->getSyntax();
        $this->execute();
    }
    
    /**
     ************************************
     *********PRIVATE METODOS*********
     *************************************
     */
    
     private function Connect() {
         $this->conn = parent::getConn();
         $this->delete = $this->conn->prepare($this->delete);
    }
    
    private function getSyntax() {
        $this->delete = "DELETE FROM {$this->tabela} {$this->termos}";
    }
    
    private function execute() {
        $this->Connect();
        try{
            $this->delete->execute($this->places);
            $this->result = true;
        } catch (PDOException $ex) {
            $this->results = null;
            WSErro('Erro ao consultar: '. $ex->getMessage(), $ex->getCode());
        }
    }
    
    
}
