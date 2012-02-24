<?php
	ob_start();
	session_cache_expire(1);
	session_start();

	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";
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
</html>

<?php
	//Ligação Base de Dados
	$ligaBD = mysql_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!"); 
	mysql_select_db("$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
	
	$sql_command = "select * from documento d,user u where d.public=true and d.user_oid=u.oid ORDER BY d.datamodificacao DESC LIMIT 0,5;";
	
	$r=mysql_query($sql_command);
	
	$nregistos=mysql_num_rows($r);
	
	for($i=0;$i<$nregistos;$i++)
			{ $registo=mysql_fetch_assoc($r);
			  $update="updateBar('titulo','".$registo["titulo"]."');";
			    if(isset($_SESSION["group"])&&$_SESSION["group"]==1){
					$message = wordwrap($registo['titulo'], 25, "<br>", true);
					echo '<br><a href="'.$registo["path_file"].'" target="conteudo" onclick="'.$update.'">'.$message.'</a>
					<br><font size="2">De: <a href="../gestaoUtilizadores/gerirUtilizadores.php?user='.$registo['oid'].'" target="conteudo">'.$registo['username'].' </a><br>Em: '.$registo['datamodificacao'].' </font>
					<br>______________________<br>';
				}
				
				else {$message = wordwrap($registo['titulo'], 25, "<br>", true);echo '<br><a href="'.$registo["path_file"].'" target="conteudo" onclick="'.$update.'">'.$message.'</a><br><font size="2">De: '.$registo['username'].' <br>Em: '.$registo['datamodificacao'].' </font><br>______________________<br>';}
			}
	//DESLIGA DA BASE DE DADOS
	mysql_close($ligaBD);
?>
