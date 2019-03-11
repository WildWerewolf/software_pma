<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Listagem de Clientes</title>
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
        Listagem de Clientes
    </div>

    <div class="alfabeto">

        <?php
            
            /**
             * O código abaixo cria um alfabeto e torna as letras em links que indicam a inicial dos clientes 
             * que o usuário deseja listar.
             *  e essa é uam diferença nova só pra testar o commit
             * Rubens
             * 
             */
            $letra = 'a';
            $cont = 0;
            while($cont < 26){

                if(isset($_GET['letra'])){
                    $letraClicada = strtolower($_GET['letra']);
                    /**
                     * a condição acima verifica se já há uma letra selecionada
                     */
                    if($letra == $letraClicada){
                        /**
                         * se a ser listada já estiver selecionada, ela entra na classe css "letra_clicada"
                         * essa classe aumenta o tamanho dessa única letra em 5px;
                         * 
                         * Rubens
                         */
                        echo '<a class="letra_clicada" href="listagem_clientes.php?letra='.$letra.'">'.$letra.'</a>     ';
                    }else{
                        /**
                         * se a letra não foi selecionada, ela é listada com tamanho normal
                         */
                        echo '<a href="listagem_clientes.php?letra='.$letra.'">'.$letra.'</a>     ';
                    }                    

                }else{
                    /**
                     * se não houver letra selecionada ainda, todas elas ficam com o tamanho normal
                     */
                    echo '<a href="listagem_clientes.php?letra='.$letra.'">'.$letra.'</a>     ';
                }

                $letra++;
                $cont++;
            }
        
        ?>
 
    </div>

    <?php 
    if (isset($_GET['letra'])) {
        require_once 'classes/Cliente.php';
        $cliente = new Cliente();
        $cliente->listagemAlfabetica($_GET['letra']);
    }
    ?>

</body>

</html>