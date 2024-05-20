<?php
    include "../include/MySql.php";
    include "../include/functions.php";

    $nome = "";
    $email= "";
    $telefone= "";
    $senha= "";
    $administrador= "";
    $imgContent = "";

    $nomeErro = "";
    $emailErro= "";
    $telefoneErro= "";
    $senhaErro= "";
    $msgErro="";

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
        if (!empty($_FILES["image"]["name"])){
            // Pegar informações do arquivo
            $fileName = basename($_FILES['image']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            // Array de extensões permitidas
            $allowTypes = array('jpg','png','jpeg','gif');

            if (in_array($fileType, $allowTypes)){
                $image = $_FILES['image']['tmp_name'];
                $imgContent = file_get_contents($image);

                if (empty($_POST['nome']))
                    $nomeErro = "Nome é obrigatório!";  
                else 
                    $nome = $_POST['nome'];
                
                if (empty($_POST['email']))    
                    $emailErro = "Email é obrigatório!";
                else    
                    $email = $_POST['email'];
                
                if (empty($_POST['telefone']))
                    $telefoneErro = "Telefone é obrigatório!";
                else    
                    $telefone = $_POST['telefone'];
                
                if (empty($_POST['senha']))
                    $senhaErro = "Senha é obrigatória!";
                else     
                    $senha = $_POST['senha'];

                if (isset($_POST['administrador']))    
                    $administrador = 1;
                else     
                    $administrador = 0;

                if ($email && $nome && $senha && $telefone) {
                    // Verificar se já existe o email
                    $sql = $pdo->prepare("SELECT * FROM USUARIO WHERE email = ?");
                    if ($sql->execute(array($email))){
                        if ($sql->rowCount() <= 0){
                            $sql = $pdo->prepare("INSERT INTO USUARIO (codigo, nome, email, telefone, senha, administrador, imagem)
                                                VALUES (null, ?, ?, ?, ?, ?, ?)");
                            if ($sql->execute(array($nome, $email, $telefone, md5($senha), $administrador, $imgContent))){
                                $msgErro = "Dados cadastrados com sucesso!";
                                $nome = "";
                                $email= "";
                                $telefone= "";
                                $senha= "";
                                header('location:login.php');
                            } else {
                                $msgErro = "Dados não cadastrados!";
                            }  
                        } else {
                            $msgErro = "Email de usuário já cadastrado!!";
                        }    
                    } else {
                        $msgErro = "Erro no comando SELECT!";
                    }    
                } else {
                    $msgErro = "Dados não cadastrados!";
                }
            } else {
                $msgErro = "Somente arquivos JPG, JPEG, PNG e GIFF são permitidos";
            }     
        } else {
            $msgErro = "Imagem não selecionada!!";
        }                       
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <script>
        function validateForm() {
            let nome = document.forms["userForm"]["nome"].value;
            let email = document.forms["userForm"]["email"].value;
            let telefone = document.forms["userForm"]["telefone"].value;
            let senha = document.forms["userForm"]["senha"].value;

            if (nome == "" || email == "" || telefone == "" || senha == "") {
                alert("Todos os campos devem ser preenchidos!");
                return false;
            }
            return true;
        }
    </script>
</head>
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
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #007bff;
        }
        .obrigatorio {
            color: red;
            font-size: 14px;
        }
        .msg-erro {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .link-cadastro{
        margin-left: 240px;
        margin-top: -25px;
        }
        .link-cadastro a {
        color: #0056b3;
        text-decoration: none;
    }
</style>
<body>
    <form name="userForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <fieldset>
            <legend>Cadastro de Usuário</legend>

            Nome: <input type="text" name="nome" value="<?php echo $nome?>">
            <span class="obrigatorio">*<?php echo $nomeErro?></span>
            <br>
            Email: <input type="text" name="email" value="<?php echo $email?>">
            <span class="obrigatorio">*<?php echo $emailErro?></span>
            <br>
            Telefone: <input type="text" name="telefone" value="<?php echo $telefone?>">
            <span class="obrigatorio">*<?php echo $telefoneErro?></span>
            <br>
            Senha: <input type="password" name="senha" value="<?php echo $senha?>">
            <span class="obrigatorio">*<?php echo $senhaErro?></span>
            <br>
            <input type="checkbox" name="administrador">Administrador
            <br>
            <input type="file" name="image">
            <br>
            <input type="submit" value="Salvar" name="submit">
            <br>
            <div class="link-cadastro">
        <a href="login.php">Já tem login?</a>
    </div>
    <br>
        </fieldset>
    </form>
    <span><?php echo $msgErro?></span>
</body>
</html>
