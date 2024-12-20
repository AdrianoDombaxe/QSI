<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

// verificando se campos do formulário de criação do contato estão vazios
if (!empty($_POST)) {
    $idA = isset($_POST['idA']) && !empty($_POST['idA']) && $_POST['idA'] != 'auto' ? $_POST['idA'] : NULL;
    $idM = isset($_POST['idM']) ? $_POST['idM'] : '';
    $data_agenda = isset($_POST['data_agenda']) ? $_POST['data_agenda'] : date('Y-m-d');
    $horario = isset($_POST['horario']) ? $_POST['horario'] : '';

    // inserindo dados no banco de dados
    $stmt = $pdo->prepare('INSERT INTO Agenda_medico VALUES (?, ?, ?, ?)');
    $stmt->execute([$idA, $idM, $data_agenda, $horario]);

    $msg = 'Agenda feita com sucesso! </p></p> <a href="read_agenda.php">Voltar a lista de agenda.</a>';
}

?>

<!-- definindo template de Criação de Contato -->
<?=template_header('Create')?>

<div class="content update">
	<h2>Adicionar agenda</h2>
    <form action="create_agenda.php" method="post">
        <input type="text" name="id" placeholder="26" value="auto" id="id" readonly>
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
        <input type="date" name="data_agenda" id="data_agenda">
        <select name="horario" id="horario">
            <option value="">Selecione um horário</option>
            <option value="08:00 às 08:30">08:00 às 08:30</option>
            <option value="08:30 às 09:00">08:30 às 09:00</option>
            <option value="09:00 às 09:30">09:00 às 09:30</option>
            <option value="09:30 às 10:00">09:30 às 10:00</option>
            <option value="10:00 às 10:30">10:00 às 10:30</option>
            <option value="10:30 às 11:00">10:30 às 11:00</option>
            <option value="11:00 às 11:30">11:00 às 11:30</option>
            <option value="11:30 às 12:00">11:30 às 12:00</option>
        </select>
        <input type="submit" value="Salvar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>