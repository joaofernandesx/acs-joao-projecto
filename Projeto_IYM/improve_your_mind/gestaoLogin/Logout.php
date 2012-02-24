<?php 
	ob_start();
	//INICIALIZA A SESSÃO 
	session_start();
	//DESTRÓI AS SESSOES
	unset($_SESSION["sessionusername"]); 
	unset($_SESSION["sessionpassword"]);
	unset($_SESSION["oid"]);
	unset($_SESSION["group"]);
	session_destroy(); 
	//REDIRECIONA PARA O LOGIN 
	Header("Location: ../index.php"); 
?>