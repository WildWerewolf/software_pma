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

    /**
     * recebe o id do colaborador e o status de contato para se contar os contatos do colaborador informado
     * retorna o total de contatos com o status recebido durante os últimos 5 dias(dia atual incluso)
     * não separa dia útil de dia não trabalhado. Só considera os 5 últimos dias sem diferenciá-los
     */
    private function contatosDoColaboradorSemana($id,$statusContato)
    {
        $this->instanciaCnx();

        /*
         * statusContato == 99 significa não especificar qual tipo de contato procurar, 
         * então a query vai listar todos os contatos desse colaborador no período independente do status
         */
        if(($statusContato) == 99){
            $whereStatusContato = '';
        }else{
            $whereStatusContato = ' and (c.status = '.$statusContato.')';
        }

        $query = 'SELECT count(distinct(c.obs)) as "total"
                    from contato c inner join colaborador col on col.id = c.idcolaborador 
                    where (idcolaborador = ' . $id .')'.
                    ' and datediff(cast(now() as date), cast(data as date)) < 6  and c.data < now()'.
                    $whereStatusContato.';';
          
        //echo '<br><br>'. $query. '<br><br>';

        $dados = $this->cnx->executarQuery($query);

        $linha = mysqli_fetch_array($dados);

          return $linha['total'];
    }

    /**
     * recebe o id do colaborador,o mes, o ano e o status de contato para se contar os contatos do colaborador informado.
     * Retorna o total de contatos com o status recebido durante o mes e ano especificado
     */
    private function contatosDoColaboradorPeriodo($id, $mes, $ano, $statusContato)
    {
        $this->instanciaCnx();

        /*
         * statusContato = 99 significa não especificar qual tipo de contato procurar, 
         * então a query vai listar todos os contatos desse colaborador no período independente do status
         */
        if(($statusContato) == 99){
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




    /**
     * Constroi uma tabela mostrando os colaboradores e o total de contatos feitos por ele. 
     * Considera-se o mes, o ano e o status do contato
     */
    public function resultadosDoMês($mes, $ano, $statusContato)
    {
        require_once 'Contato.php';
        $contato = new Contato();

        $dados = $this->obterColaboradores();

        $linha = mysqli_fetch_array($dados);

        $total = mysqli_num_rows($dados);

        $cont = 0;


        //montando a tabela a partir daqui
            echo ' <div class="titulo-secao">
       
             ' . $this->resolveMes($mes) .

              '/'.$ano.' - '.$contato->resolveStatus($statusContato).'</div>';

            echo '  <div class="tabela_listagem_clientes container-tabela" style="padding:2%">
        <table cellpadding="6" cellspacing="0" border="0" class="tabela-borda" width="100%">';

            echo '<tr class="tabela-categorias"> <td> <strong>Colaborador</strong> </td>
                     <td> <strong>Total</strong> </td>';

            while ($cont < $total) {

            echo '<tr><td>' . $linha['nome'] . '</td>
                <td> ' . $this->contatosDoColaboradorPeriodo($linha['id'], $mes, $ano, $statusContato) . '</tr>';

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
            }

        echo '</table>
        </div>
        </div>
       ';

    }

    /**
     * Constroi uma tabela mostrando os colaboradores e o total de feitos por ele. 
     * Considera-se o status do contato e os últimos 5 dias
     */
    public function resultadosDaSemana($semana, $statusContato){ 
        //echo $statusContato;

        require_once 'Contato.php';
        $contato = new Contato();
        
        $dados = $this->obterColaboradores();

        $linha = mysqli_fetch_array($dados);

        $total = mysqli_num_rows($dados);

        $cont = 0;

        //montando a tabela a partir daqui
        echo ' <div class="titulo-secao"> Últimos 5 dias - '.$contato->resolveStatus($statusContato).'</div>';

        echo ' <div class="tabela_listagem_clientes container-tabela" style="padding:2%">
        <table cellpadding="6" cellspacing="0" border="0" class="tabela-borda" width="100%">';

        echo '<tr  class="tabela-categorias"> <td> <strong>Colaborador</strong> </td>';
      

        if($semana == true){

           while ($cont < $total) {

            echo '<tr><td>' . $linha['nome'] . '</td>
                <td> ' . $this->contatosDoColaboradorSemana($linha['id'], $statusContato);

            $linha = mysqli_fetch_assoc($dados);
            $cont++;
            } 

            echo '</table>
        </div>
        </div>
       ';

            //echo date('z', time('2019-03-24 22:39:54'));
            
            //echo '<table><tbody><tr valign="top"><td>format character</td><td>Description</td><td>Example returned values</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>d</td><td>Day of the month, 2 digits with leading zeros</td><td>01 to 31</td></tr><tr valign="top"><td>D</td><td>A textual representation of a day, three letters</td><td>Mon through Sun</td></tr><tr valign="top"><td>j</td><td>Day of the month without leading zeros</td><td>1 to 31</td></tr><tr valign="top"><td>l (lowercase L)</td><td>A full textual representation of the day of the week</td><td>Sunday through Saturday</td></tr><tr valign="top"><td>N</td><td>ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)</td><td>1 (for Monday) through 7 (for Sunday)</td></tr><tr valign="top"><td>S</td><td>English ordinal suffix for the day of the month, 2 characters</td><td>st, nd, rd or th. Works well with j</td></tr><tr valign="top"><td>w</td><td>Numeric representation of the day of the week</td><td>0 (for Sunday) through 6 (for Saturday)</td></tr><tr valign="top"><td>z</td><td>The day of the year (starting from 0)</td><td>0 through 365</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>W</td><td>ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)</td><td>Example: 42 (the 42nd week in the year)</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>F</td><td>A full textual representation of a month, such as January or March</td><td>January through December</td></tr><tr valign="top"><td>m</td><td>Numeric representation of a month, with leading zeros</td><td>01 through 12</td></tr><tr valign="top"><td>M</td><td>A short textual representation of a month, three letters</td><td>Jan through Dec</td></tr><tr valign="top"><td>n</td><td>Numeric representation of a month, without leading zeros</td><td>1 through 12</td></tr><tr valign="top"><td>t</td><td>Number of days in the given month</td><td>28 through 31</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>L</td><td>Whether it´s a leap year</td><td>1 if it is a leap year, 0 otherwise.</td></tr><tr valign="top"><td>o</td><td>ISO-8601 year number. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead. (added in PHP 5.1.0)</td><td>Examples: 1999 or 2003</td></tr><tr valign="top"><td>Y</td><td>A full numeric representation of a year, 4 digits</td><td>Examples: 1999 or 2003</td></tr><tr valign="top"><td>y</td><td>A two digit representation of a year</td><td>Examples: 99 or 03</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>a</td><td>Lowercase Ante meridiem and Post meridiem</td><td>am or pm</td></tr><tr valign="top"><td>A</td><td>Uppercase Ante meridiem and Post meridiem</td><td>AM or PM</td></tr><tr valign="top"><td>B</td><td>Swatch Internet time</td><td>000 through 999</td></tr><tr valign="top"><td>g</td><td>12-hour format of an hour without leading zeros</td><td>1 through 12</td></tr><tr valign="top"><td>G</td><td>24-hour format of an hour without leading zeros</td><td>0 through 23</td></tr><tr valign="top"><td>h</td><td>12-hour format of an hour with leading zeros</td><td>01 through 12</td></tr><tr valign="top"><td>H</td><td>24-hour format of an hour with leading zeros</td><td>00 through 23</td></tr><tr valign="top"><td>i</td><td>Minutes with leading zeros</td><td>00 to 59</td></tr><tr valign="top"><td>s</td><td>Seconds, with leading zeros</td><td>00 through 59</td></tr><tr valign="top"><td>u</td><td>Microseconds (added in PHP 5.2.2)</td><td>Example: 654321</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>e</td><td>Timezone identifier (added in PHP 5.1.0)</td><td>Examples: UTC, GMT, Atlantic/Azores</td></tr><tr valign="top"><td>I (capital i)</td><td>Whether or not the date is in daylight saving time</td><td>1 if Daylight Saving Time, 0 otherwise.</td></tr><tr valign="top"><td>O</td><td>Difference to Greenwich time (GMT) in hours</td><td>Example: +0200</td></tr><tr valign="top"><td>P</td><td>Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3)</td><td>Example: +02:00</td></tr><tr valign="top"><td>T</td><td>Timezone abbreviation</td><td>Examples: EST, MDT ...</td></tr><tr valign="top"><td>Z</td><td>Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.</td><td>-43200 through 50400</td></tr><tr valign="top"><td>---</td><td>---</td></tr><tr valign="top"><td>c</td><td>ISO 8601 date (added in PHP 5)</td><td>2004-02-12T15:19:21+00:00</td></tr><tr valign="top"><td>r</td><td>RFC 2822 formatted date</td><td>Example: Thu, 21 Dec 2000 16:01:07 +0200</td></tr><tr valign="top"><td>U</td><td>Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</td><td>See also time</td></tr></tbody></table>';

        }else{
            /**
             * Se $semana for qualquer coisa diferente de true, é um erro. 
             * O único jeito desse método ser chamado é quando $semana estiver setada(existir) e eu a escrevi pra ser setada como true. 
             * Portanto, se ela chegar aqui diferente de true, alguém está mexendo no html da página.
             * --Rubens
             */
            header("Location: bucha.php?erro=0");
            }
            

            

        echo '</table>
        
        <div class="container-div">
            <a href="contatos_totais.php">
                <button class="cadastro_cadastrar cadastro_btn">zerar</button></a>
        </div>
        
        </div>';

    }
}

?>