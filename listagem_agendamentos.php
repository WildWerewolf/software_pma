<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Listagem de Agendamentos</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>
    <div class="Site">
        <?php include "header.php"; ?>
    </div>
    
    <div class="titulo-secao">
        Listagem de Agendamentos
        
    </div>
    <br>
    <form method="GET" action="listagem_agendamentos.php"><div>
    <div class="container-datas">
    
            <div class="col-4">
            <span class ="label_cadastro">data inicial:</span>
            <input type="date" name="dataini" class="cadastro_input" placeholder="Data" required>
            </div>
        <h1 class ="label_cadastro">até</h1>
        <div class="col-4">
               <span class ="label_cadastro">data final:</span>
               <input type="date" name="datafim" class="cadastro_input" placeholder="Data" required>
               </div>
        <div class="col-12">
        <input class="cadastro_btn" type="submit" name="enviar" value="Listar">
        </div>
        </div>
    <br>
   
        </div>
    </form>
    <?php
    
    if(isset($_GET['dataini']) && isset($_GET['datafim'])){
    require_once 'Classes/Agendamento.php';
    $ag = new Agendamento();
    $ag->listarAgendados($_GET['dataini'],$_GET['datafim']);
    
    }
    
    ?>
    <!--<div class="tabela_listagem_clientes container-tabela">
        <table cellpadding="10" cellspacing="0" border="0" class="tabela-borda" width="100%">';
        <tr class="tabela-categorias">
                <td><i class="fas fa-user"></i> Nome</td>
                <td><i class="fas fa-phone"></i> Telefone</td>
                <td><i class="fas fa-mobile-alt"></i> Celular</td>
                <td><i class="fas fa-map-marked-alt"></i> Endereço</td>
                <td><i class="fas fa-hand-point-right"></i> Indicação</td>
                <td><i class="fas fa-user"></i> Nome Colaborador</td>
            </tr>;
            <tr class="tabela-preenchimento">
                <td>Marcelo</td>
                <td>(21) 2665-8514</td>
                <td>(21) 96969-7261</td>
                <td><input type="checkbox" disabled></td>
                <td><button class="btn_editar">Editar</button><button class="btn_salvar">Salvar</button</td>
            </tr>
            <tr class="tabela-preenchimento">
                <td>Marcelo</td>
                <td>(21) 2665-8514</td>
                <td>(21) 96969-7261</td>
                <td><input type="checkbox" disabled></td>
                <td><button class="btn_editar">Editar</button><button class="btn_salvar">Salvar</button</td>
            </tr>
            <tr class="tabela-preenchimento">
                <td>Marcelo</td>
                <td>(21) 2665-8514</td>
                <td>(21) 96969-7261</td>
                <td><input type="checkbox" checked disabled></td>
                <td><button class="btn_editar">Editar</button><button class="btn_salvar">Salvar</button</td>
            </tr>
            <tr class="tabela-preenchimento">
                <td>Marcelo</td>
                <td>(21) 2665-8514</td>
                <td>(21) 96969-7261</td>
                <td><input type="checkbox" checked disabled></td>
                <td><button class="btn_editar">Editar</button><button class="btn_salvar">Salvar</button></td>
            </tr>
        </table>   
    </div>-->
</body>

</html>