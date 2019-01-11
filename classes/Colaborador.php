<?php

require 'conexao.php';

class Colaborador {

    private $id;
    private $nome;
    private $login;
    private $senha;
    private $status;
    
    public function listarColaboradores() {
        require_once 'conexao.php';
        $cnx = new conexao();
        
        //$_SESSION['idcolaborador'];
        $query = ('select adm from colaborador where id = '.$_SESSION['idcolaborador']);
        $dados = $cnx->executarQuery($query);
        $linha = mysqli_fetch_array($dados);
        if($linha['adm'] != true){
        $where =' where id = '. $_SESSION['idcolaborador'];}
        else{
    $where ='';}
        $query = ("select * from colaborador".$where." order by nome");

        //aplicando o sql no link e retornando do dataset (dados)
        $dados = $cnx->executarQuery($query);

        //apontando para a 1a. linha dataset
        $linha = mysqli_fetch_array($dados);

        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);

        $cont = 0;
        
        //abre uma div para a tabela e abre a tag table
        echo '<div class="tabela_listagem_clientes container-tabela">
        <table cellpadding="10" cellspacing="0" border="0" class="tabela-borda" width="100%">';
        
        //define os nomes das colunas a serem exibidas
        echo '<tr class="tabela-categorias">
                <td><i class="fas fa-user"></i> Nome</td>
                <td><i class="fas fa-door-open"></i> Login</td>
                <td><i class="fas fa-door-open"></i> Senha</td>
                <td><i class="fas fa-heart"></i> Ativo/Inativo</td>
                <td><i class="fas fa-bookmark"></i> Admin</td>
                <td><i class="fas fa-edit"></i> Salvar Alterações</td>
            </tr>';

        // com o resultado do sql, lista as linhas dos resultados por um loop de repetição
        // 
        // adicionei uma tag form dentro da tag tr para tornar cada linha da tabela um formulário para edição
        //  dos dados do colaborador.
        while ($cont < $total) {
            echo '<tr class="tabela-preenchimento">
                <form method="POST" action="listagem_colaboradores.php">
                <td><input type="text" name="nome" value="'.$linha['nome'].'"></td>
                <td><input type="text" name="login" value="'.$linha['login'].'"></td>
                <td><input type="password" name="senha" placeholder="Escreva e salve para alterar"></td>';
            
            
                if($linha['status'] == true){
                    echo '<td><input name="status" type="checkbox" checked></td>';
                }else{
                    echo '<td><input name="status" type="checkbox"></td>';
                }
                
                if($linha['adm'] == true){
                    echo '<td><input name="adm" type="checkbox" checked></td>';
                }else{
                    echo '<td><input name="adm" type="checkbox"></td>';
                }
                
                echo '<input type="hidden" name="idcol" value ='.$linha['id'].'>';
                
                echo '<td><input class="btn_editar" type="submit" value="Salvar"></td>
                 </form></tr>';

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }
        echo ('</table></div>');
    }

    public function incluirColaborador($formulario) {
        $cnx = new conexao();
        $this->setNome(strtoupper($formulario['nome']));
        $this->setLogin($formulario['login']);
        $this->setSenha($formulario['senha']);
        $query = ("insert into colaborador (nome, login, senha) values ('$this->nome','$this->login','$this->senha');");
        //echo $query;
        $cnx->executarQuery($query);
        
        header("Location: listagem_colaboradores.php");
    }

    public function atualizarColaborador($formulario) {
        $cnx = new conexao();
        
        $query = "update colaborador set ";
        
        if(isset($formulario['nome'])){
            $query = $query."nome = '".strtoupper($formulario['nome'])."'";
        }
        
        if(isset($formulario['login'])){
            $query = $query.",login = '".$formulario['login']."'";
        }
        
        if(isset($formulario['senha'])){
            if(empty(!$formulario['senha']))
            $query = $query.",senha = '".$formulario['senha']."'";
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
        if(isset($formulario['status'])){
            $query = $query.",status = true";
        }else{
            $query = $query.",status = false";
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
        if(isset($formulario['adm'])){
            $query = $query.",adm = true";
        }else{
            $query = $query.",adm = false";
        }
        
        $query = $query." where id = ".$formulario['idcol'];
        
        //aplicando o sql no link usando a classe conexao
        $cnx->executarQuery($query);
        
        //unset($_POST);
        
        //echo $query;
        $this->listarColaboradores();
    }

    public function excluir1() {
        $cnx = new conexao();

        //definindo a sql de pesquisa usando a variavel local $id
        $query = ("delete from colaborador where id=$id");

        //aplicando o sql no link e retornando do dataset (dados)
        $dados = $cnx->executarQuery($query);

        //apontando para a 1a. linha dataset
        $linha = mysqli_fetch_array($dados);

        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);
    }

    public function pesquisar1() {
        $cnx = new conexao();
        //definindo a sql de pesquisa usando a variavel local $id
        $query = ("select * from colaborador where id=" . $this->id . "");

        //aplicando o sql no link e retornando do dataset (dados)
        $dados = $cnx->executarQuery($query);

        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);

        if ($total == 1) {
            //apontando para a 1° linha do dataset
            $linha = mysqli_fetch_array($dados);
            $this->id = $linha['id'];
            $this->nome = $linha['nome'];
            $this->login = $linha['login'];
            $this->senha = $linha['senha'];
            $this->status = $linha['status'];
        }
        return $total;
    }

    public function lista1() {
        $cnx = new conexao();
        //definindo a sql de pesquisa usando a variavel local $id
        $query = ('select * from colaborador');

        //aplicando o sql no link e retornando do dataset (dados)
        $dados = $cnx->executarQuery($query);

        //apontando para a 1a. linha dataset
        $linha = mysqli_fetch_array($dados);

        //obtendo o total de registro do dataset
        $total = mysqli_num_rows($dados);

        $cont = 0;

        echo '<table border=1>';
        echo '<tr><th> Id</th><th>Nome</th><th>Login</th><th>Senha</th></th><th>Status</th>';


        while ($cont < $total) {
            echo '<tr>'
            . '<td>' . $linha['id'] . '</td>'
            . '<td>' . $linha['nome'] . '</td>'
            . '<td>' . $linha['login'] . '</td>'
            . '<td>' . $linha['senha'] . '</td>'
            . '<td>' . $linha['status'] . '</td>';

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }

        echo ('</table>');
        echo '<A HREF=index.php?opcao=0 style="color:#f00"> VOLTAR MENU PRINCIPAL</A>';
    }
    
    public function instanciar(){
    
      $query="select * from colaborador where id=".$_SESSION['idcolaborador'];
      require_once 'conexao.php';
      $cnx = new conexao();
      $dados = $cnx->executarQuery($query);
      $linha = mysqli_fetch_array($dados);
      $this->setNome($linha['nome']);
      
      
      $cnx = null;
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}

?>