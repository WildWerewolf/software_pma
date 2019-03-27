<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Contatos Totais de Colaboradores</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>

    <div class="Site">
        <?php
        /**
     *  o include abaixo permite a verificação de login e incluí o cabeçalho na página.
     *  sem ele, é só digitar o nome dessa página que ela será carregada sem identificação.
     * --Rubens
     */

        include_once "header.php";

        ?>

    </div>

    <div class='col-12'>
        <div class="titulo-secao">
            Contatos Totais de Colaborador
        </div>
        <br>
        <div class="container-div col-6">
            <form method='POST' action="contatos_totais.php?acao=true">


                <span class="label_cadastro">Mês:</span>
                <select name="mes" class="cadastro_input">
                    <option value="">Selecione o mês</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <span class="label_cadastro">Ano:</span>
                <select name="ano" class="cadastro_input">
                    <option value="">Selecione o ano</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                </select>

                <div class="Form_Lembrar">
                    <input type="checkbox" name="semana" value="true" class="Form_Lembrar_checkbox">
                    <span class="Form_Lembrar_label">Últimos 5 dias</span>

                </div><br><br><br>

                <span class="label_cadastro">Qual status?</span>
                <select name="statusContato" class="cadastro_input">
                    <option value="">Todos</option>
                    <option value="0">Agendado</option>
                    <option value="1">Não atendido</option>
                    <option value="2">Não interessado</option>
                    <option value="3">Número Errado</option>
                    <option value="4">Prescrito</option>
                    <option value="5">Possui Processo Ativo</option>
                    <option value="6">Reconquista</option>
                    <option value="7">Interessado</option>
                    <option value="8">Caixa Postal</option>
                    <option value="9">Atendido/Firmado</option>
                    <option value="10">Atendido/Não Firmado</option>
                    <option value="11">Atendeu e Desligou</option>
                    <option value="12">Reagendado</option>
                    <option value="13">Atendeu</option>
                    <option value="14">Agendamento Confirmado</option>
                    <option value="15">Não Compareceu</option>
                </select>




                <button type="submit" class="cadastro_cadastrar cadastro_btn" placeholder="Digite o nome do cliente"
                    id="btn_submit">contar</button>
                <br><br>

            </form>

        </div>

        <br>






        <div class="container-div col-6">


            <?php

        // ideia para classe de erro - declaração
        $erro = '<strong> Erro - Por Favor, tente novamente </strong>';

        if (isset($_GET['acao'])) { //verifica se $_GET['acao'] está setada
            if ($_GET['acao'] == true) { //verifica se $_GET['acao'] é true
                if (isset($_POST['semana'])) {

                    // se $_POST['semana'] estiver setado, não precisa verificar os outros campos
                    require_once 'classes/Totais.php';
                    $totais = new Totais();

                    $totais->resultadosDaSemana($_POST['semana'], $_POST['statusContato']);
                } else {
                    if (!empty($_POST['mes']) && !empty($_POST['ano']) && isset($_POST['statusContato'])) {

                        //se estiver tudo setado exceto semana, isso é executado pra mostrar os totais dentro do mês informado
                        require_once 'classes/Totais.php';
                        $totais = new Totais();

                        $totais->resultadosDoMês($_POST['mes'], $_POST['ano'], $_POST['statusContato']);
                    } else { //se $_POST['mes'], $_POST['ano'] e $_POST['statusContato'] não estiverem setadas, encaminha o usuario para a pagina de erro
                        //header("Location: contatos_totais.php?erro=camposfaltando");
                        //ideia para classe de erro - chamada
                        echo $erro;
                    }
                }
            } else { // se $_GET['acao'] for qualquer coisa diferente de true, encaminha o usuario para pagina de erro
                //header("Location: contatos_totais.php?erro=acaonaoetrue");
                //ideia para classe de erro - chamada
                echo $erro;
            }
        } else { // se $_GET['erro'] estiver setado, escreve uma mensagem de erro
            if (isset($_GET['erro'])) {
                //ideia para classe de erro - chamada
                echo $erro;
            }
        }?>

        </div>

    </div>
    </div>
</body>

</html>