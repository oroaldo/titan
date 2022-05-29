<?php

/**
 * Read.class [ TIPO ]
 * Descricao
 * @copyright (c) year, Oroaldo Esmerio
 */
class Update extends Conn {

    private $tabela;
    private $dados;
    private $termos;
    private $places;
    private $result;

    /** Var PDO Stantements* */
    private $update;

    /** var PDO */
    private $conn;

    public function ExeUpdate($tabela, array $dados, $termos, $parsestring) {
        $this->tabela = (string) $tabela;
        $this->dados = $dados;
        $this->termos = $termos;

        parse_str($parsestring, $this->places);
        $this->getSyntax();
        //var_dump($this->update);
        $this->execute();
    }
    
    public function FUpdate($query) {
        $this->FullUpdate($query);
    }

    public function GetResult() {
        return $this->result;
    }

    public function getRowCount() {
        return $this->update->rowCount();
    }

    public function setPlaces($parsestring) {
        parse_str($parsestring, $this->places);
        $this->getSyntax();
        $this->execute();
    }
    
    

    /**
     * ***********************************
     * ********PRIVATE METODOS*********
     * ************************************
     */
    private function Connect() {
        $this->conn = parent::getConn();
        $this->update = $this->conn->prepare($this->update);
    }

    private function getSyntax() {
        foreach ($this->dados as $key => $Value):
            $places[] = $key . ' = :' . $key;
        endforeach;

        $places = implode(',', $places);
        $this->update = "UPDATE {$this->tabela} SET {$places} {$this->termos}";
    }

    private function execute() {
        $this->Connect();
        try {
            $this->update->execute(array_merge($this->dados, $this->places));
            $this->result = TRUE;
        } catch (Exception $ex) {
            $this->results = null;
            WSErro('Erro ao atualizar: ' . $ex->getMessage(), $ex->getCode());
        }
    }

}
