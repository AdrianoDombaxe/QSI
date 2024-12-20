<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$nome_usuario = $_SESSION['nome']; // Recupera o nome do usuário da sessão
?>
<?php
//importando arquivo funcao.php 
include 'config/funcao.php';
?>

<!-- Definindo template HOME -->
<?=template_header('Home')?>

<div class="content">
	<div class="header">
	    <p><?php echo htmlspecialchars($nome_usuario); ?>: Logado</p>
        <a href="config/logout.php">Sair</a>
    </div>
</div>

<!-- Definindo template de RODAPÉ -->
<?=template_footer()?>