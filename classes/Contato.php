<?php

class Contato {

    private $idColaborador;
    private $idCliente;
    private $status;
    private $obs;
    private $data;
    private $dataContato;

    public function listarContatos($dtInicial, $dtFinal) {
        require_once 'conexao.php';
        $cnx = new conexao();
        $query = ('select adm from colaborador where id = ' . $_SESSION['idcolaborador']);
        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);

        //O comentario a baixo era para filtrar o administrador

        /* if($linha['adm'] != true){
          $where =' and cont.idcolaborador = '. $_SESSION['idcolaborador'];}
          else{
          $where ='';} */

        $query = "select cli.id, cli.nome as 'nome',
                  cli.telefone, cli.celular, cli.ender, cli.indicacao,
                  col.nome as 'colnome', col.id, 
                  cont.status, concat((day(cont.data)),'/',(month(cont.data)),'/',(year(cont.data))) as data
                  from ((cliente cli inner join contato cont on cli.id = cont.idcliente) 
                  inner join colaborador col on col.id = cont.idcolaborador)
                  where cont.data >='" . $dtInicial . "' and cont.data <='" . $dtFinal . "' ";
        //echo $query;

        $dados = $cnx->executarQuery($query);

        $linha = mysqli_fetch_array($dados);
        //echo $query;
        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);

        $cont = 0;
        echo'<div class="titulo-secao">
                TOTAL: ' . $total . '
             </div>';
        echo '<div class="tabela_listagem_clientes container-tabela">
        <table cellpadding="10" cellspacing="0" border="0" class="tabela-borda" width="100%">';
        echo '<tr class="tabela-categorias">
                <td><i class="fas fa-user"></i> Nome</td>
                <td><i class="fas fa-phone"></i> Telefone</td>
                <td><i class="fas fa-mobile-alt"></i> Celular</td>
                <td><i class="fas fa-map-marked-alt"></i> Endereço</td>
                <td><i class="fas fa-hand-point-right"></i> Indicação</td>
                <td><i class="fas fa-user"></i> Nome Colaborador</td>
                <td><i class="fas fa-user"></i> Data do Contato</td>
                <td><i class="fas fa-user"></i> Status</td>
            </tr>';


        while ($cont < $total) {

            echo '<tr class="tabela-preenchimento">'
            . '<td>' . $linha['nome'] . '</td>'
            . '<td>' . $linha['telefone'] . '</td>'
            . '<td>' . $linha['celular'] . '</td>'
            . '<td>' . $linha['ender'] . '</td>';

            //. '<td>' . $linha['indicacli'] . '</td>'
            if (!is_null($linha['indicacao'])) {
                $query = "select nome from cliente where id = " . $linha['indicacao'];
                $dados2 = $cnx->executarQuery($query);
                $linha2 = mysqli_fetch_array($dados2);
                echo '<td>' . $linha2['nome'] . '</td>';
            } else {
                echo '<td> - - - - - - - - </td>';
            }

            echo '<td>' . $linha['colnome'] . '</td>'
            . '<td>' . $linha['data'] . '</td>'
            . '<td>' . $this->resolveStatus($linha['status']) . '</td></tr>';
            //. '<td><button class="btn_editar">Editar</button></td></tr>';



            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }
        echo '</table></div>';
        //echo'	<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
        $cnx = null;
    }

    /**
     * Recebe um número de status de 0 a 17 (escrito em 30/03/2019) e retorna o nome do status informado.
     * Como default, retorna a palavra Todos. Isso deve ser usado quando todos os contatos forem selecionados para alguma ação no sistema.
     * 
     * Caso haja a necessidade de adicionar mais um status, é só adicionar um case ao final dos cases e antes do default.
     * 
     * Deve ser atualizado junto com geraSelectStatus para manter o sistema atualizado tanto em saída quanto entrada.
     * 
     * --Rubens
     */
    public function resolveStatus($status){
        switch ($status){
            case 0 : return 'Agendado'; break;
            case 1 : return 'Não atendido'; break;
            case 2 : return 'Não Interessado'; break;
            case 3 : return 'Número Errado'; break;
            case 4 : return 'Prescrito'; break;
            case 5 : return 'Possui Processo Ativo'; break;
            case 6 : return 'Reconquista'; break;
            case 7 : return 'Interessado'; break;
            case 8 : return 'Caixa Postal'; break;
            case 9 : return 'Atendido/Firmado'; break;
            case 10 : return 'Atendido/Não Firmado'; break;
            case 11 : return 'Atendeu e Desligou'; break;
            case 12 : return 'Reagendado'; break;
            case 13 : return 'Atendeu'; break;
            case 14 : return 'Agendamento Confirmado'; break;
            case 15 : return 'Não Compareceu'; break;
            case 16 : return 'Em Andamento'; break;
            case 17 : return 'Pendências'; break;
            default : return 'Todos'; break;

        }
    }

    /**
     * método para fazer a listagem das observações anteriores na tela de registro de contato
     * 
     * --Rubens
     */
        public function obterStatusAnteriores($idcli) {
        require_once 'conexao.php';
        $cnx = new conexao();

        $query = ("select cont.data as 'data' "
                . ",obs, cont.status, col.nome "
                . "from contato cont inner join colaborador col on cont.idcolaborador = col.id "
                . "where idcliente = " . $idcli . " order by 'data'");
        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);
        $total = mysqli_num_rows($dados);

        if ($total != 0) {
            $cont = 0;
            echo " <div class='col-6'>";
            while ($cont < $total) {

                // date('d/m/Y - H:i:s', strtotime($linha['data']))

                echo " 
            <span class='label_cadastro'> Data :" . date('d/m/Y - H:i:s', strtotime($linha['data']))
                . " - " . $this->resolveStatus($linha['status']) . " - Feito por: " . $linha['nome'] . "</span>
            <textarea name='obs' rows='4' cols='50' class='cadastro_input' disabled>" . $linha['obs'] . "</textarea>
        ";

                $linha = mysqli_fetch_assoc($dados);
                $cont++;
            }
            echo '</div>';
        }
    }


    public function criarContatos($formulario) {

        $idcolaborador = $_SESSION['idcolaborador'];
        $idcliente = $_SESSION['cliente'];
        $status = $formulario['status'];
        $obs = $formulario['obs'];

        if (!empty($formulario['datacontato'])) {
            $dataContato = "'" . $formulario['datacontato'] . "'";
            //echo $formulario['datacontato'];
        } else {
            $dataContato = 'null';
        }
        
        
        require_once 'conexao.php';
        $cnx = new conexao();

        $query = "insert into contato(idcolaborador,idcliente,status,obs,data,datacontato) "
                . "values($idcolaborador, $idcliente, $status,'$obs', now(), $dataContato)";
        //echo $query;
        $dados = $cnx->executarQuery($query);


        //header('Location: listagem_contato.php');
        header('Location: perfil_cliente.php?id='.$idcliente);
    }

    /**
     * Retorna o <select> para seleção dos status do contato.
     * Deve ser usado dentro de um <form> para ser usado de forma certa e gerar a variável status no formulário.
     * 
     * Caso haja a necessidade de adicionar mais um status, é só adicionar um <option> com o novo status depois do último <option>.
     * 
     * Deve ser atualizado junto com resolveStatus para manter o sistema atualizado tanto em saída quanto entrada.
     * 
     * --Rubens
     */
    public function geraSelectStatus(){
        echo '<span class="label_cadastro">Status:</span>
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
            
        </select>';
    }

    function getIdColaborador() {
        return $this->idColaborador;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getStatus() {
        return $this->status;
    }

    function getObs() {
        return $this->obs;
    }

    function getData() {
        return $this->data;
    }

    function getDataContato() {
        return $this->dataContato;
    }

    function setIdColaborador($idColaborador) {
        $this->idColaborador = $idColaborador;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setDataContato($data) {
        $this->data = $data;
    }

}
