<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Painel de Contatos</title>
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
        Painel Contatos
    </div>
    <div class="container-cadastrar">
        <div class="col-6">
            <a href="registra_contato.php">
                <button class="btn_painel_interno"><i class="fa fa-user-plus"></i>Registrar Contato</button>         
            </a>
        </div>
        <div class="col-6">
            <a href="listagem_contato.php">
                <button class="btn_painel_interno"><i class="fa fa-list-ul"></i> Listar Contatos</button>
            </a>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>     