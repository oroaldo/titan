<?php

/**
 * Check.class [ TIPO ]
 * Descricao Ajustes de nomes/data e verificações
 * @copyright (c) year, Oroaldo Esmerio
 */
class GeraPj {

    private $codesc;
    private $numlanc;
    private $credencial;
    private $chave;
    private $Error;
    private $Result;

    public function __construct($num, $codesc) {
        $this->numlanc = $num;
        $this->codesc = $codesc;
    }

    public function getLink() {
        $this->setBoleto();
        $this->getResult();
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

//OBTEM CHAVE E CREDENCIAL
    private function setBoleto() {
        $Read = new Read;
        $Read->ExeRead('dados_pj', "WHERE codigo_escola =:codesc", "codesc={$this->codesc}");

        if ($Read->getResult()):
            $this->credencial = $Read->getResult()[0]['credencial'];
            $this->chave = $Read->getResult()[0]['chave'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => PJURL . "/recebimentos/{$this->credencial}/transacoes/lotes",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_SSL_VERIFYPEER => "false", //verificacao de certificado ssl desabilitado
                CURLOPT_POSTFIELDS => "{\n\t\"pedido_numero\" : [\n\t\t \"{$this->numlanc}\" \n\t\t],\n\t\"formato\" : \"carne\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "X-CHAVE: {$this->chave}"
                ),
            ));

            $response = curl_exec($curl);
            
            $err = curl_errno($curl).curl_error($curl);
            curl_close($curl);

            if ($err) {
                $this->Result = $err;
                return $this->Result;
            } else {
                $this->Result = (array) json_decode($response);
                return $this->Result;
            }

        else:
            $this->Result = false;
            return $this->Result;
        endif;
    }

}
