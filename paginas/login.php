<?php
    include "../include/MySql.php";
    include "../include/functions.php";

    $email = "";
    $senha = "";
    $msgErro = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $email = test_input($_POST['email']);
        $senha = md5(test_input($_POST['senha']));

        $sql = $pdo->prepare("SELECT * FROM USUARIO WHERE email=? AND senha=?");
        if ($sql->execute(array($email, $senha))) {
            if ($sql->rowCount() > 0) {
                $user = $sql->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['user'] = $user;
                header('Location: principal.php');
            } else {
                $msgErro = "Email ou senha incorretos!";
            }
        } else {
            $msgErro = "Erro ao executar a consulta!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    form {
        width: 300px;
        margin: 100px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    fieldset {
        border: none;
    }

    legend {
        font-size: 24px;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #0056b3;
        color: white;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    span {
        color: red;
    }

    .link-cadastro {
        display: block;
        margin-top: 10px;
        text-align: center;
    }

    .link-cadastro a {
        color: #0056b3;
        text-decoration: none;
    }

    .link-cadastro a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <form method="POST">
        <fieldset>
            <legend>Login</legend>
            Email: <input type="text" name="email" value="<?php echo $email ?>">
            <br>
            Senha: <input type="password" name="senha" value="<?php echo $senha ?>">
            <br>
            <input type="submit" value="Entrar" name="submit">
            <div class="link-cadastro">
        <a href="cadUsuario.php">Faça Cadastro</a>
    </div>
        </fieldset>
    </form>
    <span><?php echo $msgErro ?></span>
    
</body>
</html>
