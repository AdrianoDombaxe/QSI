<?php
session_start();
$erro = '';

if(isset($_POST['login'])) {
    include 'config/conexao.php';
    include_once 'config/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->nome = $_POST['nome'];
    $user->senha = $_POST['senha'];

    if($user->login()) {
        $_SESSION['loggedin'] = true;
        $_SESSION['nome'] = $user->nome;
        header("Location: home.php");
    } else {
        $erro = "Nome de usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso restrito</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function showError() {
            document.getElementById('errorDiv').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container-login">

        <div class="logo">
            <img src="img/icon/Gender Neutral User_64px.png" alt="logotipo">
        </div>
        <div class="title">
            <h1>Sistema de Agendamento</h1>
            <h1>Consultas Médicas</h1>
            <span>preencha todos os campos para acessar o sistema</span>  
        </div>
        <div id="errorDiv" class="error"><?php echo $erro; ?></div>
        <form class="form" method="POST" action="index.php">
            <div class="text-input"><img src="img/icon/Login As User_64px.png" alt=""><input class="user" type="text" name="nome" id="user" placeholder="Nome de usuário..." autofocus></div>
            <div class="text-input"><img src="img/icon/Password 1_52px.png" alt=""><input class="pass" type="password" name="senha" id="pass" placeholder="Senha de usuário..."></div>
            <input class="btn" type="submit" name="login" value="Entrar"> 
        </form>
        <?php if($erro): ?>
        <script>showError();</script>
        <?php endif; ?>
    </div>
</body>
</html>