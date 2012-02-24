<?php
	ob_start();
	//INICIA A SESSÃO COM UM TEMPO DE EXPIRAÇÃO DE 10 MINUTOS
	session_cache_expire(1);
	session_start(); // começa a session
	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";  
	$tbl_name="user";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Login</title>
	<link href="../layout.css" rel="stylesheet" type="text/css" />
	
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

<body onload="updateBar('titulo','Login');">
	</br></br>
	<div style="padding: 5% 0 0 30%;">
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<table align ="center">     

			<tr>
				<td align="center">Username:</td>
				<td><input  name="username" type="text" class="form-login" value="" size="30" maxlength="250" /></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="center">Password:</td>
				<td><input name="password" type="password" class="form-login"  value="" size="30" maxlength="250" /></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="left" ><a href="RegistarUtilizador.php" >Registar</a></td>
				<td align ="right"> <a href="RecuperarPassword.php" >Esqueci-me da password</a></td>
			</tr>
			 <tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			 <tr>
				<td align ="right">  <input type="submit" name="submit" value="Entrar" width="103" height="42" /></td>
				<td align="left" ><input type="reset" name="reset" value="Apagar" width="103" height="42" /></td>
			</tr>
		</table>
	</form>
	</div>
</body>
</html>
<?php
		if(isset($_POST["submit"]) && !empty($_POST["username"]) && !empty($_POST["password"]))
		{
         
			$user = $_POST["username"];
			$pass = $_POST["password"];
			$link =  mysql_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!");  
			mysql_select_db("$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
        
			$user = stripslashes($user);
			$pass = stripslashes($pass);
			$user = mysql_real_escape_string($user);
			$pass = mysql_real_escape_string($pass);
	
			$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";
			$result=mysql_query($sql,$link);
			
			$count=mysql_num_rows($result);
			if($count)
			{
				echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Dados v&aacute;lidos! Bem - Vindo " + $user + "!</font></div>"; 
				ob_start();
				//INICIA A SESSÃO COM UM TEMPO DE EXPIRAÇÃO DE 10 MINUTOS
				session_cache_expire(1);
				session_start(); // começa a session
				header("Cache-control: private");
				$_SESSION["sessionusername"] = $user;
				$_SESSION["sessionpassword"] = $pass;
				$_SESSION["logado"] = TRUE; 
				$registoUser=mysql_fetch_assoc($result);
				$_SESSION["oid"]=$registoUser['oid'];
				$_SESSION["group"]=$registoUser['group_oid'];
				mysql_close($link);
		
			header('location: ../index.php');
			}else
			{	mysql_close($link);
				echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Dados inv&aacute;lidos!</font></div>"; 
			}
		}
?>
