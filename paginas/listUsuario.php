<?php
    include "../include/MySql.php";
    include "../include/functions.php";

    $sql = $pdo->prepare("SELECT * FROM USUARIO");
    $sql->execute();
    $usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 100%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        a {
            display: inline-block;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            margin-right: 5px;
            margin-bottom: 5px; /* Adicionado para espaçamento entre os botões */
        }

        a:hover {
            background-color: #45a049;
        }

        .editar {
            background-color: #2196F3;
        }

        .editar:hover {
            background-color: #1e90ff;
        }

        .excluir {
            background-color: #f44336;
        }

        .excluir:hover {
            background-color: #ff6347;
        }

        @media only screen and (max-width: 600px) {
            table {
                border: 0;
            }

            table thead {
                display: none;
            }

            table tr {
                margin-bottom: 10px;
                display: block;
                border: 1px solid #ddd;
            }

            table td {
                display: block;
                text-align: right;
                border: none;
            }

            table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }

            .acoes {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <h1>Lista de Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Administrador</th>
                <th class="acoes">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td data-label="Código"><?php echo $usuario['codigo']; ?></td>
                <td data-label="Nome"><?php echo $usuario['nome']; ?></td>
                <td data-label="Email"><?php echo $usuario['email']; ?></td>
                <td data-label="Telefone"><?php echo $usuario['telefone']; ?></td>
                <td data-label="Administrador"><?php echo $usuario['administrador'] ? 'Sim' : 'Não'; ?></td>
                <td class="acoes">
                    <a href="altUsuario.php?codigo=<?php echo $usuario['codigo']; ?>" class="editar">Editar</a>
                    <a href="delUsuario.php?codigo=<?php echo $usuario['codigo']; ?>" class="excluir">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>