<?php

class Agendamento {

    private $id;
    private $idCliente;
    private $data;
    private $idColcad;
        
    public function listarAgendados($dtInicial, $dtFinal) {
        require_once 'conexao.php';
        $cnx = new conexao();
         $query = ('select adm from colaborador where id = '.$_SESSION['idcolaborador']);
        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);
		
		//O comentario a baixo era para filtrar o administrador
		
        /*if($linha['adm'] != true){
        $where =' and a.idcolcad = '. $_SESSION['idcolaborador'];}
        else{
    $where ='';}*/
	
	/* RUBENS 28/12/2018:
         * por causa uma demanda do cliente separei a cláusula where da query abaixo e coloquei dentro de uma condição
         * que depende da variável session "agDeHJ" (agendamento de hoje) declarada em painel_geral.php linha 75
         */
        
        
        
        $query = ("select cast(a.data as time) as 'hora', cast(a.data as date) as 'data', c.nome, c.telefone, c.celular, c.ender, c.indicacao
                   from agendamento a inner join cliente c on a.idcliente = c.id ");
        
        /* RUBENS 28/12/2018:
         * a condição abaixo depende da variável session "adDeHJ" explicada no comentário acima
         * 
         * se TRUE, ela faz com que a cláusula where só considere os agendamentos para o dia atual em que ela é usada (hoje)
         * se FALSE, ela permite a cláusula where considerar o intervalo de 
         *   tempo "$dtInicial" e "$dtFinal" (utilizadas quando acessado pela página de listagem de agendamentos)
         * 
         */
        
        if(isset($_SESSION['agDeHJ'])){
            if($_SESSION['agDeHJ'] == true){
                $query = $query.'where cast(a.data as date) >= cast(now() as date) and cast(a.data as date) <= cast(now() as date) order by a.data';
                $_SESSION['agDeHJ'] = FALSE;
            }else{
            $query = $query."where a.data >='" . $dtInicial . "' and a.data <= '" . $dtFinal ."' order by a.data";
            }
        }else{
            $query = $query."where a.data >='" . $dtInicial . "' and a.data <= '" . $dtFinal ."' order by a.data";
        }
        
        
        //echo $query;
        
        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);
        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);
        $cont = 0;
        echo '<div class="tabela_listagem_clientes container-tabela">
        <table cellpadding="10" cellspacing="0" border="0" class="tabela-borda" width="100%">';
         echo '<tr class="tabela-categorias">
             
            <td><i class="fas fa-user"></i> Nome</td>
            <td><i class="fas fa-ungler-down"></i> Data</td>
            <td><i class="fas fa-ungler-down"></i> Hora</td>
            <td><i class="fas fa-user"></i> Nome</td>
            <td><i class="fas fa-phone"></i> Telefone</td>
            <td><i class="fas fa-mobile-alt></i> Celular </td>
            <td><i class="fas fa-marked-alt"></i> Endereço </td>
            <td><i class="fas fa-hand-point-right"></i> Indicação</td>
            </tr>';
         
          while ($cont < $total) {

            echo '<tr class="tabela-preenchimento">'
            . '<td>' . $linha['nome'] . '</td>'
            . '<td>' . $linha['data'] . '</td>'
            . '<td>' . $linha['hora'] . '</td>'
            . '<td>' . $linha['telefone'] . '</td>'
            . '<td>' . $linha['celular'] . '</td>'
            . '<td>' . $linha['ender'] . '</td>';
            
            // verifica se a indicação obtida é null
            //  se sim, imprime tracinhos kkkk
            //  senão, busca e imprime o nome do cliente que indicou
            if(!is_null($linha['indicacao'])){
                    $query = "select nome from cliente where id = ".$linha['indicacao'];
                    $dados2 = $cnx->executarQuery($query);
                    $linha2 = mysqli_fetch_array($dados2);
                    echo '<td>'.$linha2['nome'].'</td>';}
                else{
                    echo '<td> - - - - - - - - </td>';
                }
            
            //echo '<td><button class="btn_editar">Editar</button></td></tr>';
            
            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }
        echo '</table></div>';
      //  echo'	<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';*/
    }

   public function criarAgendamentos($dados) {
        require_once 'conexao.php';
        $cnx = new conexao();
        $idcliente = $_SESSION['cliente'];
        $data = $dados['data']." ".$dados['hora'];
        $idcolcad = $_SESSION['idcolaborador'];
        $tipo = $dados['tipo'];
        
        require_once 'conexao.php';
        $cnx = new conexao();
        
        $query = "insert into agendamento(idcliente,data,tipo,idcolcad) "
                . "values($idcliente,'$data',$tipo,$idcolcad)";
        //echo $query;
        $dados = $cnx->executarQuery($query);
        
        
        header('Location: listagem_agendamentos.php');
    }

//echo $query;





    function getId() {
        return $this->id;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setData($data) {
        $this->data = $data;
    }
    
    function getIdColcad() {
        return $this->idColcad;
    }

    function setIdColcad($idColcad) {
        $this->idColcad = $idColcad;
    }



}
