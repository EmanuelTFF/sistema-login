<?php
    include "../include/MySql.php";
    include "../include/functions.php";
    
    $codigo = "";
    $nome = "";
    $email= "";
    $telefone= "";
    $senha= "";
    $imgContent = "";
    $administrador = 0;
    $msgErro = "";

    if (isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $sql = $pdo->prepare("SELECT * FROM USUARIO WHERE codigo=?");
        if ($sql->execute(array($codigo))){
            $info = $sql->fetch(PDO::FETCH_ASSOC);
            $nome = $info['nome'];
            $email = $info['email'];
            $telefone = $info['telefone'];
            $senha = $info['senha'];
            $administrador = $info['administrador'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
        if (!empty($_FILES["image"]["name"])){
            $fileName = basename($_FILES['image']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');
            if (in_array($fileType, $allowTypes)){
                $image = $_FILES['image']['tmp_name'];
                $imgContent = file_get_contents($image);
            }
        }

        $nome = test_input($_POST['nome']);
        $email = test_input($_POST['email']);
        $telefone = test_input($_POST['telefone']);
        $senha = md5(test_input($_POST['senha']));
        $administrador = isset($_POST['administrador']) ? 1 : 0;

        $sql = $pdo->prepare("UPDATE USUARIO SET nome=?, email=?, telefone=?, senha=?, administrador=?, imagem=? WHERE codigo=?");
        if ($sql->execute(array($nome, $email, $telefone, $senha, $administrador, $imgContent, $codigo))){
            $msgErro = "Dados atualizados com sucesso!";
        } else {
            $msgErro = "Erro ao atualizar dados!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        form {
            background-color: #fff;
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        legend {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .msg-erro {
            color: red;
            font-size: 14px;
        }
        </style>
    <form method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Alteração de Usuário</legend>
            Nome: <input type="text" name="nome" value="<?php echo $nome?>">
            <br>
            Email: <input type="text" name="email" value="<?php echo $email?>">
            <br>
            Telefone: <input type="text" name="telefone" value="<?php echo $telefone?>">
            <br>
            Senha: <input type="password" name="senha" value="">
            <br>
            <input type="checkbox" name="administrador" <?php if ($administrador == 1) echo 'checked' ?>>Administrador
            <br>
            <input type="file" name="image">
            <br>
            <input type="submit" value="Salvar" name="submit">
        </fieldset>
    </form>
    <span><?php echo $msgErro?></span>
</body>
</html>
