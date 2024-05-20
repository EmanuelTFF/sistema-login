<?php
    include "../include/MySql.php";

    if (isset($_GET['codigo'])) {
        $codigo = $_GET['codigo'];
        $sql = $pdo->prepare("DELETE FROM USUARIO WHERE codigo=?");
        if ($sql->execute(array($codigo))){
            header('Location: listUsuario.php');
        } else {
            echo "Erro ao deletar usuário!";
        }
    }
?>
