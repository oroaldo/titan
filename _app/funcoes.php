<?php
/* FORMATA VALOR PARA GRAVAR NO BANCO - 0.00*/
function dec_format($get_valor) {
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
    return $valor; //retorna o valor formatado para gravar no banco
}

//MENSAGENS AUXILIARES DAS ACOES
function mensagem($msg) {
    $mensagem = array(
        0 => "",
        1 => "<b style=\"color:green;\">Registro inserido com sucesso</b>",
        2 => "<b style=\"color:green;\">Registro alterado com sucesso</b>",
        3 => "<b style=\"color:green;\">Registro removido com sucesso</b>",
        4 => "<b style=\"color:red;\">Não foi possível incluir o registro. Verifique os dados informados e tente novamente</b>",   
    );
    return $mensagem[$msg];
}

//RETORNA SINAL CORRESPONDENTE PARA REALIZAR FILTRO POR VALOR
function sinal($sinal) {
    switch ($sinal) :
        case 'MAIOR':
            return ' > ';
            break;
        case 'MENOR':
            return ' < ';
            break;
        default:
            return ' = ';
    endswitch;
}

//RETORNA DESCONTO CONFORME REGRA
function verDesconto($cor,$preco) {
    switch ($cor) :
        //AMARELOS - 10% DE DESC
        case 'Amarelo':
            $valor_desc = ((100-10)/100)*$preco;
            return '<small>Desconto de 10%</small><br>R$ '.number_format($valor_desc, 2, ",", ".");
            break;
        //AZUIS - 5% DE DESC
        case 'Azul':
            $valor_desc = ((100-20)/100)*$preco;
            return '<small>Desconto de 20%</small><br>R$ '.number_format($valor_desc, 2, ",", ".");
            break;
        //VERMELHOS - 20% DESC E 5% SE VALOR MAIOR QUE 50
        case 'Vermelho':
            if($preco > 50):
                $valor_desc = ((100-5)/100)*$preco;
                $desc = 5;
            else:
                $valor_desc = ((100-20)/100)*$preco;
                $desc = 20;
            endif;
            return '<small>Desconto de '.$desc.'%</small><br> R$ '.number_format($valor_desc, 2, ",", ".");
            break;
        default:
            //PADRAO SEM DESCONTO
            return '<small>Sem desconto.</small>';
    endswitch;
}