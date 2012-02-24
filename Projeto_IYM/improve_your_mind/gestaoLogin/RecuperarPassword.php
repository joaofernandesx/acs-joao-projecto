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
	<title>Recuperar Password</title>
	<link href="login-box.css" rel="stylesheet" type="text/css" />
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

<body onload="updateBar('titulo','Recupera&ccedil&atildeo de password');">
  <div style="padding: 40px 0 0 10px;">
	</br>
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<table align ="center">
		   <tr>
				<td align="right">E-mail:</td>
				<td><input name="email" type="email" title="exemplo@hotmail.com" value="" size="50" maxlength="250" /></td>
			</tr>
			<tr>
				<td><br/></td>
				<td><br/></td>
			</tr>
			<tr>
				<td><br/></td>
				<td align="center"><input type="submit" name="enviar" value="Enviar para o e-mail" width="103" height="42"  /></td>
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
<?
       if(!empty($_POST["email"]))
       {
           
            $email = $_POST["email"];
            
            $link =  mysql_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!");  
            mysql_select_db("$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
            $sql = "SELECT * FROM $tbl_name WHERE email = '$email'";
            $confirmacao = mysql_query($sql,$link);
             
            while ($row = mysql_fetch_array($confirmacao,MYSQL_BOTH)) {
                    $identificacao = $row['oid']; 
                    $nomeUtilizador = $row['username']; 
                    $senha = $row['password'];
            }
            
           
            $contagem = mysql_num_rows($confirmacao); 
            mysql_close($link);

            if ($contagem == 1) 
            {
            $msg  = "Recuperação de password" . chr(13) . chr(10);
            $msg .= "Senha enviada em " . date("d/m/Y") . ", os dados seguem abaixo: " . chr(13) . chr(10) . chr(10);
            $msg .= "Número de identificação: " . $identificacao. chr(13) . chr(10);
            $msg .= "Nome de Utilizador: " . $nomeUtilizador . chr(13) . chr(10);
            $msg .= "Senha : " . $senha . chr(13) . chr(10);
            

            $Remetente = "luisalerta@hotmail.com";
            mail($email, "Recuperação de Dados",$msg,"From: $Remetente\n"); 
         
            echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seus dados foram enviados com sucesso para o email: $email.</font></div>"; 
            }else{
                    echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Email inv&aacutelido.</font></div>"; 
                 }
         }
?>