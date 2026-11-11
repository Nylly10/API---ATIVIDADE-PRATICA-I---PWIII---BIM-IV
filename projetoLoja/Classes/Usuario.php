<?php

class Usuario {

    private $pdo;

    public function conecta() {

        try {
            $this->pdo = new PDO(
            "mysql:dbname=loja_db;host=localhost",
            "root",
            ""
        );
      

        } catch (PDOException $e) {

            die("Erro ao conectar ao banco de dados!");

        }

    }

    public function logar($email, $senha) {

        $sql = $this->pdo->prepare(
            "SELECT * FROM usuarios WHERE email = :email"
        );

        $sql->bindValue(":email", $email);

        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            session_regenerate_id(true);

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: index.php");
            exit;

        } else {

            echo "<script>
                alert('E-mail ou senha incorretos!');
            </script>";

        }

    }

}

?>
