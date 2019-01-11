<?php
class conexao {

    //faz a conexão e retorna o link para a mesma
    public function conectar() {
        $host = "127.0.0.1"; //Servidor (pode ser ip ou dominio)
        $db = "pma";   // nome do banco de dados	
        $user = "root";   // usuario para acesso ao banco
        $pass = "";    // senha de acesso para o usuário
        $porta = "3306"; // porta geralmente usada pelo mysql

        $con = NULL;  //contem o link da conexao
        $dados = NULL;   //dataset - conjunto de dados apos aplicação
        $linha = NULL;  // uma linha (registro) do conjunto de dados acima
        $total = 1;   //total de registros do dataset

        //estabelecendo a conexao ao banco de dados
        $teste = mysqli_connect($host, $user, $pass, $db, $porta) or die("Problemas na Conexao");
        return $teste;
    }
    
    // retorna o resultado da query se ela estiver der certo
    // retorna falso se não estiver certa
    public function executarQuery($query) {
        
        return mysqli_query($this->conectar(), $query);
        
    }
    
    public function checarLogin($dadosform) {
        $this->conectar();
        $query = 'select c.id,adm,datalimite from colaborador c,controle where login ="'.$dadosform['login'].'" and senha = "'.$dadosform['senha'].'" and datediff(datalimite,now()) > 0 and status = true;';
        //echo $query;
        $dados = $this->executarQuery($query);
        
        if(mysqli_num_rows($dados) != 1){
            return false;
        }else{
            $linha = mysqli_fetch_array($dados);
            $_SESSION['admin']=$linha['adm'];
            return $linha['id'];
        }
    }

}
