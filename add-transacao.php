<?php
    session_start();
    require "config.php";

    if(isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        //Todos os valores que tiverem virgula(,) 
        //vai ser mudado para ponto(.)
        $valor = str_replace(",",".", $_POST['valor']) ;
        $valor = floatval($valor);

        $sql = $pdo->prepare("INSERT INTO historico SET id_conta = :id_conta, tipo = :tipo, valor = :valor, data_operacao = Now() ");
        $sql->bindValue(":id_conta", $_SESSION['banco']);
        $sql->bindValue(":tipo", $tipo);
        $sql->bindValue(":valor", $valor);
        $sql->execute();
        

        if($tipo == '0'){
            //Depósito
            $sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":id", $_SESSION['banco']);
            $sql->execute();
            header("Location: index.php");
            exit;
        }
        else{
            //Saque
            $sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":id", $_SESSION['banco']);
            $sql->execute();
            header("Location: index.php");
            exit;
        }

        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
    <title>Transações</title>
</head>
<body>
    <form method="post">
        Tipo de transação: <br>
        <select name="tipo" >
            <option value=""></option>
            <option value="0">Deposito</option>
            <option value="1">Saque</option>
        </select><br><br>
        Valor: <br>
        <input type="text" name="valor" pattern="[0-9.,]{1,}"><br><br>
        <input type="submit" value="Adicionar">
    </form>
</body>
</html>