<?php

/**
 * Read.class [ TIPO ]
 * Descricao
 * @copyright (c) year, Oroaldo Esmerio
 */
class Read extends Conn {
    
    private $select;
    private $places;
    private $result;
    
    /** Var PDO Stantements**/
    private $read;
    
    /** var PDO */
    private $conn;
    
    public function ExeRead($tabela,$termos = null,$parsestring = null) {
       if(!empty($parsestring)):
        parse_str($parsestring, $this->places);
       endif;
       
       $this->select = "select * from {$tabela} {$termos}";
       $this->execute();
    }
    
    public function GetResult() {
        return $this->result;
    }
    
    public function getRowCount() {
        return $this->read->rowCount();
    }
    
    public function FullRead($query, $parsestring = null) {
        $this->select = (string) $query; 
        if(!empty($parsestring)):
          parse_str($parsestring, $this->places);
       endif;
       $this->execute();  
    }
    
    public function setPlaces($parsestring) {
        parse_str($parsestring, $this->places);
        $this->execute();
    }
    
    /**
     ************************************
     *********PRIVATE METODOS*********
     *************************************
     */
    
     private function Connect() {
        $this->conn = parent::getConn();
        $this->read = $this->conn->prepare($this->select);
        $this->read->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    private function getSyntax() {
       if($this->places):
           foreach ($this->places as $vinculo => $valor):
                if($vinculo == 'limit' || $vinculo == 'offset'):
                    $valor = (int) $valor;
                endif;
    $this->read->bindValue(":{$vinculo}", $valor, (is_int($valor)? PDO::PARAM_INT : PDO::PARAM_STR) );
           endforeach;
       endif;
    }
    
    private function execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->read->execute();
            $this->result = $this->read->fetchAll();
            
        } catch (PDOException $ex) {
            $this->results = null;
            WSErro('Erro ao consultar: '. $ex->getMessage(), $ex->getCode());
        }
    }
    
    
}
