<?php
require_once("../_app/Config.inc.php");

//recebe cod do produto a ser removido
$id = filter_input(INPUT_GET, 'cod', FILTER_VALIDATE_INT);

//faz leitura para verificar se o registro existe - cria um objeto da classe Read
$sql = new Read();
$sql->ExeRead('produtos', "where id_produto =:id", "id={$id}");
$flag = $sql->getRowCount();

$sql = null;

//se nao teve resultado volta para a lista
if(!$flag):
    header("Location: ../index.php");
    die;
else:
    //se localizou um registro cria objeto da classe Delete e executa o metodo para remover
    $sql = new Delete();
    $sql->ExeDelete('produtos', "WHERE id_produto =:id", "id={$id}");
    
    //retorna para a lista
    if ($sql->GetResult()):
        header("Location: ../index.php");
        $sql = null;
        die;
    else:
        header("Location: ../index.php");
        $sql = null;
        die;
    endif;
endif;


