<?php

/**
 * Check.class [ TIPO ]
 * Descricao Ajustes de nomes/data e verificações
 * @copyright (c) year, Oroaldo Esmerio
 */
class Check {

    private static $data;
    private static $format;
    public $banco;

    public static function LoginAluno() {
        if (!$_SESSION['codesc']):
            header("Location: index.php?msg=24");
            exit;
        endif;
    }

    public static function Email($email) {
        self::$data = (string) $email;
        self::$format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$format, self::$data)):
            return true;
        else:
            return false;
        endif;
    }

    //'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª'
    //'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 '

    public static function Name($name) {
        self::$format = array();
        self::$format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$data = strtr(utf8_decode($name), utf8_decode(self::$format['a']), self::$format['b']);
        self::$data = strip_tags(trim(self::$data));
        self::$data = str_replace(' ', '-', self::$data);
        self::$data = str_replace(array('-----', '----', '---', '--'), '-', self::$data);

        return strtolower(utf8_encode(self::$data));
    }

    public static function tratatexto($name) {
        self::$format = array();
        self::$format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$data = strtr(utf8_decode($name), utf8_decode(self::$format['a']), self::$format['b']);
        self::$data = strip_tags(trim(self::$data));
        //self::$data = str_replace(' ', '-', self::$data);
        //self::$data = str_replace(array('-----', '----', '---', '--'), '-', self::$data);

        return utf8_encode(self::$data);
    }

    /*public static function Vertipo($name) {
        $file = explode(" ", $name);
        if (array_key_exists(1, $file)):
            $arquivo = $file[1];
        else:
            $arquivo = $file[0];
        endif;

        switch ($file[0]) {
            case 'V':
                $tipo = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'L':
                $tipo = '<i class="fa fa-external-link"></i>';
                break;
            default :
                $tipo = '<i class="fa fa-paperclip"></i>';
        }

        //$tipo = ($file[0] == 'V')? '<i class="fa fa-file-movie-o"></i>':'<i class="fa fa-paperclip"></i>';
        //$tipo = $file[0];
        return $tipo;
    }*/
    
     public static function Vertipo($tipo) {
        switch ($tipo) {
            case 'V':
                $tipo = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'L':
                $tipo = '<i class="fa fa-external-link"></i>';
                break;
            default :
                $tipo = '<i class="fa fa-paperclip"></i>';
        }
        return $tipo;
    }

    public static function Verarquivo($name) {
        $file = explode(" ", $name);
        if (array_key_exists(1, $file)):
            $arquivo = $file[1];
        else:
            $arquivo = $file[0];
        endif;

        //$tipo = ($file[0] == 'V')? '<i class="fa fa-file-movie-o"></i> '.$arquivo :'<i class="fa fa-paperclip"></i> '.$arquivo;
        return $arquivo;
    }

    public static function Gettipo($name) {
        $file = explode(" ", $name);
        $tipo = $file[0];
        return $tipo;
    }

    public static function Data($data) {
        self::$format = explode(' ', $data);
        self::$data = explode('/', self::$format['0']);

        if (empty(self::$format['1'])):
            self::$format['1'] = date('H:m:s');
        endif;

        self::$data = self::$data['2'] . '-' . self::$data['1'] . '-' . self::$data['0'] . ' ' . self::$format['1'];

        return self::$data;
    }

    public static function Limitechar($string, $limite, $pointer = null) {
        self::$data = strip_tags(trim($string));
        self::$format = (int) $limite;

        $ArrWords = explode(' ', self::$data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, self::$format));

        $pointer = (empty($pointer) ? '...' : ' ' . $pointer);
        $result = (self::$format < $NumWords ? $NewWords . $pointer : self::$data);
        return $result;
        //var_dump($ArrWords, $NumWords, $NewWords);
    }

    /*     * *** CONFERE BANCO, CARTEIRA E REGISTRO E SETA ARQUIVO/LINK PARA SB(SIM-BANCO)SL(SIM-LOCAL) *** */

    public static function Defbanco($banco, $carteira, $registro, $convenio) {
        //var_dump((int)$banco); die;
        switch ($banco) {
            case 104: //CEF
                if ($registro == '1' OR $carteira <> 'RG') {
                    $blt = 'SB';
                    $arquivo = 'http://bloquetoexpresso.caixa.gov.br/bloquetoexpresso/index.jsp';
                } else {
                    if ($convenio == 'SIGCB') {
                        $blt = 'SL';
                        $arquivo = 'boletos/boleto_cef_sigcb.php';
                    } else if ($convenio == 'SICOB') {
                        $blt = 'SL';
                        $arquivo = 'boletos/boleto_cef.php';
                    } else {
                        $blt = 'N';
                        $arquivo = 'boletos/boleto_cef.php';
                    }
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 237:    //BRADESCO - SIGCB
                if ($registro == '1' OR $carteira <> '06') {
                    $blt = 'SB';
                    $arquivo = 'https://banco.bradesco/html/classic/produtos-servicos/mais-produtos-servicos/segunda-via-boleto.shtm';
                } else {
                    $blt = 'SL';
                    $arquivo = 'boletos/boleto_bradesco.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 341:    //ITAU
                if ($registro == 1 OR $carteira <> '175') {
                    $blt = 'SB';
                    $arquivo = 'https://www.itau.com.br/servicos/boletos/segunda-via/';
                } else {
                    $blt = 'SL';
                    $arquivo = 'boletos/boleto_itau.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 748:    //SICREDI
                if ($registro == '1') {
                    $blt = 'SB';
                    $arquivo = 'https://si-web.sicredi.com.br/boletoweb/BoletoWeb.servicos.Index.task';
                } else {
                    $blt = 'SL';
                    $arquivo = 'boletos/boleto_sicredi.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 33:    //SANTANDER
                if (($registro == '1') OR ( $carteira == '101')) {
                    $blt = 'SB';
                    $arquivo = 'https://www.santander.com.br/atendimento-para-voce/boletos/emissao-2-via-boleto';
                } else {
                    $blt = 'SL';
                    $arquivo = 'boletos/boleto_santander_banespa.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 756:    //SICOOB
                if (($registro == '1') OR ( $carteira == '1')) {
                    $blt = 'SB';
                    $arquivo = 'https://www.sicoob.com.br/web/sicoob/2-via-boleto';
                } else {
                    $blt = 'SL';
                    $arquivo = 'boletos/boleto_bancoob.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 41:    //BANRISUL
                if (($registro == '1') OR ( $carteira == '1')) {
                    $arquivo = 'https://ww8.banrisul.com.br/brb/link/Brbw2Lhw_Bloqueto_Titulos_Internet.aspx?SegundaVia=1&secao_id=2539';
                } else {
                    $blt = 'N';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 85:    //CECRED - 085
                if ($registro == '1') {
                    $blt = 'N';
                    $arquivo = 'https://www.viacredi.coop.br/segunda-via-de-boletos';
                } else {
                    $blt = 'S';
                    $arquivo = 'boletos/cecred.php';
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            case 1:    //BB
                if ($registro == '1') {
                    $blt = 'SB';
                    $arquivo = 'https://www63.bb.com.br/portalbb/boleto/boletos/hc21e,802,3322,10343.bbx';
                } else {
                    if ($carteira == 18) {
                        $blt = 'SL';
                        $arquivo = 'boletos/boleto_bb.php';
                    } else {
                        $blt = 'N';
                        $arquivo = 'boletos/boleto_bb.php';
                    }
                }
                $defbol = ['blt' => $blt, 'arquivo' => $arquivo];
                return $defbol;
                break;
            default:
                $blt = 'N';   //se não for nenhum codigo de banco dos casos anteriores
                break;
        }
    }

}
