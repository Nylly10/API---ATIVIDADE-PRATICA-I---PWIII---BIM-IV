<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login de Usuário</title>

    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <section>

        <form method="post">

            <h1>Login de Usuário</h1>

            <label for="email">E-mail</label>
            <input type="email" name="email"
                   id="email" class="sombra" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha"
                   id="senha" class="sombra" required>

            <input type="submit" id="botao" value="Entrar">

        </form>

    </section>

</body>
</html>

<?php

if (isset($_POST['email']) && isset($_POST['senha'])) {

    require_once __DIR__ . '/classes/Usuario.php';

    $u = new Usuario();

    $u->conecta();

    $u->logar($_POST['email'], $_POST['senha']);

}

?>
