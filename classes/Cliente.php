<?php

class Cliente {

    private $id;
    private $nome;
    private $telefone;
    private $celular;
    private $email;
    private $ender;
    private $adverso;
    private $cargo;
    private $ramo;
    private $indicacao;
    private $idcolcad;
    private $datacadastro;

    //pega os dados recebidos de index(opcao 10, etapa 1)
    //usa esses dados para preencher a variavel query e fazer a inclusão através da classe conexao
    public function incluir($dados) {
        $this->setNome(strtoupper($dados['nome']));
        $this->setTelefone($dados['telefone']);
        $this->setCelular($dados['celular']);
        $this->setEmail($dados['email']);
        $this->setEnder($dados['endereco']);
        $this->setAdverso(strtoupper($dados['adverso']));
        $this->setCargo(strtoupper($dados['cargo']));
        $this->setRamo($dados['ramo']);
        if (empty($dados['indicacao'])) {
            $this->setIndicacao('null');
        } else {
            $this->setIndicacao($dados['indicacao']);
        }
		if(!empty($dados['datainiempresa'])) {
         $this->setDataIniEmpresa("'".$dados['datainiempresa']."'");
		}else {
                  $this-> setDataIniEmpresa('null');
                }
         
         //$this->setDataFinalEmpresa($dados['datafinalempresa']);
        if(!empty($dados['datafinalempresa'])) {
                   $this->setDataFinalEmpresa("'".$dados['datafinalempresa']."'");
              } else {
                  $this-> setDataFinalEmpresa('null');
                }
        
        require_once 'conexao.php';
        $cnx = new conexao();
        
        $this->setIdcolcad($_SESSION['idcolaborador']);

        $queryadverso = "insert into adverso (nome, id_ramo, idcolcad) values ('" . $this->adverso . "'," . $this->ramo . "," . $this->idcolcad . ")";

        echo $queryadverso . '<br><br>';

        

        $cnx->executarQuery($queryadverso);

        $resultado = $cnx->executarQuery("select max(id) as 'idadverso' from adverso where idcolcad=" . $this->idcolcad);

        $linha = mysqli_fetch_array($resultado);

        $this->setAdverso($linha['idadverso']);

       
        
        $query = ("insert into cliente (nome, telefone, celular, email, ender, cargo, indicacao, idcolcad, datacadastro,datainiempresa,datafinalempresa) values "
                . "('$this->nome','$this->telefone','$this->celular','$this->email','$this->ender','$this->cargo',$this->indicacao,$this->idcolcad,now(),$this->datainiempresa,$this->datafinalempresa);");
        
        echo $query . '<br><br>';

        $dados = $cnx->executarQuery($query);

        $query = "select max(id) as 'idcliente' from cliente where idcolcad=" . $this->idcolcad;

        $resultado = $cnx->executarQuery($query);

        $linha = mysqli_fetch_array($resultado);

        $this->setId($linha['idcliente']);

        $query = "insert into processo values($this->id,$this->adverso)";

        echo $query . '<br><br>';

        $cnx->executarQuery($query);
			
        header("Location: listagem_clientes.php");
    
	}


    /**
     * Recebe o id de um cliente. Usa esse id para buscar os dados desse cliente no banco e atualizar os valores desta classe para poder utilizá-los.
     * 
     * Método feito por Douglas
     * 
     * --Rubens
     */
    public function instanciar($id) {

        $this->setId($id);
        $query = "select 
        c.id,c.nome,c.telefone,c.celular,c.ender,c.cargo,c.datainiempresa,c.datafinalempresa,c.indicacao,c.email,
        a.id as 'idadverso',a.nome as 'adverso',
        r.id as 'idramo',r.nome as 'ramo' 
         from (((cliente c
         inner join processo p on p.idCliente = c.id)
         inner join adverso a on a.id = p.idAdverso)
         inner join  ramo r on r.id = a.id_Ramo)
         where c.id = " . $id;

        require_once 'conexao.php';
        $cnx = new conexao();

        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);
        $this->setNome($linha['nome']);
        $this->setTelefone($linha['telefone']);
        $this->setCelular($linha['celular']);
        $this->setEmail($linha['email']);
        $this->setEnder($linha['ender']);
        $this->setAdverso($linha['adverso']);
        $this->setCargo($linha['cargo']);
        $this->setDataIniEmpresa($linha['datainiempresa']);
        $this->setDataFinalEmpresa($linha['datafinalempresa']);
        $this->setRamo($linha['idramo']);
        $this->setIndicacao($linha['indicacao']);
    }

	
	//abaixo é o atualizarCliente editado por Douglas
	
	   public function atualizarCliente($formulario) {
        require_once 'conexao.php';
        $cnx = new conexao();
        $idcliente = $_SESSION['cliente'];
        $query = "update cliente set ";
        
        if(isset($formulario['nome'])){
            $query = $query."nome = '".strtoupper($formulario['nome'])."',";
        }
        
        if(isset($formulario['telefone'])){
            $query = $query."telefone = '".strtoupper($formulario['telefone'])."',";
        }
        
        if(isset($formulario['celular'])){
            $query = $query."celular = '".strtoupper($formulario['celular'])."',";
        }

        if(isset($formulario['email'])){
            $query = $query."email = '".strtoupper($formulario['email'])."',";
        }
		
		if(isset($formulario['datainiempresa'])){
            $query = $query."datainiempresa = '".strtoupper($formulario['datainiempresa'])."',";
        }
		
		if(isset($formulario['datafinalempresa'])){
            if(empty($formulario['datafinalempresa'])) {
                $query = $query.'datafinalempresa = null , ';        
               } else {
                $query = $query."datafinalempresa = '".strtoupper($formulario['datafinalempresa'])."',";
             }
     
           
        }
		
		if(isset($formulario['cargo'])){
            $query = $query."cargo = '".strtoupper($formulario['cargo'])."',";
        }

        if(isset($formulario['endereco'])){
            $query = $query."ender = '".strtoupper($formulario['endereco'])."',";
        }
		
		if(isset($formulario['indicacao'])){
            if (empty($formulario['indicacao'])) {
                $query = $query.'indicacao = null  ';
            } else {
                $query = $query."indicacao = '".strtoupper($formulario['indicacao'])."' ";
            }
           
        }



        $query = $query."where id = ".$idcliente."";
        echo $query;
        
         $cnx->executarQuery($query);

         if(!empty($formulario['novoadverso']) && !empty($formulario['novoramo'])){

             $this->adicionarAdverso($idcliente,$formulario['novoadverso'],$formulario['novoramo']);

            }


        /*
        $this->setNome($linha['nome']);
        $this->setTelefone($linha['telefone']);
        $this->setCelular($linha['celular']);
        $this->setEmail($linha['email']);
        $this->setEnder($linha['ender']);
        $this->setAdverso($linha['adverso']);
        $this->setCargo($linha['cargo']);
        $this->setDataIniEmpresa($linha['datainiempresa']);
        $this->setDataFinalEmpresa($linha['datafinalempresa']);
        $this->setRamo($linha['idramo']);
        $this->setIndicacao($linha['indicacao']);
        */
        header('Location:perfil_cliente.php?id='.$idcliente);
    }

        private function adicionarAdverso($idcliente, $nome, $ramo){
            
            require_once 'conexao.php';
            $cnx = new conexao();
            
            $query = 'insert into adverso (nome,id_ramo, idcolcad) values ("'.$nome.'",'.$ramo.','.$_SESSION['idcolaborador'].')';

            $cnx->executarQuery($query);

            $query = 'select max(id) as "id" from adverso where idcolcad = '.$_SESSION['idcolaborador'];

            $dados = $cnx->executarQuery($query);
            $linha = mysqli_fetch_array($dados);

            $query = "insert into processo values (".$idcliente.",".$linha['id'].")";

            $cnx->executarQuery($query);
        }

        /**
     * O método abaixo recebe uma letra e gera uma query para listar os clientes que começarem com a letra recebida
     * depois ela chama o método listarResultados e esse é quem faz a listagem.
     * 
     * Filtros de segurança podem ser chamados aqui dentro.
     * 
     * Rubens 20/02/2019
     */
    public function listagemAlfabetica($letraInicial){
        
        $query = 'select c.id as "id",c.nome as "nome", col.nome as "cadastrador", c.datacadastro as "datacadastro" 
        from cliente c inner join colaborador col on c.idcolcad = col.id where c.nome like "'.$letraInicial.'%" order by c.nome;';

         //echo $query;

         $this->listarResultados($query);


    }

    /**
     * Recebe um status e lista os clientes cujo último contato foi igual ao status recebido. Lista por ordem de data desses contatos.
     * 
     * Se recebe o status 99, ele lista os clientes que não tem contato registrado. Lista por ordem de cadastro desses clientes.
     * 
     * --Rubens
     */
    public function listagemPorStatus($status){

        if($status != 99){
            $query = 'SELECT c.id AS "id", c.nome AS "nome", col.nome AS "cadastrador", c.datacadastro AS "datacadastro" 
                        FROM ( contato cont INNER JOIN cliente c ON cont.idcliente = c.id ) INNER JOIN colaborador col ON col.id = c.idcolcad 
                        WHERE cont.status = '.$status.' 
                        AND cont.data IN( SELECT MAX(DATA) FROM contato GROUP BY idcliente ) order by cont.data asc';
        }else{
            $query = 'SELECT c.id AS "id", c.nome AS "nome", col.nome AS "cadastrador", c.datacadastro AS "datacadastro" 
            FROM cliente c INNER JOIN colaborador col ON col.id = c.idcolcad 
            WHERE c.id IN( SELECT c2.id FROM `cliente` c2 LEFT OUTER JOIN contato co2 ON c2.id = co2.idcliente WHERE co2.idcliente IS NULL ) ORDER BY c.datacadastro ASC';
        }
        
        //echo $query;

        $this->listarResultados($query);
    }

    /**
     * Lista os clientes que estão a 30 dias ou menos de prescreverem com base na data de saída da empresa fornecida no cadastro do cliente.
     * 
     * --Rubens
     */
    public function listagemPrescritos(){
        $query = "select c.id,concat((day(c.datainiempresa)),'/',(month(c.datainiempresa)),'/',(year(c.datainiempresa))) as 'datainiempresa', concat((day(c.datafinalempresa)),'/',(month(c.datafinalempresa)),'/',(year(c.datafinalempresa))) as 'datafinalempresa', c.nome, c.telefone, c.celular, c.ender, a.nome as 'nomeadverso', r.nome as 'nomeramo', c.cargo,c.indicacao,co.nome as 'cadastrador', concat((day(c.datacadastro)),'/',(month(c.datacadastro)),'/',(year(c.datacadastro))) as 'datacadastro' from ((((cliente c inner join colaborador co on c.idcolcad = co.id) inner join processo p on c.id = p.idcliente) inner join adverso a on p.idadverso = a.id) inner join ramo r on r.id = a.id_ramo) where datediff(now(),c.datafinalempresa) >=700 order by c.nome;";

        $novaQueryPrescritos = 'select c.id as "id",c.nome as "nome", col.nome as "cadastrador", c.datacadastro as "datacadastro" 
        from cliente c inner join colaborador col on c.idcolcad = col.id 
        where datediff(now(),c.datafinalempresa) >=700 order by c.nome;';

        $this->listarResultados($novaQueryPrescritos);
    }

    /**
     * Lista os clientes que tenham a data atual(hoje) indicada como data de retorno durante o registro de contato.
     * 
     * --Rubens
     */
    public function listarRetornos(){
        $query = "SELECT        c.id,        CONCAT(            (DAY(c.datainiempresa)),            '/',            (MONTH(c.datainiempresa)),            '/',            (YEAR(c.datainiempresa))        ) AS 'datainiempresa',       CONCAT(            (DAY(c.datafinalempresa)),            '/',            (MONTH(c.datafinalempresa)),            '/',            (YEAR(c.datafinalempresa))        ) AS 'datafinalempresa',        c.nome,        c.telefone,        c.celular,        c.ender,        a.nome AS 'nomeadverso',        r.nome AS 'nomeramo',        c.cargo,        c.indicacao,        co.nome AS 'cadastrador',        CONCAT(            (DAY(c.datacadastro)),            '/',            (MONTH(c.datacadastro)),            '/',            (YEAR(c.datacadastro))        ) AS 'datacadastro'    FROM        (            (                (                    (                        cliente c                    INNER JOIN colaborador co ON                        c.idcolcad = co.id                    )                INNER JOIN processo p ON                    c.id = p.idcliente                )            INNER JOIN adverso a ON                p.idadverso = a.id            )        INNER JOIN ramo r ON            r.id = a.id_ramo        )    INNER JOIN contato con ON        con.idcliente = c.id    WHERE        con.datacontato = CAST(NOW() AS DATE)    ORDER BY        c.nome;";        
        
        $novaQueryRetornos = 'select c.id as "id",c.nome as "nome", col.nome as "cadastrador", c.datacadastro as "datacadastro"         
        from (cliente c inner join colaborador col on c.idcolcad = col.id) inner join contato con on con.idcliente = c.id          
        where con.datacontato = CAST(NOW() AS DATE) order by c.nome;';
        
        $this->listarResultados($novaQueryRetornos);
    }


/**
     * Esse método só lista os resultados da query que ela receber como argumento
     * 
     * Esse método(private) só deve ser chamado de dentro de outros métodos e nunca de outra classe
     * 
     * retirei o código do método listarClientes e pretendo aposentá-lo num futuro próximo pois está ficando muito complexo de se mexer lá
     * 
     * Rubens 20/02/2019
     * 
     */
    private function listarResultados($query){

        require_once 'conexao.php';
        $cnx = new conexao();

        //aplicando o sql no link e retornando do dataset (dados)
        $dados = $cnx->executarQuery($query);

        //apontando para a 1a. linha dataset
        $linha = mysqli_fetch_array($dados);

        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);

        $cont = 0;

        //abre uma div para a tabela e abre a tag table
        echo '<div class="tabela_listagem_clientes container-tabela" style="padding:2%">
        <table cellpadding="6" cellspacing="0" border="0" class="tabela-borda" width="80%">';

        //define os nomes das colunas a serem exibidas
        echo '<tr class="tabela-categorias">
                <td><i class="fas fa-user"></i> Nome</td>';
                /*<td><i class="fas fa-phone"></i> Telefone</td>
                <td><i class="fas fa-mobile-alt"></i> Celular</td>
                <td><i class="fas fa-map-marked-alt"></i> Período</td>
                <td><i class="fas fa-angle-down"></i> Adversos</td>
                <td><i class="fas fa-angle-double-right"></i> Categoria</td>
                <td><i class="fas fa-address-card"></i> Cargo</td>
                <td><i class="fas fa-hand-point-right"></i> Indicado de</td>*/
                echo '<td><i class="fas"></i> Cadastrado Por </td>
                <td>Cadastrado em</td>
                <td><i class="fas fa-user-edit"></i> Operações Cliente</td>
            </tr>';

        // com o resultado do sql, lista as linhas dos resultados por um loop de repetição
        while ($cont < $total) {
            echo '<tr class="tabela-preenchimento">
                <td>' . $linha['nome'] . '</td>';
                /*<td>' . $linha['telefone'] . '</td>
                <td>' . $linha['celular'] . '</td>
                <td>' . $linha['datainiempresa'] . ' - ';
                
                if(is_null($linha['datafinalempresa']) || $linha['datafinalempresa'] == '0/0/0'){
                    echo 'atual';
                }else{
                    echo $linha['datafinalempresa'];
                }
            
                echo '</td>
                <td>' . $linha['nomeadverso'] . '</td>
                <td>' . utf8_encode($linha['nomeramo']) . '</td>
                <td>' . $linha['cargo'] . '</td>';

            // verifica se a indicação obtida é null
            //  se sim, imprime tracinhos kkkk
            //  senão, busca e imprime o nome do cliente que indicou
            if (!is_null($linha['indicacao'])) {
                $query = "select nome from cliente where id = " . $linha['indicacao'];
                $dados2 = $cnx->executarQuery($query);
                $linha2 = mysqli_fetch_array($dados2);
                echo '<td>' . $linha2['nome'] . '</td>';
            } else {
                echo '<td> - - - - - - - - </td>';
            }

            */
            echo'<td><strong>' . $linha['cadastrador'] . '</strong></td>    
                <td>' . date('d/m/Y H:i:s', strtotime($linha['datacadastro'])) . '</td>
                <td>
				<a href="Perfil_cliente.php?id=' . $linha['id'] . '" ><button class="btn_editar cadastro_btn">Perfil</button></a></td>
            </tr>';

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }

        echo ('</table></div>');
        //echo '<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';

    }
        
        /*SOBRE QUANDO A INTENÇÃO DO USUÁRIO ERA 
         * TROCAR O STATUS OU NÃO E SE O INPUT 
         * CHECKBOX RETORNA UMA VARIÁVEL OU NÃO:
         * 
         * tava falso(INATIVO)
         * mudou(INTENCIONALMENTE) pra true > retorna
         * deixou falso (NÃO INTENCIONALMENTE) > não retorna
         * 
         * tava true
         * deixou true (NÃO INTENCIONALMENTE) > retorna
         * mudou pra falso (INTENCIONALMENTE) > não retorna
         * 
         * ou seja,
         *  se retorna é ativo
         *  se não retorna é inativo
        */
       /* if(isset($formulario['status'])){
            $query = $query.",status = true";
        }else{
            $query = $query.",status = false";
        }*/
        
        /*SOBRE QUANDO A INTENÇÃO DO USUÁRIO ERA 
         * TROCAR O STATUS OU NÃO E SE O INPUT 
         * CHECKBOX RETORNA UMA VARIÁVEL OU NÃO:
         * 
         * tava falso(INATIVO)
         * mudou(INTENCIONALMENTE) pra true > retorna
         * deixou falso (NÃO INTENCIONALMENTE) > não retorna
         * 
         * tava true
         * deixou true (NÃO INTENCIONALMENTE) > retorna
         * mudou pra falso (INTENCIONALMENTE) > não retorna
         * 
         * ou seja,
         *  se retorna é ativo
         *  se não retorna é inativo
        */
       /* if(isset($formulario['adm'])){
            $query = $query.",adm = true";
        }else{
            $query = $query.",adm = false";
        }*/
        
        /*$query = $query." where id = ".$formulario['id'];
        
        //aplicando o sql no link usando a classe conexao
        $cnx->executarQuery($query);
        
        //unset($_POST);
        
        //echo $query;
        $this->listarClientes();
    }*/
	

    function getDatacadastro() {
        return $this->datacadastro;
    }

    function setDatacadastro($datacadastro) {
        $this->datacadastro = $datacadastro;
    }

    function getIdcolcad() {
        return $this->idcolcad;
    }

    function setIdcolcad($idcolcad) {
        $this->idcolcad = $idcolcad;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getCelular() {
        return $this->celular;
    }
    function getEmail() {
        return $this->email;
    }

    function getEnder() {
        return $this->ender;
    }

    function getAdverso() {
        return $this->adverso;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getRamo() {
        return $this->ramo;
    }

    function getIndicacao() {
        return $this->indicacao;
    }
 function getDataIniEmpresa() {
        return $this->datainiempresa;
    }
    
        function getDataFinalEmpresa() {
        return $this->datafinalempresa;
    }
    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }
    function setemail($email) {
        $this->email = $email;
    }

    function setEnder($ender) {
        $this->ender = $ender;
    }

    function setAdverso($adverso) {
        $this->adverso = $adverso;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setRamo($ramo) {
        $this->ramo = $ramo;
    }

    function setIndicacao($indicacao) {
        $this->indicacao = $indicacao;
    }
 function setDataIniEmpresa($datainiempresa) {
        $this->datainiempresa = $datainiempresa;
    }
    function setDataFinalEmpresa($datafinalempresa){
        $this->datafinalempresa = ($datafinalempresa);
    }

}
