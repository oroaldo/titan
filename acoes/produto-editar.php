<?php
//carrega arquivos de conexao e funcao
require_once("../_app/Config.inc.php");
require_once("../_app/funcoes.php");

//recebe os dados do formulario
$id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
$id_preco = filter_input(INPUT_POST, 'id_preco', FILTER_VALIDATE_INT);
$desc_prod = filter_input(INPUT_POST, 'desc_prod', FILTER_SANITIZE_STRING);
$preco_prod = filter_input(INPUT_POST, 'preco_prod', FILTER_SANITIZE_STRING);
$inserir = filter_input(INPUT_POST, 'inserir', FILTER_VALIDATE_INT);

//se contem valor em inserir inicia update
if ($inserir):
    //formata valor de preco para gravar no banco
    $preco = ['preco' => dec_format($preco_prod)];

    //inicia instancia da classe update e altera o preco
    $sql = new Update();
    $sql->ExeUpdate('precos', $preco, 'where id_preco =:id', "id={$id_preco}");
    $idpreco = $sql->getResult();
    
    //se alterou o preco altera o produto
    if ($idpreco):
        $dados = ['desc_prod' => strtoupper($desc_prod)];
        $sql->ExeUpdate('produtos', $dados, 'where id_produto =:id', "id={$id}");
    endif;
    //limpa o objeto e retorna ao form passando o id para exibir o dados do produto
    $sql = null;
    header("Location: ../frmalterarproduto.php?msg=1&cod=".$id);
    die;
else:
    //sem flag, retorna para formulario passando o id
    header("Location: ../frmalterarproduto.php?msg=1&cod=".$id);
    die;  
endif;