<?php
	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";  
	$tbl_name="user"; 
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Registar Utilizador</title>
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
	<script>
					function avaliar(pass1,pass2,usr,email){
						 if(usr=="")
								{alert("É necessário escolher um username.");
								return(false);}
						 else if(pass1=="")
								{alert("É necessário introduzir a password.");
								return(false);}
						 else if(pass2=="")
								{alert("É necessário confirmar a password.");
								return(false);}
						 else if(!(pass1==pass2))
								{alert("A password e a sua confirmação não estão iguais.");
								 return(false);}
						 else if(email=="")
								{alert("É necessário introduzir o seu email.");
								return(false);}
						 else    
								return(true);
					}
							
	</script>
</head>

<body onload="updateBar('titulo','Registo');">    
	<div style="padding: 5% 0 0 20%;">
	</br>
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" onsubmit="return avaliar(password.value,passwordConfirmacao.value,username.value,email.value)">
	<table align ="center" >  
			<tr>
				<td align="left">Username:</td>
				<td ><input name="username" type="text" title="username" value="" size="50" maxlength="25" /></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="left">Password:</td>
				<td><input name="password" type="password" title="password" value="" size="50" maxlength="250" /></td>
			</tr>
			 <tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="left">Confirmar Password:</td>
				<td><input name="passwordConfirmacao" type="password" title="passwordConfirmacao" value="" size="50" maxlength="250" /></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="left">E-mail:</td>
				<td><input name="email" type="email" title="email" value="" size="50" maxlength="250" /></td>
			</tr>
			 <tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td align="center"><input type="submit" name="enviar" value="Registar" width="103" height="42"  /></td>
				<td align="left" ><input type="reset" name="reset" value="Apagar" width="103" height="42" />  </td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
		</table>
	</form>
    </div>	
</body>
</html>

<?php
    if(isset($_POST["enviar"]) && !empty($_POST["password"])&& !empty($_POST["username"]) && !empty($_POST["email"]))
    {
        $pass = $_POST["password"];
        $user = $_POST["username"];
        $email = $_POST["email"];
        $ideGrupo =2;
          
        $link =  mysqli_connect($host, $username, $password)or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!");  
        mysqli_select_db($link,$db_name)or die("Imposs&iacutevel ligar a '$db_name'");
		
		$usrcheck="SELECT * FROM ".$tbl_name." WHERE username='".$user."'";
		$emailcheck="SELECT * FROM ".$tbl_name." WHERE email='".$email."'";
		
        $usrconf = mysqli_query($link,$usrcheck);
        $emailconf= mysqli_query($link,$emailcheck);   
        $usrcount = mysqli_num_rows($usrconf); 
		$emailcount= mysqli_num_rows($emailconf); 
		mysqli_close($link);
		
        if ($usrcount == 0&&$emailcount==0) 
        {
			$link =  mysqli_connect($host, $username, $password)or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!");  
			mysqli_select_db($link,$db_name)or die("Imposs&iacutevel ligar a '$db_name'");

			$user = stripslashes($user);
			$pass = stripslashes($pass);
			$user = mysql_real_escape_string($user);
			$pass = mysql_real_escape_string($pass);
			
			$sql = "INSERT INTO ".$tbl_name." (username,password,email, group_oid) VALUES ('".$user."','".$pass."','".$email."',".$ideGrupo.")";

			$query = mysqli_query($link,$sql);
			mysqli_close($link);
					
			if($query)
			{
				echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Registado com sucesso!</font></div>"; 
			}else
			{
				echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Erro ao registar!</font></div>"; 	 
			}
	    }else if($usrcount != 0){
                 echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Esse username j&aacute;  est&aacute; registado!</font></div>"; 
              }
		 else if($emailcount!=0){
                 echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Esse email j&aacute; est&aacute; registado!</font></div>"; 
              } 
    }
?>
