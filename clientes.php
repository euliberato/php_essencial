<?php
include("conexao.php");

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <p>Esses são os clientes cadastrados no seu sistema:</p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nenhum cliente cadastrado</td>
                </tr>
            <?php } else { 
                        while($cliente = $query_clientes->fetch_assoc()){ 
                        $telefoneFormatado = "Não informado";
                        if(!empty($cliente['telefone'])){
                            $ddd = substr($cliente['telefone'], 0, 2);
                            $cincoDigitos = substr($cliente['telefone'], 3, 5);
                            $quatroDigitos = substr($cliente['telefone'], 7);
                            $telefoneFormatado = "($ddd) $cincoDigitos-$quatroDigitos";
                        }
                        $dataNascimento = "Não informado";
                        if(!empty($cliente['nascimento'])){
                            $varAuxiliar = explode('-', $cliente['nascimento']);
                            //$dataNascimento = "$varAuxiliar[2]/$varAuxiliar[1]/$varAuxiliar[0]";
                            $dataNascimento = implode("/", array_reverse($varAuxiliar));
                        }
                        $dataCadastro = date("d/m/Y H:i", strtotime($cliente['data']));
            ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['nome']; ?></td>
                    <td><?php echo $cliente['email']; ?></td>
                    <td><?php echo $telefoneFormatado; ?></td>
                    <td><?php echo $dataNascimento; ?></td>
                    <td><?php echo $dataCadastro; ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo$cliente['id']; ?>">Editar</a> |
                        <a href="apagar_cliente.php?id=<?php echo$cliente['id']; ?>">Apagar</a>
                    </td>
                </tr>
            <?php }} ?>
        </tbody>
    </table>
</body>
</html>