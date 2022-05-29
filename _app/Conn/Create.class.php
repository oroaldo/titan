<?php

/**
 * Create.class.php [ TIPO ]
 * Descricao
 * @copyright (c) year, Oroaldo Esmerio
 */
class Create extends Conn{
    
    private $tabela;
    private $dados;
    private $results;
    
    /**@var PDO statements**/
    private $create;
    
    /**@var PDO */
    private $conn;
    
    
    public function ExeCreate($tabela, array $dados) {
        $this->tabela = (string) $tabela;
        $this->dados = $dados; 
        
        $this->getSyntax();
        $this->execute();
    }
    
    public function getResult() {
        return $this->results;
    }
    
    /**
     ************************************
     *********PRIVATE METODOS*********
     *************************************
     */
    
    private function Connect() {
        $this->conn = parent::getConn();
        $this->create = $this->conn->prepare($this->create); 
    }
    
    private function getSyntax() {
      $fields = implode(', ', array_keys($this->dados));
      $places = ':'.implode(', :', array_keys($this->dados));
      $this->create = "INSERT INTO {$this->tabela} ({$fields}) VALUES ({$places})";
    }
    
    private function execute() {
        $this->Connect();
        try {
            $this->create->execute($this->dados);
            $this->results = $this->conn->lastInsertId();
            
        } catch (PDOException $ex) {
            $this->results = null;
            WSErro('Erro ao cadastrar: '. $ex->getMessage(), $ex->getCode());
        }
    }
    
}
