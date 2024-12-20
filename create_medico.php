<?php
//importando arquivo funcao.php de dentro da pasta config
include 'config/funcao.php';

//criando conexão por meio do PDO
$pdo = pdo_connect_mysql();

$msg = '';

// verificando se campos do formulário de criação do contato estão vazios
if (!empty($_POST)) {
    $idM = isset($_POST['idM']) && !empty($_POST['idM']) && $_POST['idM'] != 'auto' ? $_POST['idM'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $especialidade = isset($_POST['especialidade']) ? $_POST['especialidade'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';

    // inserindo dados no banco de dados
    $stmt = $pdo->prepare('INSERT INTO Medicos VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$idM, $nome, $especialidade, $genero, $telefone, $email, $cidade, $bairro]);

    $msg = 'Médico cadastrado com sucesso! </p></p> <a href="read_medico.php">Voltar a lista de médicos.</a>';
}
?>

<!-- definindo template de cadastramento do médico -->
<?=template_header('Create')?>

<div class="content update">
	<h2>Adicionar médico</h2>
    <form action="create_medico.php" method="post">
        <input type="text" name="id" placeholder="26" value="auto" id="id" readonly>
        <input type="text" name="nome" placeholder="Nome do médico" id="nome">
        <select name="especialidade" id="especialidade">
        <option value="">Selecione a especialidade</option>
            <option value="Estomatologia">Estomatologia</option>
            <option value="Dermatologia">Dermatologia</option>
            <option value="Oftalmologia">Oftalmologia</option>
            <option value="Ginecologia">Ginecologia</option>
            <option value="Ortopedia">Ortopedia</option>
            <option value="Pediatria">Pediatria</option>
        </select>
        <select name="genero" id="genero">
            <option value="">Selecione o genero</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>
        
        <input type="text" name="telefone" placeholder="Número de telefone" id="telefone">
        <input type="text" name="email" placeholder="exemplo@exemplo.com" id="email">
        <select name="cidade" id="cidade">
            <option value="">Selecione uma cidade</option>
            <option value="Luanda">Luanda</option>
            <option value="Uíge">Uíge</option>
            <option value="Benguela">Benguela</option>
            <option value="Huambo">Huambo</option>
            <option value="Lubango">Lubango</option>
            <option value="Malange">Malange</option>
            <option value="Cabinda">Cabinda</option>
            <option value="Namibe">Namibe</option>
            <option value="Huíla">Huíla</option>
            <option value="Kwanza Norte">Kwanza Norte</option>
        </select>
        <select name="bairro" id="bairro">
        <option value="">Selecione um bairro</option>
            <option value="Candombe Velho">Candombe Velho</option>
            <option value="Dunga">Dunga</option>
            <option value="Popular">Popular</option>
            <option value="Kilala">Kilala</option>
            <option value="Papelão">Papelão</option>
            <option value="Quixicongo">Quixicongo</option>
            <option value="Kilomosso">Kilomosso</option>
            <option value="Catapa">Catapa</option>
            <option value="Kakiuia">Kakiuia</option>
            <option value="Mbemba Ngango">Mbemba Ngango</option>
        </select>
        <input type="submit" value="Salvar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>