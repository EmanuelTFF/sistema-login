<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Obtendo o nome do usuário da sessão
$nomeUsuario = isset($_SESSION['user']['nome']) ? $_SESSION['user']['nome'] : '';

// Verificar se o nome do usuário está definido
if (empty($nomeUsuario)) {
    // Se o nome do usuário não estiver definido, redirecione para o login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .bem-vindo {
            text-align: center;
            margin-bottom: 20px;
        }

        .botoes {
            text-align: center;
        }

        .botao {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .botao:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bem-vindo">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        </div>
        <div class="botoes">
            <a href="listUsuario.php" class="botao">Gerenciar Usuários</a>
            <a href="logout.php" class="botao">Logout</a>
        </div>
    </div>
</body>
</html>
