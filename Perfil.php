<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Perfil de Clientes</title>
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
        Perfil do Cliente
    </div>
       <?php 
        require_once 'classes/Cliente.php';
        $cliente = new Cliente();
        
        if(isset($_POST['idcol'])){
            
            $formulario = $_POST;
            
            // método para alteração do colaborador
            $cliente->atualizarCliente($formulario);
            
        }else{
            $cliente->listarClientes($verprescritos);
        
        }
    ?>
    
</body>

</html>