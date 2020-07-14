<?php

    session_start();
    require 'config.php';

    if(isset($_POST['agencia']) && empty($_POST['agencia']) == false){
        $agencia = addslashes($_POST['agencia']);
        $conta = addslashes($_POST['conta']);
        $senha = addslashes($_POST['senha']);

        $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
        $sql->bindValue(":agencia", $agencia);
        $sql->bindValue(":conta", $conta);
        $sql->bindValue(":senha", md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0){

            $sql = $sql->fetch();

            $_SESSION['banco'] = $sql['id'];
            header("Location: index.php");
            exit;

        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
    <title>Página de Login</title>
</head>
<body>
    <div class="container">
        <form method="post">
            <img class="usuario" src="img/usuario.png" width="100px" alt="">
            <h4>ACESSO DE MEMBROS</h4>
            <p>Agência:</p> 
            <input type="text" name="agencia" id="" >
            <p>Conta:</p>
            <input type="text" name="conta" id="">
            <p>Senha:</p>
            <input type="password" name="senha" id="">
            <input type="submit" value="Enviar">
        </form>
    </div>

    <style>
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 490px;
            height: 500px;
            padding-bottom: 15px;
            padding-top: 10px;
            margin: 5vh auto;
            background: linear-gradient(-105deg, rgba(243,85,110,1) 0%, rgba(243,85,110,1) 35%, rgba(250,128,79,1) 100%);
            border-radius: 20px;
            box-shadow: 2px 2px 4px #95a5a6;
        }
        p{
            margin: 0;
            padding: 0;
            color: #fff;
        }
        H4{
            margin: 0;
            text-align: center;
            padding: 15px 0 15px 0;
            font-weight: 700;
            color: #fff;
        }
        .usuario{
            display: block;
            margin: 0 auto;
        }
        .email{
            position: relative;
            left: 50px;
            top: 6px;
        }
        .senha{
            position: relative;
            left: 50px;
            top: 6px;
        }
        input[type="text"],input[type="password"],input[type="submit"]{
            display: flex;
            margin-top: 8px;
            width: 300px; 
            height: 46px;  
        }
        input[type="text"],input[type="password"]{
            border: 0;
            outline: none;
            text-align: center;
            border-radius: 40px;
            margin-bottom: 10px;
            border: solid 4px #fff;
            background: #febfb0;
            color: #d82f34;
            font-weight: bold;
            font-size: 18px;
        }
        input[type="submit"]{
            border: 0;  
            border-radius: 40px; 
            width: 310px;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            background: #3d3d59;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover{
            background: #585879;
        }
    </style>
</body>
</html>