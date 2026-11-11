<?php

class Produtos {
    private $id_produto;
    private $nome;
    private $descricao;
    private $valor;
    private $pdo;
    public function conecta()
    {
        try {
            $dns = "mysql:dbname=loja_db;host=localhost";
            $dbUser = "root";
            $dbPass = "";
            $this->pdo = new PDO($dns, $dbUser, $dbPass);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    
public function enviarProduto($nome, $descricao, $valor, $fotos = array())
{
    // Insere o produto na tabela produtos
    $sql = "INSERT INTO produtos
            (nome_produto, descricao, valor_produto)
            VALUES (:n, :d, :v)";

    $sql = $this->pdo->prepare($sql);

    $sql->bindValue(":n", $nome);
    $sql->bindValue(":d", $descricao);
    $sql->bindValue(":v", $valor);

    $isOk = $sql->execute();

    if ($isOk) {

        // Recupera o ID do produto cadastrado
        $id_produto = $this->pdo->lastInsertId();

        // Verifica se existem fotos
        if (count($fotos)) {

            for ($i = 0; $i < count($fotos); $i++) {

                $nome_foto = $fotos[$i];

                // Insere as imagens relacionadas ao produto
                $sql = "INSERT INTO imagens
                        (nome_imagem, fk_id_produto)
                        VALUES (:n, :fk)";

                $sql = $this->pdo->prepare($sql);

                $sql->bindValue(":n", $nome_foto);
                $sql->bindValue(":fk", $id_produto);

                $sql->execute();
            }
        }

        return true;
    }

    return false;
}

}
