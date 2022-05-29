<?php
//inclui arquivo de conexão com banco e classes CRUD
require '_app/Config.inc.php';
require '_app/funcoes.php';

//obtem cod do produto a ser alterado
$id = filter_input(INPUT_GET, 'cod', FILTER_VALIDATE_INT);

//cria instancia do objeto e chama metodo para consultar o produto
$sql = new Read();
$sql->FullRead('select p.*, p1.preco as preco, p1.id_preco from produtos p join precos p1 on(p1.id_preco = p.idpreco) where id_produto =:id',"id={$id}");

//armazena array com resultado
$produto = $sql->GetResult();

//limpa o objeto
$sql = null;

//verifica parametro para gerar mensagem ao usuario
if (empty($_GET['msg'])) {
    $msg = 0;
} else {
    $msg = $_GET['msg'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>
        <h1>&#9998; Alterar produto</h1>
        <div>
            <div class="col">
                <!--botao voltar a lista-->
                <span><a href="index.php" class="button-neutro">&#8592; VOLTAR</a></span>
                <div>
                    <p><span>Alterando <b><?= $produto[0]['desc_prod']; ?></b></span></p>
                    <h3>Insira os novos dados para este produto:</h3>
                    <!-- mensagem para usuario -->
                    <span><?= mensagem($msg); ?></span>
                    <!-- formulario para alteracao - campos recebem os valores atuais do produto -->
                    <form action="acoes/produto-editar.php" method="POST">
                        <label for="desc_prod">Descrição:</label>
                        <input type="text" name="desc_prod" value="<?= $produto[0]['desc_prod']; ?>" required/>
                        <label for="preco_prod">Preço:</label>
                        <input type="text" name="preco_prod" maxlength="9" id="preco_prod" onkeyup="formatarMoeda()" value="<?= number_format($produto[0]['preco'], 2, ",", "."); ?>" required/>
                        
                        <!--visualizacao da cor somente leitura-->
                        <input type="text" name="cor" readonly="true" value="<?= $produto[0]['cor_prod'].' *'; ?>" disabled />
                        
                        <!-- passa codigos do cadastro -->
                        <input type="hidden" name="id_produto" value="<?= $produto[0]['id_produto']; ?>">
                        <input type="hidden" name="id_preco" value="<?= $produto[0]['idpreco']; ?>">
                        <input type="hidden" name="inserir" value="1"> 
                        
                        <input type="submit" value="&#10004; SALVAR" />
                    </form> 
                </div>
                <!-- dicas de uso p/ usuário -->
                <p><small><strong>Importante: </strong>Não reutilize o cadastro de um produto alterando o nome. Para isso <a href="frminserirproduto.php">crie um novo registro</a></small></p>
                <small>*A cor não pode ser alterada. Se estiver incorreta, chamar alguém do TI você deve.</small>                
            </div>             
        </div>
        <!--js com formatacao de moeda-->
        <script src="js/moeda.js"></script>
    </body>
</html>
