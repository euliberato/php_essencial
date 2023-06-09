<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

if(count($_POST) > 0) {

    include('./conexao.php');
    
    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    if(empty($nome)) {
        $erro = "Preencha o nome";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o e-mail";
    }

    if(!empty($telefone)) {
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11)
            $erro = "O telefone deve ser preenchido no padrão (11) 98888-8888";
    }

    if(!empty($nascimento)) { 
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3) {
            $nascimento = implode ('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve seguir o padrão dia/mes/ano.";
        }
    }

    if($erro) {
        echo "<p><b>ERRO: $erro</b></p>";
    } else {
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data)
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);

        if($deu_certo) {
            echo "<p><b>Cliente cadastrado com sucesso!</b></p>";
            unset($_POST);
        }
    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <a href="/clientes.php">Voltar para a lista</a>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input placeholder="Exemplo: João Silva" type="text" name="nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>">
        </p>
        <p>
            <label>E-mail:</label>
            <input placeholder="Usuario@exemplo.com" type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
        </p>
        <p>
            <label>Telefone:</label>
            <input placeholder="(11) 91234-1234" type="text" name="telefone" value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>">
        </p>
        <p>
            <label>Data de Nascimento:</label>
            <input placeholder="Dia/Mes/Ano" type="text" name="nascimento" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>">
        </p>
        <p>
            <button type="submit">Concluir Cadastro</button>
        </p>
    </form>

</body>
</html>
