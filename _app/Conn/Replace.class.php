<?php

/**
 * Replace.class.php [ TIPO ]
 * Descricao
 * @copyright (c) year, Oroaldo Esmerio
 */
class Replace extends Conn{
    
    private $tabela;
    private $dados;
    private $results;
    private $status;
    
    /**@var PDO statements**/
    private $replace;
    
    /**@var PDO */
    private $conn;
    
    public function ExeReplace($tabela, array $dados) {
        $this->tabela = (string) $tabela;
        $this->dados = $dados; 
        
        $this->getSyntax();
        $this->execute();
    }
    
    public function GetResult() {
        return $this->results;
    }
    
    public function GetStatus() {
        return $this->status;
    }
    
    /**
     ************************************
     *********PRIVATE METODOS*********
     *************************************
     */
    
    private function Connect() {
        $this->conn = parent::getConn();
        $this->replace = $this->conn->prepare($this->replace); 
    }
    
    private function getSyntax() {
      $fields = implode(', ', array_keys($this->dados));
      $places = "'".implode("', '", array_values($this->dados))."'";
      $this->replace = "REPLACE INTO {$this->tabela} ({$fields}) VALUES ({$places})";
      //$this->replace = "REPLACE INTO {$this->tabela} VALUES ({$places})";
    }
    
    private function execute() {
        $this->Connect();
        try {
            $this->replace->execute($this->dados);
            $this->results = true;
            
        } catch (PDOException $ex) {
            $this->results = null;
            $this->status = $ex->getMessage().', '. $ex->getCode();
            //WSErro('Erro ao cadastrar: '. $ex->getMessage(), $ex->getCode());
        }
    }
    
}
