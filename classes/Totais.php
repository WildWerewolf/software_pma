<?php
class Totais
{
    private $cnx;

    //instancia a classe conexão e da o valor para a variável global cnx
    //--Rubens
    private function instanciaCnx()
    {
        require_once "conexao.php";
        $this->cnx = new conexao();
    }


    //faz a query para obter todos os colaboradores ativos e retorna o resultado dessa query
    private function obterColaboradores()
    {
        $this->instanciaCnx();

        $query = "select id, nome from colaborador where status = 1";

        $dados = $this->cnx->executarQuery($query);

        $total = mysqli_num_rows($dados);

        if ($total != 0) {

            return $dados;

        }
    }

    //recebe o id do colaborador,o mes, o ano e o status de contato para se contar os contatos do colaborador informado
    //retorna o total de contatos com o status recebido durante o mes e ano especificado
    private function contatosDoColaborador($id, $mes, $ano, $statusContato)
    {
        $this->instanciaCnx();

        /*
         * statusContato = 16 significa não especificar qual tipo de contato procurar, 
         * então a query vai listar todos os contatos desse colaborador no período independente do status
         */
        if($statusContato == 16){
            $whereStatusContato = '';
        }else{
            $whereStatusContato = ' and (c.status = '.$statusContato.')';
        }

        $query = 'SELECT count(distinct(c.obs)) as "total"
                    from contato c inner join colaborador col on col.id = c.idcolaborador 
                      where (idcolaborador = ' . $id .')'.
            ' and (month(cast(c.data as date)) = ' . $mes .')'.
            ' and (year(cast(c.data as date)) = '. $ano .')'.
            $whereStatusContato.';';
          
        //echo $query. '<br><br>';

        $dados = $this->cnx->executarQuery($query);

        $linha = mysqli_fetch_array($dados);

          return $linha['total'];
    }

    private function contatosNaoAtendidos($id, $mes){

        $this->instanciaCnx();

        $query = 'SELECT count(c.obs) as "total"
                    from contato c inner join colaborador col on col.id = c.idcolaborador 
                    where idcolaborador = ' . $id . ' and month(cast(c.data as date)) = ' . $mes." and c.status = ";
        // ." and year(cast(c.data as date) = ".$ano
        //echo $query. '<br><br>';

        $dados = $this->cnx->executarQuery($query);

        $linha = mysqli_fetch_array($dados);

        return $linha['total'];
    }

    private function resolveMes($mes){
        switch ($mes) {
            case 1:
                return "Janeiro";
                break;
            case 2:
                return "Fevereiro";
                break;
            case 3:
                return "Março";
                break;
            case 4:
                return "Abril";
                break;
            case 5:
                return "Maio";
                break;
            case 6:
                return "Junho";
                break;
            case 7:
                return "Julho";
                break;
            case 8:
                return "Agosto";
                break;
            case 9:
                return "Setembro";
                break;
            case 10:
                return "Outubro";
                break;
            case 11:
                return "Novembro";
                break;
            case 12:
                return "Dezembro";
                break;
        }
    }

    public function listarColaboradores($mes, $ano, $statusContato)
    {
        $dados = $this->obterColaboradores();

        $linha = mysqli_fetch_array($dados);

        $total = mysqli_num_rows($dados);

        $cont = 0;


        echo '<strong> ' . $this->resolveMes($mes) . '</strong>';

        echo '<br><br><table>';

        echo '<tr> <td> <strong>Colaborador</strong> </td>';

        while ($cont < $total) {

            echo '<tr><td>' . $linha['nome'] . '</td>
                <td> ' . $this->contatosDoColaborador($linha['id'], $mes, $ano, $statusContato) . '</tr>';

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
        }

        echo '</table>';

    }
}

?>