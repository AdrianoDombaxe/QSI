<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

if (isset($_GET['id'])) {
    // selecionando registro do banco de dados a partir do ID
    $stmt = $pdo->prepare('SELECT * FROM Medicos WHERE idM = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    // se o registro não existir pelo ID envia um alerta
    if (!$contact) {
        exit('Não existe registro com esse ID');
    }
    // se for confirmado a exclusão então o registro será eliminado
    // o valor de confirmação ou não é enviado via metodo GET a partir do formulário
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM Medicos WHERE idM = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'registro deletado com sucesso! </p></p> <a href="read_medico.php">Voltar a lista de registro.</a>';

        } else {
            header('Location: read_medico.php');
            exit;
        }
    }
} else {
    exit('ID não especificado!');
}
?>

<!-- definindo template para Deletar o registro -->
<?=template_header('Delete')?>
<div class="content delete">
	<h2>Deletar o registro nº # <?=$contact['idM']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Você realmente deseja excluir o registro nº # <?=$contact['idM']?>?</p>
    <div class="yesno">
        <a href="delete_medico.php?id=<?=$contact['idM']?>&confirm=yes">Sim</a>
        <a href="delete_medico.php?id=<?=$contact['idM']?>&confirm=no">Não</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>