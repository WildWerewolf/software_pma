
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
            
        if(isset($_GET['formulario']) && isset($_POST)){
            require_once 'Classes/cliente.php';
            $cliente = new Cliente(); /*
            //$cliente->setTelefone($_POST['tel']);
            $cliente->setNome($_POST['nome']);
            $cliente->setTelefone($_POST['telefone']);
            $cliente->setCelular($_POST['celular']);
            $cliente->setEmail($_POST['email']);
            $cliente->setEnder($_POST['ender']);
            $cliente->setAdverso($_POST['adverso']);
            $cliente->setRamo($_POST['ramo']);*/
            $dados = $_POST;
            $cliente->atualizarCliente($dados);
            
        }
        
        ?>
    </div>
    <div class="titulo-secao">
        PERFIL DO CLIENTE
    </div>
     <form method="POST" action="perfil_cliente.php?formulario=vai" onsubmit="return desativa_btn();"> 
    <div class="container-cadastrar">
      
    <div class="col-12">
            <span class="label_cadastro">Nome:</span>
            <?php 
             
            if(isset($_GET['id'])){
                require_once 'classes/Cliente.php';
                $cli = new Cliente();
                $cli->instanciar($_GET['id']);
                
                $_SESSION['cliente']=$_GET['id'];
            
                echo '<input type="text" name="nome" value="'.$cli->getNome().'" class="cadastro_input" >';
            }
            ?>
              </div>
        
        <div class="col-4">
            <span class="label_cadastro">Telefone:</span>         
        
        <?php
            echo '<input type="text" name="telefone"  value="'.$cli->getTelefone().'" class="cadastro_input" >';
         ?>
        </div>
        
        <div class="col-4">
            <span class="label_cadastro">Celular:</span>
           <?php 
                echo '<input type="text" name="celular" value="'.$cli->getCelular().'" class="cadastro_input" >';
           ?>  
                </div>

                <div class="col-4">
            <span class="label_cadastro">E-mail:</span>
            <?php 
                echo '<input type="text" name="email" value="'.$cli->getEmail().'" class="cadastro_input" >';
           ?>          </div>

        
         <div class="col-4">
            <span class="label_cadastro">Endereço:</span>
            <?php 
                echo '<input type="text" name="endereco" value="'.$cli->getEnder().'" class="cadastro_input" >';
           ?>   
                  </div>
        
          <div class="col-4">
            <span class="label_cadastro">Adverso:</span>
            <?php 
                echo '<input type="text" name="adverso" value="'.$cli->getAdverso().'" class="cadastro_input" >';
           ?>        </div>
        
           <div class="col-4">
            <span class="label_cadastro">Cargo:</span>
            <?php 
                echo '<input type="text" name="cargo" value="'.$cli->getCargo().'" class="cadastro_input" >';
           ?> 
                   </div>
        <div class="col-4">
                 <span class ="label_cadastro">Data inicio na empresa:</span>
               
               <?php 
                echo '<input type="date" name="datainiempresa" value="'.$cli->getDataIniEmpresa().'" class="cadastro_input" >';
           ?>
        </div>
        <div class="col-4">
                 <span class ="label_cadastro">Data final na empresa:</span>
                 <?php 
                echo '<input type="date" name="datafinalempresa" value="'.$cli->getDataFinalEmpresa().'" class="cadastro_input" >';
           ?>
    
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
                                 
                            if ($cli->getRamo() ==  $linha['id']){
                                echo  '<option value="'.$linha['id'] .'" selected>' . utf8_encode($linha['nome']) . '</option>';
                            }else{
                               echo  '<option value="'.$linha['id'] .'">' . utf8_encode($linha['nome']) . '</option>';
                           }
                           
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

                        /**
                         * query para pegar todos os clientes menos o que foi "perfilado"
                         */
                        $query = 'select id, nome from cliente where id != '.$cli->getId();
                        $dados = $cnx->executarQuery($query);
                        $linha = mysqli_fetch_array($dados);
                        $total = mysqli_num_rows($dados);

                        /**
                         * se a indicação não for nula, lista tudo mas deixa 1 selecionado (o indicado)
                         * se a indicação for nula, lista todos os clientes mas não deixa ninguém selecionado
                         */
                        if(!is_null($cli->getIndicacao())){
                            while ($cont < $total) { 
                                 
                                if ($cli->getIndicacao() ==  $linha['id']){
                                    echo  '<option value="'.$linha['id'] .'" selected>' . utf8_encode($linha['nome']) . '</option>';
                                }else{
                                   echo  '<option value="'.$linha['id'] .'">' . utf8_encode($linha['nome']) . '</option>';
                               }

                           echo  '<option value="'.$linha['id'] .'" >' . utf8_encode($linha['nome']) . '</option>';
                         
                           $linha = mysqli_fetch_assoc($dados);
                            $cont ++;
                          }
                        }else{
                            while ($cont < $total) { 
                                 
                                echo  '<option value="'.$linha['id'] .'">' . utf8_encode($linha['nome']) . '</option>';
                               
                           $linha = mysqli_fetch_assoc($dados);
                            $cont ++;
                        }
                    }
                        
                           
                  ?>
            
            </select>
        </div>
        
        <!--<div class="col-4">
            <span class="label_cadastro">Ramo:</span>
            <input class="cadastro_input" placeholder="Digite o nome do cliente" required>
        </div>-->
        <div class="col-2">
            <input type="submit" class="cadastro_cadastrar cadastro_btn" value="Alterar" id="btn_submit">
            <!--<button type="button" class="cadastro_cadastrar cadastro_btn" placeholder="Digite o nome do cliente">Cadastrar</button>-->
        </div>
        <div class="col-2"><a href="listagem_clientes.php">
            <button type="button" class="cadastro_cancelar cadastro_btn" placeholder="Digite o nome do cliente">Voltar</button></a>
        </div>
                    
                    
                    <?php
                    echo '<div class="col-2"><a href="registra_contato.php?id='. $_GET['id'] . '">
                   <button type="button" class="btn_editar cadastro_btn" placeholder="Digite o nome do cliente">Contato</button></a>
                </div>';
                    



echo'
        <div class="col-2"><a href="registra_agendamento.php?id='. $_GET['id'] . '">
            <button type="button" class="btn_salvar cadastro_btn" placeholder="Digite o nome do cliente">Agendar</button></a>
        </div>';
        ?>
    
    </div>
        </form>
    
    <script>
function desativa_btn() {
    document.getElementById("btn_submit").disabled = true;
}
</script>
</body> 
</html>