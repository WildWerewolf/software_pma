
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Início</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>
    <div class="Site">
        <?php
            include 'header.php';
            include 'footer.php';
                    
        ?>
</div>
    <div class="titulo-secao">
        Início
    </div>
    <div class="container-cadastrar">
        <div class="col-6">
            <a href="cadastrar_cliente.php">
                <button class="btn_painel_interno"><i class="fa fa-user-plus"></i>Novo<br> Cliente</button>         
            </a>
        </div>
        <div class="col-6">
            <a href="listagem_clientes.php">
                <button class="btn_painel_interno"><i class="fa fa-list-ul"></i> Clientes<br> Cadastrados</button>
            </a>
        </div>

        <!--<div class="col-3">
            <a href="cadastrar_cliente.php">
                <button class="btn_painel_interno"><i class="fa fa-user-plus"></i>Novo<br>  Contato</button>         
            </a>
        </div>
        <div class="col-3">
            <a href="listagem_clientes.php">
                <button class="btn_painel_interno"><i class="fa fa-list-ul"></i> Novo<br> Agendamento</button>
            </a>
        </div>-->
        
    </div>
    
    <div class="titulo-secao">
        Próximos Prescritos:
    </div>
    
    <?php
        require_once 'Classes/cliente.php';
        $cliente = new Cliente();
        
        $cliente->listarClientes(true);
        
    
    ?>
    
    <div class="titulo-secao">
        Agendamentos para Hoje:
    </div>
    
    <?php
    
        require_once 'Classes/Agendamento.php';
        $agendamento = new Agendamento();
        
        //session_start();
        $_SESSION['agDeHJ'] = true;
        
        $agendamento->listarAgendados(0, 0);
        
    
    ?>
    
    <div class="titulo-secao">
        Retornos para hoje:
    </div>
    
</body></html>
    


