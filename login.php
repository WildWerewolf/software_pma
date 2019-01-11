<?php 

session_unset();


echo '<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Login</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fontawesome-free-5.4.1-web/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

    
    
<body class="Body_Index">
    
    <div class="Site">
     
        <div class="creditos_rads">
            <span>
                Desenvolvido por<br>
                <img src="img/rads.png">
            </span>
        </div>
        <div class="Area_Login" data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500" data-aos-duration="1000">
            <div class="Logotipo_Area_Login">
                <img src="img/logotipo_empresa.png" alt="PMA Advocacia" title="PMA Advocacia" class="Item_Logotipo_Area_Login">
            </div>';

            // verifica se recebeu a variável $_GET['erro'] está ausente
            // essa variável deve ser declarada e mandada por index.php ao verificar os dados de login
            if(!isset($_GET['erro'])){
            // se estiver ausente, imprime uma mensagem de boas vindas
            echo'
            <div class="Frase_Bemvindo_Area_Login">
                <span>
                    Olá, seja bem-vindo!
                </span>
            </div>';}
            // senão, imprime uma mensagem de erro sobre login e senha
            else{
                echo'
            <div class="Frase_Bemvindo_Area_Login">
                <span>
                    Login ou senha inválidos
                </span>
            </div>';}
            
            echo '
            <div class="formulario">
                <form method="POST" action="index.php?tentativa=true" class="Formulario_login_container">
                    <span class="Formulario_Login_Label"><i class="fas fa-user"></i> Login</span>
                    <input placeholder="Digite seu login" class="Formulario_Login_Input" name="login" required>

                    <span class="Formulario_Login_Label Senha_Login"><i class="fas fa-unlock-alt"></i> Senha</span>
                    <input type="password" placeholder="Digite sua senha" class="Formulario_Login_Input" name="senha" required>
                '/*<div class="Form_Lembrar">
                    <input type="checkbox" class="Form_Lembrar_checkbox">
                    <span class="Form_Lembrar_label">Lembrar dados</span>
                    
                </div>*/.'
                <input class="Btn_Formulario_Login" type="submit" name="enviar" value="Acessar">
                </form>
                
                <!--<a href="painel_geral.php" target="_self">
                    <button class="Btn_Formulario_Login">Acessar</button>
                </a>-->
            </div>
        </div>
    </div>

<script>
    AOS.init();
</script>

</body>

</html>';
