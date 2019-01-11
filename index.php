<?php

//require 'conexao.php';


function incluir1() {

    echo'
	<form action="index.php?opcao=3&etapa=2" method="POST" style="color:#f00">
	NOME:         <br><input type="text" name="nome"> <br>
	LOGIN:         <br><input type="text" name="login"> <br>
	SENHA:         <br><input type="text" name="senha"> <br>
	<input type="submit" name="enviar" value="CONFIRMAR">
	<input type="reset" name="enviar" value="LIMPAR">
	</form>
	<HR>
		<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
}

function inclusao1() {
    $col = new Adm();
    $col->setNome($_POST['nome']);
    $col->setLogin($_POST['login']);
    $col->setSenha($_POST['senha']);
    $col->incluir1();

    echo '<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
}

function pesquisar1($or) {
    echo'
	<form action="index.php?opcao=' . $or . '&etapa=2" method=POST style="color:#f00">
	ID:                   <br><input type="text" name="id"> <br>
	<input type="submit" name="enviar" value="CONFIRMAR">
	<input type="reset" name="enviar" value="LIMPAR">
	</form>
	<HR>
		<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
}

function pesquisar12($or) {
    if (isset($_POST['id'])) {


        $col = new Adm();
        $col->setId($_POST['id']);
        $resultado = $col->pesquisar1();

        if ($resultado == 0) {

            echo "<H1> ID Não Encontrado </H1>";
            echo "<HR> \n <A HREF=index.php?opcao=3&etapa1>Voltar para Pesquisa</A> <br> \n";
            echo "<A HREF=index.php?opcao=0>Voltar para o Menu Principal</A> \n";
        } else {
            echo ' <form action="index.php?opcao=' . $or . '&etapa=3" method=POST style="color:#f00"> ';
            echo ' ID:                   <br><input type="text" name="id" value="' . $col->getId() . '"> <br>';
            echo ' NOME:         <br><input type="text" name="nome" value="' . $col->getNome() . '"> <br>';
            echo ' LOGIN:         <br><input type="text" name="login" value="' . $col->getLogin() . '"> <br>';
            echo ' SENHA:         <br><input type="text" name="senha" value="' . $col->getSenha() . '"> <br>';
            if ($col->getStatus() == true) {

                echo ' STATUS:         <br><input type="radio" name="status" value= "true" checked > Ativo <br>';
                echo '<input type="radio" name="status" value= "false"> Inativo <br>';
            } else {

                echo ' STATUS:         <br><input type="radio" name="status" value= "true"> Ativo <br>';
                echo '<input type="radio" name="status" value= "false" checked > Inativo <br>';
            }


            if ($or == 7 || $or == 9) {
                echo ' <input type="submit" name="enviar" values="CONFIRMAR">';
            }
            echo ' </form>';
            echo ' <HR>';
            echo'	<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
        }
    } else {

        echo "<H1> COD Invalido </H1>";
        echo "<HR> <A HREF=index.php?opcao=0>Voltar Para Menu Principal</A>";
    }
}

require ('classes/Adm.php');

$col = new Adm();

session_start();


if (isset($_SESSION['idcolaborador'])) {
    
    //header('painel_geral.php');
    if (isset($_GET['opcao'])) {

        $opcao = $_GET['opcao'];

        if ($opcao == 0) {
            /* echo '<html>

              <head>
              <meta charset="utf-8">
              <title> Menu</title>
              </head>
              <body style = "background-color:gray">

              <center>

              <div style = "background-color:green; width:20%;">
              <fieldset style=" padding: 2%"><legend>Opções:</legend>
              <div style = "background-color:#1d4c84;"><fieldset><legend>Cliente:</legend>
              <a href=index.php?opcao=11 style="color:#fff">1 - listar</a><br>
              <a href=index.php?opcao=10&etapa=0 style="color:#fff">2 - Cadastrar</a><br>
              <a href=index.php?opcao=5&etapa=1 style="color:#fff">3 - Pesquisar</a><br>
              <a href=index.php?opcao=9&etapa=1 style="color:#fff">4 - Alterar</a><br>
              </fieldset></div>

              <div style = "background-color:red;"><fieldset><legend>Colaboradores:</legend>
              <a href="index.php?opcao=1&etapa=1" style="color:#fff">1 - listar</a><br>
              <a href="index.php?opcao=3&etapa=1" style="color:#fff">2 - Cadastrar</a><br>

              <!--<a href=index.php?opcao=7&etapa=1 style="color:#fff">4 - Excluir</a><br>-->

              <a href=index.php?opcao=5&etapa=1 style="color:#fff">3 - Pesquisar</a><br>
              <a href=index.php?opcao=9&etapa=1 style="color:#fff">4 - Alterar</a><br>
              </fieldset></div>
              </fieldset></div>

              </center>

              </body>
              </html>'; */
            
            echo $_SESSION['idcolaborador'];
            //require_once 'painel_geral.php';
            //header('Location: painel_geral.php');
            
            
        }

        if ($opcao == 1) {
            $col->lista1();
            //lista1();
        }

        if ($opcao == 3) {

            if (isset($_GET['etapa'])) {
                $etapa = $_GET['etapa'];
                if ($etapa == 1)
                    incluir1();
                if ($etapa == 2) {
                    inclusao1();
                    $col->lista1();
                }
            }
        }

        if ($opcao == 5) {
            $or = 5;

            if (isset($_GET['etapa'])) {
                $etapa = $_GET['etapa'];
                if ($etapa == 1)
                    pesquisar1($or);
                if ($etapa == 2) {
                    pesquisar12($or);
                }
            }
        }

        if ($opcao == 7) {
            $or = 7;
            if (isset($_GET['etapa'])) {
                $etapa = $_GET['etapa'];
                if ($etapa == 1)
                    pesquisar1($con, $or);
                if ($etapa == 2) {
                    pesquisar12($con, $or);
                }
                if ($etapa == 3) {
                    excluir1($con);
                    lista1($con);
                }
            }
        }

        if ($opcao == 9) {
            $or = 9;
            if (isset($_GET['etapa'])) {
                $etapa = $_GET['etapa'];
                if ($etapa == 1)
                    pesquisar1($or);
                if ($etapa == 2) {
                    pesquisar12($or);
                }
                if ($etapa == 3) {
                    $col->atualizar1();
                    lista1();
                }
            }
        }

        //inclusão de cliente no banco
        if ($opcao == 10) {
            if (isset($_GET['etapa'])) {
                $etapa = $_GET['etapa'];

                //carrega um form para preenchimento
                if ($etapa == 0) {
                    $col->incluirCliente();
                }

                //manda os dados do form($_POST)na etapa anterior para a classe cliente            
                if ($etapa == 1) {
                    require_once 'Cliente.php';
                    if (isset($_POST)) {
                        $dados = $_POST;
                        $cli = new Cliente();
                        $cli->incluir($dados);
                    }
                }
            }
        }

        if ($opcao == 11) {
            $col->listarClientes();
        }

        if ($opcao == 99) {
            session_unset();
            session_destroy();
            header('Location: index.php');
        }
    } else {
        header('Location: painel_geral.php');
    }
} else {

    if (isset($_GET['tentativa'])) {
        if (isset($_POST['login']) && isset($_POST['senha'])) {
            require_once 'conexao.php';
            $cnx = new conexao();
            if ($cnx->checarLogin($_POST)) {
                
                session_start();

                //session_id($cnx->checarLogin($_POST));

                $_SESSION['idcolaborador'] = $cnx->checarLogin($_POST);

                //echo $_SESSION['idcolaborador'];

                //require 'painel_geral.php';
                
                header('Location: index.php');
            } else {
                require_once 'login.php';
                header('Location: login.php?erro=true');
            }
        } else {
            require_once 'login.php';
            header('Location: login.php');
        }
    } else {
        /*if (isset($_SESSION['idcolaborador'])) {
            //echo 'uhuls';
            header('painel_geral.php');
        } else {
            require_once 'login.php';
            header('Location: login.php');
        }*/
        require_once 'login.php';
        header('Location: login.php');
    }
}
?>