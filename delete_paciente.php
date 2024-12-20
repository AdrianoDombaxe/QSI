<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

if (isset($_GET['id'])) {
    // selecionando registro do banco de dados a partir do ID
    $stmt = $pdo->prepare('SELECT * FROM Pacientes WHERE idP = ?');
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
            $stmt = $pdo->prepare('DELETE FROM Pacientes WHERE idP = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'registro de deletado com sucesso! </p></p> <a href="read_paciente.php">Voltar a lista de pacientes.</a>';

        } else {
            header('Location: read_paciente.php');
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
	<h2>Deletar o registro  do paciente com o nº # <?=$contact['idP']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Deseja excluir o registro do paciente com o nº # <?=$contact['idP']?>?</p>
    <div class="yesno">
        <a href="delete_paciente.php?id=<?=$contact['idP']?>&confirm=yes">Sim</a>
        <a href="delete_paciente.php?id=<?=$contact['idP']?>&confirm=no">Não</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>