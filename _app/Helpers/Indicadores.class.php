<?php

/**
 * Check.class [ TIPO ]
 * Descricao Ajustes de nomes/data e verificações
 * @copyright (c) year, Oroaldo Esmerio
 */
class Indicadores {

    private $codesc;
    private $Error;
    private $Result;
    private $terms;

    public function getTotalRecebidoHoje() {
        $this->setTotalRecebido();
        $this->Read();
    }

    public function getParcela($numlanc) {
        $this->numlanc = $numlanc;
        $this->setTermParcela($this->numlanc);
        $this->Read();
    }
    
    public function getParam() {
        $this->setTermParam();
        $this->Read();
    }

    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com a mensagem e o tipo de erro!
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

//PREPARA LEITURA DE DADOS
    private function setTotalRecebido() {
        $this->terms = "SELECT tipo, sum(valor_pago) FROM `caixa` where data_pagamento = CURRENT_DATE and tipo <> 'T' group by tipo order by tipo";
    }

    private function setTermParcela() {
        $this->terms = "select c.*, ac.bonus_pontualidade, ac.bonus_material from caixa c 
					   left join alunos_cursos ac on(ac.id_aluno_curso = c.id_aluno_curso)
					   where c.id_aluno_curso = '{$this->id}' and c.codigo_escola = '{$this->codesc}' and c.numero_lancamento = '{$this->numlanc}'";
    }

    private function setTermParam() {
        $this->terms = "select e.*, p.multa, p.juros, p.tipo_juros, b.* from empresas e inner join parametros_escola p on(p.cod_escola = e.codigo) inner join bancos b on(b.id_banco = p.id_banco_boleto) where e.codigo = '{$this->codesc}' and b.situacao = 'A'";
    }
    
//EXECUTA LEITURA
    private function Read() {
        $Read = new Read;
        $Read->FullRead($this->terms);
        if ($Read->getResult()):
            $this->Result = $Read->getResult();
            return $this->Result;
        else:
            $this->Result = false;
            return $this->Result;
        endif;
    }

}
