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
        <?php include "header.php";?>
    </div>
    <div class="titulo-secao">
        Listagem de Colaboradores
    </div>
       <?php 
        require_once 'classes/Colaborador.php';
        $colaborador = new Colaborador();
        
        if(isset($_POST['idcol'])){
            
            $formulario = $_POST;
            
            // método para alteração do colaborador
            $colaborador->atualizarColaborador($formulario);
            
        }else{
            $colaborador->listarColaboradores();
        
        }
    ?>
    
</body>

</html>