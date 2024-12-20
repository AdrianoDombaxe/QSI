<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

// verificando se campos do formulário de criação do contato estão vazios
if (!empty($_POST)) {
    $idC = isset($_POST['idC']) && !empty($_POST['idC']) && $_POST['idC'] != 'auto' ? $_POST['idC'] : NULL;
    $idP = isset($_POST['idP']) ? $_POST['idP'] : '';
    $idA = isset($_POST['idA']) ? $_POST['idA'] : '';

    // inserindo dados no banco de dados
    $stmt = $pdo->prepare('INSERT INTO Consultas VALUES (?, ?, ?)');
    $stmt->execute([$idC, $idP, $idA]);
    $msg = 'Consulta agendada com sucesso! </p></p> <a href="read_consultas.php">Voltar a lista de consultas.</a>';
}

?>

<!-- definindo template de Criação de Contato -->
<?=template_header('Create')?>

<div class="content update">
	<h2>Adicionar Consulta</h2>
    <form action="create_consultas.php" method="post">
        <input type="text" name="id" placeholder="26" value="auto" id="id" readonly>
        <select name="idP" id="idP" required>
            <option value="">Selecione o paciente</option>
            <?php
            $query = $pdo->query("SELECT idP, nome FROM Pacientes ORDER BY nome ASC");
            $registro = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($registro as $option){
                ?>
                    <option value="<?php echo $option['idP']?>"> <?php echo $option['nome']?> </option>
                <?php
            }
            ?>
        </select>
        <select name="agenda" id="agenda">
            <option value="12">Selecione um agendamento</option>
            <?php
             
            $query = $pdo->query("SELECT Agenda_medico.idA, Medicos.nome, Medicos.especialidade, Agenda_medico.data_agenda, Agenda_medico.horario FROM Medicos LEFT JOIN Agenda_medico ON Medicos.idM = Agenda_medico.idM");
            $registro = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($registro as $option){
                ?>
                    <option value="<?php echo $option['idA']?>"> <?php echo $option['idA'] . ' - ' . $option['especialidade'] . ' - ' . $option['data_agenda'] . ' - ' . $option['horario']?></option>
                <?php
            }
            ?>
        </select>
        <input type="submit" value="Salvar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>