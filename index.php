<?php
    session_start();
    require "config.php";
    if(isset($_SESSION['banco']) && empty($_SESSION['banco']) == false){
        $id = $_SESSION['banco'];
        
        $sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
        $sql->bindValue(":id", $id);
        /*OBS! TEM QUE EXECUTAR O SQL PARA FUNCIONAR*/
        $sql->execute();
        if($sql->rowCount() > 0){
            $info = $sql->fetch();
            
        }
        else{
            header("Location: login.php");
            exit;
        }
    }
    else{
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa Eletrônico</title>
    <style>
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Banco Lagoa Azul</h1>
    Títular: <?php echo $info['titular'] ?><br>
    Agência: <?php echo $info['agencia'] ?><br>
    Conta: <?php echo $info['conta'] ?><br>
    Saldo: <?php echo $info['saldo'] ?><br><br>
    <a href="sair.php">Sair</a>
    <hr style="margin-top: 20px;">

    <h3>Movimentação/Extrato</h3>
    <a href="add-transacao.php">Adiconar Transação</a><br><br>
    <table border="1" width="400px">
        <tr>
            <th>Data</th>
            <th>Valor</th>
        </tr>

        <?php
            $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
            $sql->bindValue(":id_conta", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                foreach($sql->fetchAll() as $item){
                    ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($item['data_operacao'])); ?></td>
                            <td>
                                <?php if($item['tipo'] == '0'):  ?>
                                    <span style="color: green;">R$ <?php echo $item['valor']; ?></span>
                                <?php else: ?>
                                    <span style="color: red;">- R$ <?php echo $item['valor']; ?></span>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php
                }
            }

        ?>

    </table>

</body>
</html>