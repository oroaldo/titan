<?php
//inclui arquivo de conexao e funcoes
require_once("../_app/Config.inc.php");
require_once("../_app/funcoes.php");

//recebe dados do formulario de cadastro
$desc_prod = filter_input(INPUT_POST, 'desc_prod', FILTER_SANITIZE_STRING);
$cor_prod = filter_input(INPUT_POST, 'cor_prod', FILTER_SANITIZE_STRING);
$preco_prod = filter_input(INPUT_POST, 'preco_prod', FILTER_SANITIZE_STRING);
$inserir = filter_input(INPUT_POST, 'inserir', FILTER_VALIDATE_INT);

//se contem flag inserir inicia o cadastro
if ($inserir):
    //ajusta o valor de preco para gravar
    $preco = dec_format(['preco' => $preco_prod]);

    //instancia classe para insert no banco e insere o preco na tabela 'preco'
    $sql = new Create();
    $sql->ExeCreate('precos', $preco);
    //obtem o id gerado ao cadastrar do método getResult da classe Create
    $idpreco = $sql->getResult();
    
    //se retornou id também insere o produto na tabela 'produtos'
    if ($idpreco):
        //prepara os dados em um array
        $produto = [
            'desc_prod' => strtoupper($desc_prod),
            'cor_prod' => $cor_prod,
            'idpreco' => $idpreco
        ];
        //instancia o objeto da classe Create para e faz o insert no banco
        $sql = new Create();
        $sql->ExeCreate('produtos', $produto);  
    endif;
    //limpa o objeto e retorna para o formulario passando parametros para mensagem
    $sql = null;
    header("Location: ../frminserirproduto.php?msg=1");
    die;
else:
    //sem a flag inserir retorna ao formulario e passa parametro para mensagem
    header("Location: ../frminserirproduto.php?msg=4");
    die;
endif;
