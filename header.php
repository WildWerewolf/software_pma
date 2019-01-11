<?php

//verifica se a variavel $_SESSION['idcolaborador'] existe, se não retorna a login
session_start();
if (!isset($_SESSION['idcolaborador'])) {
    header("Location: login.php");
}

echo '<div class="header">
            <div class="col-3 Logotipo_Header">
                <a href="painel_geral.php">
                    <img src="img/logotipo_empresa.png">
                </a>
            </div>
            <div class="col-8 menu_header">
                <ul>
                    <li>
                        <a href="painel_geral.php">
                            Início
                        </a>
                    </li>
                    <li>';

if ($_SESSION['admin'] == true) {
    echo '
                        <a href="colaboradores.php">
                            Colaboradores
                        </a>';
}
echo '
                    </li>
                    <li>
                        <a href="clientes.php">
                            Clientes
                        </a>
                    </li>
                    <li>
                        <a href="listagem_contato.php">
                            Contato
                        </a>
                    </li>
                    <li>
                        <a href="listagem_agendamentos.php">
                            Agendamentos
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-1">
                <a href="index.php?opcao=99">
                    <span class="header_sair">
                        Sair
                    </span>
                </a>
            </div>
        </div>
        <link href="fontawesome-free-5.4.1-web/css/all.min.css" rel="stylesheet" type="text/css" />';
