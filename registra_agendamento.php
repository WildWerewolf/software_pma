<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Registrar Contatos</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>
    <div class="Site">
        <?php include "header.php"; 
         if(isset($_GET['incluir']) && isset($_POST)){
            require_once 'Classes/agendamento.php';
            $agendamento = new Agendamento();
            
            $dados = $_POST;
            $agendamento->criarAgendamentos($dados);
            
        }
        
        ?>    </div>
    <div class="titulo-secao">
        Registrar Agendamento
    </div>
    <form method="POST" action="registra_agendamento.php?incluir=vai" onsubmit="return desativa_btn();">    
        <div class="container-cadastrar">
        <div class="col-12">
            <span class="label_cadastro">Nome:</span>
            <?php 
             
            if(isset($_GET['id'])){
                require_once 'classes/Cliente.php';
                $cli = new Cliente();
                $cli->instanciar($_GET['id']);
                
                $_SESSION['cliente']=$_GET['id'];
            
                echo '<input type="text" value="'.$cli->getNome().'" class="cadastro_input" disabled>';
            }
            
            ?>        </div>
        
<?php
        
        $_SESSION['cliente']=$_GET['id'];
        
        ?>        <div class="col-6">
            <span class="label_cadastro">data:</span>
            <input type="date" name="data" class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>
        <div class="col-6">
            <span class="label_cadastro">hora:</span>
            <input type="time" name="hora" class="cadastro_input" placeholder="Digite a hora" required>
        </div>
<div class="col-6">
            <span class="label_cadastro">Tipo:</span>
            <select name="tipo" class="cadastro_input" required>
                <option value="">Selecione</option>
                <option value="0">Interno</option>
                <option value="1">Externo</option>
                <option value="2">Telefone</option>
            </select>
        </div>
        <div class="col-12">

            
            

        </div>
        <p>
        	<br>
        	<br>
        <div class="col-6">
        <?php
            echo '<a href="perfil_cliente.php?id='.$_GET['id'].'">';
            ?>
            <button type="button" class="cadastro_cancelar cadastro_btn" placeholder="Digite o nome do cliente">Cancelar</button>
        </a></div>
        <div class="col-6">
            <button type="submit" class="cadastro_cadastrar cadastro_btn" placeholder="Digite o nome do cliente" id="btn_submit">Cadastrar</button>
        </div>
    </div>
    </form>
    
    <script>
function desativa_btn() {
    document.getElementById("btn_submit").disabled = true;
}
</script>
    
    
</body>

</html>     