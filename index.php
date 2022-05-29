<?php
//inclui arquivo de conexão com banco e classes CRUD
require '_app/Config.inc.php';
require '_app/funcoes.php';

//recebe var se ha busca
$busca = filter_input(INPUT_POST, 'busca', FILTER_SANITIZE_STRING);

//inicia os filtros padroes
$filtros = 'where p.ativo = 1';
$ordenacao = ' order by desc_prod';

//se houve busca recebe os campos e adiciona a var de filtros
if ($busca):
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST, 'preco_prod', FILTER_SANITIZE_STRING);
    $sinal = filter_input(INPUT_POST, 'sinal', FILTER_SANITIZE_STRING);
    $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_STRING);

    if (isset($descricao) && $descricao):
        $filtros .= " and p.desc_prod like '%{$descricao}%'";
    endif;

    if (isset($valor) && $valor):
        $preco = dec_format($valor);
        $filtros .= " and p1.preco" . sinal($sinal) . $preco;
        $ordenacao = ' order by p1.preco';
    endif;

    if (isset($cor) && $cor):
        $filtros .= " and p.cor_prod = '{$cor}'";
    endif;
endif;

//cria instancia do objeto READ para consulta e chama metodo para consultar usando os filtros aplicados
$sql = new Read();
$sql->FullRead('select p.*, p1.preco as preco from produtos p join precos p1 on(p1.id_preco = p.idpreco)' . $filtros . $ordenacao);

//armazena array com resultado
$produtos = $sql->GetResult();
//armazena a qte de registros
$itens = $sql->getRowCount();

//limpa o objeto
$sql = null;
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>
        <h1>Listagem de Produtos</h1>
        <div>
            <!--COLUNA FILTROS-->
            <div class="col">
                <!--BOTAO NOVO PRODUTO-->
                <a href="frminserirproduto.php" class="button-sucesso">&#10010; NOVO PRODUTO</a>

                <!--FORM DE FILTROS-->
                <div>
                    <h3>Filtrar</h3>
                    <form action="index.php" method="POST">
                        <label>Descrição: </label><br>
                        <input type="text" class="filter-row" name="descricao" placeholder="Nome do produto"/><br>
                        <label>Valor: </label><br>
                        <div class="inline">
                            <select class="filter" name="sinal" class="filter-row">
                                <option value="MAIOR">Maior que</option>
                                <option value="MENOR">Menor que</option>
                                <option value="IGUAL">Igual a</option>
                            </select>
                            <input type="text" class="filter-inline" id="preco_prod" name="preco_prod" onkeyup="formatarMoeda()" placeholder="Valor"/>   
                        </div>
                        <div>
                            <label>Cor: </label><br>
                            <select name="cor" class="filter-row">
                                <option value=""></option>
                                <option value="Amarelo">Amarelo</option>
                                <option value="Azul">Azul</option>
                                <option value="Vermelho">Vermelho</option>
                            </select>
                        </div>
                        <input type="hidden" name="busca" value="1"> 
                        <input type="submit" class="button" value="&#10004; PESQUISAR" />
                    </form> 
                </div>
            </div>
            <!--FIM COLUNA FILTROS-->
            <!--COLUNA TABELA LISTA PRODUTOS-->
            <div class="col">
                <table id="tabprodutos">
                    <tr>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Valor sem desc</th>
                        <th>Descontos</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    //SE NAO TEM ITENS EXIBE MENSAGEM AO USUARIO
                    if (!$itens):
                        echo "<tr><td colspan=\"5\">Nenhum item encontrado</td></tr>";
                    else:
                        //SE TEM ITENS MONTA A TABELA    
                        foreach ($produtos as $produto) :
                            extract($produto);
                            ?>
                            <tr>
                                <td><?= $desc_prod; ?></td>
                                <td><?= $cor_prod; ?></td>
                                <td><b><?= 'R$ ' . number_format($preco, 2, ",", "."); ?></b></td>
                                <td><?= verDesconto($cor_prod, $preco); ?></td>
                                <td>
                                    <a href="frmalterarproduto.php?cod=<?= $id_produto; ?>" class="button" title="Alterar">&#9998;</button>
                                    <a onClick="javascript: return confirm('Deseja mesmo apagar?');" href="acoes/produto-excluir.php?cod=<?= $id_produto; ?>" class="button-perigo" title="Remover">&#10006;</a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </table>
            </div>
        </div>
        
        <!--ADICIONA FORMATACAO DE MOEDA PARA O CAMPO DE PRECO-->
        <script src="js/moeda.js"></script>

    </body>
</html>
