
<!DOCTYPE html>
<html lang="pt-br">

<head>
    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Listagem de Colaboradores</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script language="JavaScript" src="js/Jquery.mask.min.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>
     
    <div class="Site">
        <?php include "header.php";
            
        if(isset($_GET['incluir']) && isset($_POST)){
            require_once 'Classes/cliente.php';
            $cliente = new Cliente(); /*
            //$cliente->setTelefone($_POST['tel']);
            $cliente->setNome($_POST['nome']);
            $cliente->setTelefone($_POST['telefone']);
            $cliente->setCelular($_POST['celular']);
            $cliente->setEnder($_POST['ender']);
            $cliente->setAdverso($_POST['adverso']);
            $cliente->setRamo($_POST['ramo']);*/
            $dados = $_POST;
            $cliente->incluir($dados);
            
        }
        
        ?>
    </div>
    <div class="titulo-secao">
        CADASTRAR CLIENTE
    </div>
     <form method="POST" action="cadastrar_cliente.php?incluir=vai" onsubmit="return desativa_btn();"> 
    <div class="container-cadastrar">
      
        <div class="col-4">
            <span class="label_cadastro">Nome:</span>
            <input name="nome" class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>
        <div class="col-4">
            <span class="label_cadastro">Telefone:</span>
            <input name="telefone" class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>
        <div class="col-4">
            <span class="label_cadastro">Celular:</span>
            <input name="celular" class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>
        <div class="col-4">
            <span class="label_cadastro">E-mail:</span>
            <input name="email" class="cadastro_input" placeholder="Digite o e-mail do cliente">
        </div>
        
         <div class="col-4">
            <span class="label_cadastro">Endereço:</span>
            <input name="endereco" class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>
        
          <div class="col-4">
            <span class="label_cadastro">Adverso:</span>
            <input name="adverso" class="cadastro_input" id="adverso" placeholder="Digite o adverso do cliente" required>
        </div>
        
           <div class="col-4">
            <span class="label_cadastro">Cargo:</span>
            <input name="cargo" class="cadastro_input" id="adverso" placeholder="Digite o cargo do cliente" required>
        </div>
        <div class="col-4">
                 <span class ="label_cadastro">Data inicio na empresa:</span>
               <input type="date" name="datainiempresa" class="cadastro_input" placeholder="Data" required>
              
        </div>
        <div class="col-4">
                 <span class ="label_cadastro">Data final na empresa:</span>
               <input type="date" name="datafinalempresa" class="cadastro_input" placeholder="Data">
              
    
        </div>
        
        <div class="col-6">
            <span class="label_cadastro">Categoria:</span>
            <select  class="cadastro_input" name="ramo" required>
                <option value="">Selecione a categoria do adverso</option>
                 <?php 
                 
                     
                        require_once 'conexao.php';
                        $cnx = new conexao();
                   
                           $query = "SELECT * FROM ramo";
                          $dados = $cnx->executarQuery($query);
                          $linha = mysqli_fetch_array($dados);
                          $total = mysqli_num_rows($dados);
                          utf8_decode($query);
                          $cont = 0;
                          while ($cont < $total) {    
                            
                           echo  '<option value="'.$linha['id'] .'" >' . utf8_encode($linha['nome']) . '</option>';
                         
                           $linha = mysqli_fetch_assoc($dados);
                            $cont ++;
                          }
                  
                     
                  ?>
               
                    
         </select>          
        </div>
                
            
            
            <div class="col-6">
            <span class="label_cadastro">Indicação:</span>
            <select class="cadastro_input" name="indicacao">
                <option value="">Selecione quem indicou o cliente</option>
                 <?php 
                 
                     
                        require_once 'conexao.php';
                        $cnx = new conexao();
                   
                           $query = "select id, nome from cliente";
                          $dados = $cnx->executarQuery($query);
                          $linha = mysqli_fetch_array($dados);
                          $total = mysqli_num_rows($dados);
                          utf8_decode($query);
                          $cont = 0;
                          while ($cont < $total) {    
                            
                           echo  '<option value="'.$linha['id'] .'" >' . utf8_encode($linha['nome']) . '</option>';
                         
                           $linha = mysqli_fetch_assoc($dados);
                            $cont ++;
                          }
                           
                  ?>
            
            </select>
        </div>
        
        <!--<div class="col-4">
            <span class="label_cadastro">Ramo:</span>
            <input class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>-->
       
        <div class="col-6"><a href="painel_geral.php">
            <button type="button" class="cadastro_cancelar cadastro_btn" placeholder="Digite o nome do cliente">Cancelar</button></a>
        </div>
        <div class="col-6">
            <input type="submit" class="cadastro_cadastrar cadastro_btn" value="Cadastrar" id="btn_submit">
            <!--<button type="button" class="cadastro_cadastrar cadastro_btn" placeholder="Digite o nome do cliente">Cadastrar</button>-->
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