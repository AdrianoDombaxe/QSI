<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

// verificando se existe o id via método GET
if (isset($_GET['id'])) {
    //verificando se existe método post na requisição
    if (!empty($_POST)) {
        //verificando campos do formulário de atualizar a agenda
        $idA = isset($_POST['id']) ? $_POST['id'] : NULL;
        $idM = isset($_POST['idM']) ? $_POST['idM'] : '';
        $data_agenda = isset($_POST['data_agenda']) ? $_POST['data_agenda'] : date('Y-m-d');
        $horario = isset($_POST['horario']) ? $_POST['horario'] : '';

        // atualizando os dados no banco de dados
        $stmt = $pdo->prepare('UPDATE Agenda_medico SET idA = ?, idM = ?, data_agenda = ?, horario = ? WHERE idA = ?');
        $stmt->execute([$idA, $idM, $data_agenda, $horario, $_GET['id']]);
        $msg = 'Agenda alterada com sucesso! </p></p> <a href="read_agenda.php">Voltar a lista de agenda.</a>';
    }

    // verificando se a agenda existe pelo ID
    $stmt = $pdo->prepare('SELECT * FROM Agenda_medico WHERE idA = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Não existe um médico com esse ID');
    }
} else {
    exit('Sem id especificado!');
}
?>

<!-- Definindo template de Lista de agenda para atualizar -->
<?=template_header('Read')?>

<div class="content update">
	<h2>Atualizar o registro do médico nº # <?=$contact['idA']?></h2>
    <form action="update_agenda.php?id=<?=$contact['idA']?>" method="post">
        
    <input type="text" name="id" value="<?=$contact['idA']?>" id="id" readonly>
    <select name="idM" id="idM" required>
        <option value="">Selecione o medico</option>
        <?php
        $query = $pdo->query("SELECT idM, nome FROM Medicos ORDER BY nome ASC");
        $registro = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($registro as $option){
            ?>
                <option value="<?php echo $option['idM']?>"> <?php echo $option['nome']?> </option>
            <?php
        }
        ?>
    </select> 
    <input type="date" name="data_agenda" id="data_agenda" value="<?=$contact['data_agenda']?>">
        <select name="horario" id="horario" >
            <option value="<?=$contact['horario']?>">Selecione um horário</option>
            <option value="08:00 às 08:30">08:00 às 08:30</option>
            <option value="08:30 às 09:00">08:30 às 09:00</option>
            <option value="09:00 às 09:30">09:00 às 09:30</option>
            <option value="09:30 às 10:00">09:30 às 10:00</option>
            <option value="10:00 às 10:30">10:00 às 10:30</option>
            <option value="10:30 às 11:00">10:30 às 11:00</option>
            <option value="11:00 às 11:30">11:00 às 11:30</option>
            <option value="11:30 às 12:00">11:30 às 12:00</option>
        </select>   
        <input type="submit" value="Salvar alterações">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
