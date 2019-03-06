<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <title>PMA Advocacia - Registrar Contatos</title>
    <script language="JavaScript" src="js/jquery-3.3.1.js"></script>
    <script src="aos/aos.js"></script>
    <link href="aos/aos.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="fonts/Hind-Regular.ttf" rel="stylesheet">
</head>

<body>
    <div class="Site">
        <?php include "header.php"; 
            
        if(isset($_GET['incluir']) && isset($_POST)){
            require_once 'Classes/contato.php';
            $contato = new Contato();
            
            $dados = $_POST;
            $contato->criarContatos($dados);
            
        }
        
        ?>
   
        
    </div>
    <div class="titulo-secao">
        Registrar Contato
    </div>
    <form method="POST" action="registra_contato.php?incluir=vai" onsubmit="return desativa_btn();"> 
    <div class="container-cadastrar">
        <div class="col-12">
            <span class="label_cadastro">Colaborador:</span>
           <?php
          
                require_once 'classes/Colaborador.php';
                $col = new Colaborador();
                $col->instanciar();
                
            
                echo '<input type="text" value="'.$col->getNome().'" class="cadastro_input" disabled>';
           
           
           ?>
            
        
        </div>
        <div class="col-6">
            <fieldset>
            <span class="label_cadastro">Cliente:</span>
             <?php 
             
            if(isset($_GET['id'])){
                require_once 'classes/Cliente.php';
                $cli = new Cliente();
                $cli->instanciar($_GET['id']);
                
                $_SESSION['cliente']=$_GET['id'];
            
                echo '<input type="text" value="'.$cli->getNome().'" class="cadastro_input" disabled>';
            }
            
            ?>
            
            <span class="label_cadastro">Status:</span>
            <select name="status" class="cadastro_input" required>
                <option value="">Como foi o contato?</option>
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
                <option value="16">Em Andamento</option>
                <option value="17">Pendências</option>
				
            </select>
        
            <span class="label_cadastro">Observação:</span>
            <textarea name="obs" rows="4" cols="50" class="cadastro_input" placeholder="Digite uma observação."></textarea>
        
        
         
            <span class ="label_cadastro">Retornar contato em:</span>
               <input type="date" name="datacontato" class="cadastro_input" placeholder="Data">
              
        
               </fieldset>
        
     
        </div>
        <?php
            require_once 'Classes/Contato.php';
            $contato = new Contato();
            
            $contato->obterStatusAnteriores($_GET['id']);
            
        ?>

        	<br>
        	<br>
        <div class="col-6">
            <a href="listagem_clientes.php">
            <button type="button" class="cadastro_cancelar cadastro_btn" placeholder="Digite o nome do cliente">Cancelar</button>
            </a>
        </div>
        <div class="col-6">
            <button type="submit" class="cadastro_cadastrar cadastro_btn" placeholder="Digite o nome do cliente" id="btn_submit">Cadastrar</button>
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