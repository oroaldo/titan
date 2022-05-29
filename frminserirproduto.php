<?php
//inclui arquivo de conexão com banco e classes CRUD
require '_app/Config.inc.php';
require '_app/funcoes.php';

//VERIFICA SE TEM PARAMETROS PARA GERAR MENSAGEM AO USUARIO
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
        <h1>&#9998; Novo produto</h1>
        <div>
            <div class="col">
                <!--botao para retornar a lista-->
                <span><a href="index.php" class="button-neutro">&#8592; VOLTAR</a></span>
                <div>
                    <h3>Informe os dados do produto:</h3>
                    
                    <!--mensagem para usuario-->
                    <p><?= mensagem($msg); ?></p>
                    
                    <!--form de cadastro-->                   
                    <form action="acoes/produto-incluir.php" method="POST">
                        <label for="desc_prod">Descrição:</label>
                        <input type="text" name="desc_prod" placeholder="Descrição/Nome do produto" required/>
                        
                        <label for="preco_prod">Preço:</label>
                        <input type="text" name="preco_prod" maxlength="9" id="preco_prod" onkeyup="formatarMoeda()" placeholder="Valor - apenas números" required/>
                        
                        <label for="cor_prod">Cor:</label>
                        <select id="cor_prod" name="cor_prod">
                            <option value="Amarelo">Amarelo</option>
                            <option value="Azul">Azul</option>
                            <option value="Vermelho">Vermelho</option>
                        </select>

                        <input type="hidden" name="inserir" value="1"> 
                        <br>
                        <input type="submit" class="button" value="&#10004; SALVAR" />
                    </form>
                    <!--fim formulario cadastro-->
                </div>
            </div>

        </div>
        <!--formatacao de moeda-->
        <script src="js/moeda.js"></script>
    </body>
</html>
