<?php	
	session_start();
	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";
	$tbl_name="user"; 
	if(isset($_POST["keyword"]))$keyword = $_POST["keyword"];
	if(isset($_POST["campoUser"]))$categoria = $_POST["campoUser"];
?>

<html>
<head>	
	<link rel="stylesheet" href="../layout.css" type="text/css">
	<script type="text/javascript">
		updateBar=function(id,tit){
			if(tit==''){
				window.parent.document.getElementById(id).innerHTML='';
			}else{
				window.parent.document.getElementById(id).innerHTML='<h2>'+ tit+'</h2>';
			}
		}
	</script>
</head>
	
<body onload="updateBar('titulo','Gest&atilde;o de Utilizadores');">
		<div style="padding: 5% 0 0 8.5%;">
		<form name="consultaDocs" method="post" action="<?php global $PHP_SELF; echo $PHP_SELF;?>">			
				Palavra-Chave : <input type="text" name="keyword" id="keyword"/>
				Pesquisar por : 
				<select name="campoUser">
					<option>username</option>
					<option>email</option>
					<option>oid</option>
				</select>
				<input type="submit" name="consulta" id="consulta" value="Pesquisar" /><br>
			
		
		</form>
		</div>
</body>
</html>

<?php
	global $PHP_SELF;
	
	//LIGA À BASE DE DADOS
	$ligaBD = mysql_connect("$host", "$username", "$password")or die("Imposs&iacute;vel estabelecer liga&ccedil;&atilde;o!"); 
		
	mysql_select_db("$db_name")or die("Imposs&iacute;vel ligar a '$db_name'");
	
	if(isset($_POST['consulta'])){			
		//PESQUISAR OS UTILIZADORES QUANDO O BOTAO "PESQUISAR" É ACIONADO
			$sql="SELECT * FROM user where $categoria like '%$keyword%' ;";
			
			$result=mysql_query($sql);
			$nregistos=mysql_num_rows($result);
			
			echo '<div style="padding: 5% 0 0 20%;">';
			echo "<h2>Resultados ($nregistos)</h2><br>";
			
			for($i=0;$i<$nregistos;$i++)
			{ $registo=mysql_fetch_assoc($result);
				echo '<br><p>'.($i+1).'.&nbsp;&nbsp;<a href="'.$PHP_SELF.'?user='.$registo['oid'].'" target="conteudo">'.$registo['username'].'</a></p>';
				//echo '<br><p>'.($i+1).'.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$registo['username'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$PHP_SELF.'?user='.$registo['oid'].'" target="conteudo">Visualizar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a name=remUser href="'.$PHP_SELF.'" target="conteudo">Remover</a></p>';
			}
			echo '</div>';
	}
	
	else if(isset($_GET['user'])){
		//APRESENTA OS DADOS DO UTILIZADOR QUANDO A LABEL "VISUALIZAR" É ACIONADA
		$user = $_GET['user'];
		echo "<br><div id='titulo2' name='titulo2'><h2>Informa&ccedil;&atilde;o do Utilizador</h2></div>";
				
			$sql="SELECT u.oid,u.username,u.email,g.groupname FROM user u,db_engweb.group g where u.oid=$user and u.group_oid=g.oid;";
			
			$result=mysql_query($sql);
			$nregistos=mysql_num_rows($result);
			$registo=mysql_fetch_assoc($result);
		echo '<div style="padding: 5% 0 0 20%;">';
		echo '<br><h3>OID :</h3> 		' .$registo['oid'];
		echo '<br><br><h3>USERNAME :</h3>	' .$registo['username'];
		echo '<br><br><h3>EMAIL :</h3> 		' .$registo['email'];		
		echo '<br><br><h3>GRUPO :</h3> 		' .$registo['groupname'];		

		echo '<br><br><br><a href="'.$_SERVER['PHP_SELF'].'?editUser='.$user.'">Editar Utilizador</a> | ';
		if(isset($_GET['cons']))echo '<a href="../gestaoDocumentos/consultarDocsPubs.php">Voltar</a>';
		else echo '<a href="'.$_SERVER['PHP_SELF'].'">Voltar</a>';
		echo '</div>';
	}
	else if(isset($_GET['editUser'])){
							if (isset($_POST['guardarUser'])){
							
							//GUARDA OS DADOS DO UTILIZADOR QUANDO O BOTAO "GUARDAR UTILIZADOR" É ACIONADO
								
								$_oid_ = $_POST['txt_oid'];
								$_username_ = $_POST['txt_username'];
								$_email_ = $_POST['txt_email'];
								$_groupname_ = $_POST['txt_groupname'];
								
								$link =  mysqli_connect($host, $username, $password)or die("Imposs&iacute;vel estabelecer liga&ccedil;&atilde;o!");  
								mysqli_select_db($link,$db_name)or die("Imposs&iacute;vel ligar a '$db_name'");
								$usrcheck="SELECT * FROM ".$tbl_name." WHERE username='".$_username_."' AND oid!=".$_oid_;
								$emailcheck="SELECT * FROM ".$tbl_name." WHERE email='".$_email_."' AND oid!=".$_oid_;
								
								$usrconf = mysqli_query($link,$usrcheck);
								$emailconf= mysqli_query($link,$emailcheck);   
								$usrcount = mysqli_num_rows($usrconf); 
								$emailcount= mysqli_num_rows($emailconf); 
								mysqli_close($link);
								
								if ($usrcount == 0&&$emailcount==0) 
								{
									$sql="update user set username='$_username_',email='$_email_',group_oid='$_groupname_' where oid='$_oid_';";
									$r = mysql_query($sql);
									
									if($r){
										echo("</br><div align='center'>Dados guardados com sucesso !</div>");}
									else{
										echo("Erro ao guadar dados !");
									}
								}else if($usrcount != 0){
										 echo "<div align=center></br>Esse username j&aacute; est&aacute; registado para outro utilizador!</div>"; 
								}else if($emailcount!=0){
										 echo "<div align=center></br>Esse email j&aacute; est&aacute; registado para outro utilizador!</div>"; 
								} 
							}
							
								//APRESENTA FORMULARIO PARA EDICAO DO UTILIZADOR
								
								$editUser = $_GET['editUser'];
								
									$sql="SELECT u.oid,u.username,u.email,g.groupname FROM user u,db_engweb.group g where u.oid=$editUser and u.group_oid=g.oid;";
									
									$result=mysql_query($sql);
									$nregistos=mysql_num_rows($result);
									$registo=mysql_fetch_assoc($result);
								echo "<br><div id='titulo2' name='titulo2'><h2>Informa&ccedil;&atilde;o do Utilizador</h2></div>";
								echo '<div style="padding: 5% 0 0 20%;">';
								echo '<form method="post" action="'.$PHP_SELF.'">';
								
								echo '<br><h3>OID :</h3> 		<input size=5 type="text" readonly="readonly" name="txt_oid" value="' .$registo['oid'].'"></input>';
								echo '<br><br><h3>USERNAME :</h3>	<input size=25 type="text" name="txt_username" value="' .$registo['username'].'"></input>';
								echo '<br><br><h3>EMAIL :</h3> 		<input size=50 type="text" name="txt_email" value="' .$registo['email'].'"></input>';
								echo '<br><br><h3>GRUPO :</h3> 		<select name="txt_groupname" >';				
								getGrupos($registo['groupname']);
								echo '</select>';
								echo '<br><br><input type="submit" value="Guardar Actualiza&ccedil;&atilde;o" name="guardarUser" />';
								echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$_SERVER['PHP_SELF'].'">Cancelar</a>';
								echo '</form>';			
								echo '</div>';
		}			
		
		
	//FUNCAO PARA BUSCAR TODOS OS TIPOS DE UTILIZADOR EXISTENTES
	function getGrupos($preselected){
				
			$sql="SELECT * FROM db_engweb.group";
			
			$result=mysql_query($sql);
			$nregistos=mysql_num_rows($result);
			
			for($i=0;$i<$nregistos;$i++)
			{ $registo=mysql_fetch_assoc($result);
				if ($preselected==$registo['groupname'])
					echo '<option  value="'.$registo['oid'].'" SELECTED>'.$registo['groupname']."</option>";
				else
					echo '<option value="'.$registo['oid'].'">'.$registo['groupname']."</option>";
			}
		

	}
	//DESLIGA DA BASE DE DADOS
	mysql_close($ligaBD);
	
?>