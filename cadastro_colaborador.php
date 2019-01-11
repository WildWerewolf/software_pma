<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Listagem de Colaboradores</title>
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
            require_once 'Classes/colaborador.php';
            $colaborador = new Colaborador();
            $formulario = $_POST;
            $colaborador->incluirColaborador($formulario);
            
        }
        
        ?>
    </div>
    <div class="titulo-secao">
        Cadastrar colaborador
    </div>
    <form method="POST" action="cadastro_colaborador.php?incluir=vai" onsubmit="return desativa_btn();">
    <div class="container-cadastrar">
        
        <div class="col-12">
            <span class="label_cadastro">Nome:</span>
            <input class="cadastro_input" name="nome" type="text" placeholder="Digite o nome do novo colaborador" required>
        </div>
        <div class="col-6">
            <span class="label_cadastro">Login:</span>
            <input class="cadastro_input" name="login" type="text" placeholder="Digite um nome de acesso ao sistema" required>
        </div>
        <div class="col-6">
            <span class="label_cadastro">Senha:</span>
            <input class="cadastro_input" name="senha" type="password" placeholder="Digite uma senha" required>
        </div>
        <!--<div class="col-12">
            <input class="" name="admin" type="checkbox">
            <span class="checkbox_admin ">Admin</span>
        </div>-->
        <br>
        <br>
        <br>
        <div class="col-6">
            <a href="colaboradores.php">
            <button type="button" class="cadastro_cancelar cadastro_btn" placeholder="Digite o nome do cliente">Cancelar</button>
            </a>
        </div>
        <div class="col-6">
            <input type="submit" class="cadastro_cadastrar cadastro_btn" value="CADASTRAR" id="btn_submit">
            
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