<?php

require 'Colaborador.php';

class Adm extends Colaborador{
    
    public function atualizar1 ()
	{
		
		$col = new Colaborador();
		
		$col->setId  ($_POST['id']);
		$col->setNome  ($_POST['nome']);
		$col->setLogin  ($_POST['login']);
		$col->setSenha  ($_POST['senha']);
		echo ($_POST['status']);
		
		$col->setStatus  ($_POST['status']);		
		$col->atualizar1 ();
		

	}
}
