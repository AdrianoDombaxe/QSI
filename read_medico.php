<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();
//definindo página de início da paginação do registro
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
//definindo limite de registro por página
$records_per_page = 10;

//seleção da lista de registro do banco de dados
$stmt = $pdo->prepare('SELECT * FROM Medicos ORDER BY idM DESC LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_contacts = $pdo->query('SELECT COUNT(*) FROM Medicos')->fetchColumn();

?>

<!-- Definindo template de Lista de registro -->
<?=template_header('Read')?>

<div class="content read">
	<h2>Médicos cadastrados</h2>
	<a href="create_medico.php" class="create-rows">Adicionar médico</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nome</td>
                <td>Especialidade</td>
                <td>Genero</td>
                <td>Telefone</td>
                <td>E-mail</td>
                <td>Cidade</td>
                <td>Bairro</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody>
            <!-- listando os registros com um laço FOREACH -->
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['idM']?></td>
                <td><?=$contact['nome']?></td>
                <td><?=$contact['especialidade']?></td>
                <td><?=$contact['genero']?></td>
                <td><?=$contact['telefone']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['cidade']?></td>
                <td><?=$contact['bairro']?></td>
                <td class="actions">
                    <a href="update_medico.php?id=<?=$contact['idM']?>" class="edit"><img src="img/icon/Pencil_20px.png" alt=""></a>
                    <a href="delete_medico.php?id=<?=$contact['idM']?>" class="trash"><img src="img/icon/Delete_20px.png" alt=""></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- sistema de paginação da lista de contatos -->
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_medico.php?page=<?=$page-1?>"></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read_medico.php?page=<?=$page+1?>"></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>