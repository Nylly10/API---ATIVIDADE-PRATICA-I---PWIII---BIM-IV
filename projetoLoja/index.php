<!DOCTYPE html>

<html>
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<head>
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <?php include 'menu.php'; ?>

    <section>

        <a href="produtos.php" class="sombra">Ver todos os produtos</a>

        <form method="post" enctype="multipart/form-data">

            <!-- ENVIO DE IMAGENS -->

            <h1>Cadastro de Produto</h1>

            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" class="sombra">

            <label for="des">Descrição</label>
            <textarea name="desc" id="desc" class="sombra"></textarea>

            <label for="val">Valor</label>
            <input type="number" name="valor" id="val" class="sombra" step="0.01" min="0">

            <label for="foto">Fotos do Produto</label>
            <input type="file" name="foto[]" multiple id="foto" class="sombra meuInput">

            <input type="submit" id="botao" value="Cadastrar Produto">

        </form>

    </section>

</body>
</html>


<?php

// Checa se o usuário preencheu ao menos o nome
if (isset($_POST['nome']) && !empty($_POST['nome'])) {

    // Pega os dados preenchidos no formulário
    $nome = addslashes($_POST['nome']);
    $descricao = addslashes($_POST['desc']);
    $valor = $_POST['valor'];

    // Cria um array vazio para guardar os nomes das fotos
    $fotos = array();

    // Checa se foi enviada alguma foto
    if (isset($_FILES['foto'])) {

        $tipo = "";

        // Cria um laço para percorrer todas as fotos
        for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {

            if ($_FILES['foto']['type'][$i] == 'image/png') {

                $tipo = ".png";

            } elseif ($_FILES['foto']['type'][$i] == 'image/jpeg') {

                $tipo = ".jpg";

            } else {

                $tipo = "outro";
            }

            if ($tipo == "outro") {

                ?>

                <script>
                    alert("Só é possível enviar arquivos JPG e PNG");
                </script>

                <?php

            } else {

                // Cria um nome novo para o arquivo
                $nome_arquivo = md5(
                    $_FILES['foto']['name'][$i] . rand(1, 999)
                ) . $tipo;

                // Move o arquivo para a pasta imagens
                move_uploaded_file(
                    $_FILES['foto']['tmp_name'][$i],
                    'imagens/' . $nome_arquivo
                );

                // Armazena o nome do arquivo no vetor fotos
                array_push($fotos, $nome_arquivo);
            }
        }
    }

    // Verifica se os campos obrigatórios foram preenchidos
    if (!empty($nome) && !empty($descricao) && !empty($valor)) {

        require 'classes/Produto.php';
        
        $p = new Produtos();

        // Conecta ao banco de dados
        $p->conecta();

        // Envia os dados para o banco
        $p->enviarProduto($nome, $descricao, $valor, $fotos);

    } else {

        ?>

        <script>
            alert("Preencha os campos obrigatórios!");
        </script>

        <?php
    }
}

?>