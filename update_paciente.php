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
        //verificando campos do formulário de atualizar o contato
        $idM = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
        $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';

        // atualizando os dados no banco de dados
        $stmt = $pdo->prepare('UPDATE Pacientes SET idP = ?, nome = ?, genero = ?, telefone = ?, email = ?, cidade = ?, bairro = ? WHERE idP = ?');
        $stmt->execute([$idM, $nome, $genero, $telefone, $email, $cidade, $bairro, $_GET['id']]);
        $msg = 'Registo do paciente atualizado com sucesso! </p></p> <a href="read_paciente.php">Voltar a lista de pacientes.</a>';
    }

    // verificando se o contato existe pelo ID
    $stmt = $pdo->prepare('SELECT * FROM Pacientes WHERE idP = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Não existe um médico com esse ID');
    }
} else {
    exit('Sem id especificado!');
}
?>

<!-- Definindo template de Lista de Contatos para atualizar -->
<?=template_header('Read')?>

<div class="content update">
	<h2>Atualizar o registro do paciente nº # <?=$contact['idP']?></h2>
    <form action="update_paciente.php?id=<?=$contact['idP']?>" method="post">
        <input type="text" name="id" value="<?=$contact['idP']?>" id="id" readonly>
        <input type="text" name="nome" placeholder="Nome do paciente" value="<?=$contact['nome']?>" id="nome">
        <select name="genero" id="genero">
            <option value="">Selecione o genero</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>
        
        <input type="text" name="telefone" placeholder="Número de telefone" value="<?=$contact['telefone']?>" id="telefone">
        <input type="text" name="email" placeholder="exemplo@exemplo.com" value="<?=$contact['email']?>" id="email">
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
        <input type="submit" value="Salvar alterações">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>