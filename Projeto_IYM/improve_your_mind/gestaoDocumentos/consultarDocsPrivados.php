<?php
	ob_start();
	session_cache_expire(1);
	session_start();
	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";
	
	if(isset($_POST['keyword']))$keyword = $_POST["keyword"];
	if(isset($_POST['categoria']))$categoria = $_POST["categoria"];
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
<body onload="updateBar('titulo','Documentos Pessoais');">
		<div style="padding: 5% 0 0 8.5%;">
		<form name="consultaDocs" method="post" action="<?php global $PHP_SELF; echo $PHP_SELF;?>">
				Palavra-Chave : <input type="text" name="keyword" id="keyword"/>
				Categoria : 
				<select name="categoria">
					<option value="">Todos</option>
					<?php getCategorias(); ?>
				</select>
				<input type="submit" name="consulta" id="consulta" value="Pesquisar" /><br>	
		</form>
		</div>		
		</br>
</body>
</html>


<?php

if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
	{
	
		header("Location:Login.php");
		exit();

	}else{
			if(isset($_POST['consulta'])){
					
				$ligaBD = mysqli_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!"); 
				mysqli_select_db($ligaBD,"$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
				
				$user=$_SESSION["oid"];
				if($categoria=="")$sql="SELECT * FROM documento d where d.keywords like '%$keyword%' and d.user_oid=".$user.";";
				else $sql="SELECT * FROM documento d,categoriadoc c where d.keywords like '%".$keyword."%' and d.categoriadoc_oid=c.oid and c.oid=".$categoria." and d.user_oid=".$user.";";
				
				$result=mysqli_query($ligaBD,$sql);
				$nregistos=mysqli_num_rows($result);
					
				echo "<h2 align='center'>Resultados ($nregistos)</h2>";
				if($nregistos>0)
				echo "<table width='100%' border='0' cellspacing='20'> <tr><td></td><th align='left'>Documento</th><th align='left'>Estado</th><td></td><td></td></tr>";
				
				for($i=0;$i<$nregistos;$i++)
				{ $registo=mysqli_fetch_assoc($result);
				  $message = wordwrap($registo['titulo'], 30, "<br>", true);
				  $update="updateBar('titulo','".$registo["titulo"]."');";
					
					echo '<tr><td>'.($i+1).'.</td><td width="45%">'.$message.'</td><td>';
					
					if($registo["public"]==1)echo 'P&uacute;blico';
				    else if($registo["public"]==NULL)echo '<font color="red">Pendente de valida&ccedil&atildeo</font>';
				    else echo '<font color="blue">Privado</font>';
					
					echo '</td><td><a href="'.$registo["path_file"].'" target="conteudo" onclick="'.$update.'">Visualizar</a></td><td><a href="editar.php?iddoc='.$registo["iddoc"].'" target="conteudo">Editar</a></td><td><a href="apagar.php?iddoc='.$registo["iddoc"].'" target="conteudo">Apagar</a></td></tr>';
				
				}
				echo "</table>";
				mysqli_close($ligaBD);
			}
			else {
			
				$ligaBD = mysqli_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!"); 
				mysqli_select_db($ligaBD,"$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
				
				$user=$_SESSION["oid"];
				
				$sql="SELECT * FROM documento where user_oid=".$user.";";
				$result=mysqli_query($ligaBD,$sql);
				$nregistos=mysqli_num_rows($result);
				
				if($nregistos>0)
				echo "</br><table width='100%' border='0' cellspacing='20'> <tr><td></td><th align='left'>Documento</th><th align='left'>Estado</th><td></td><td></td></tr>";
				
				for($i=0;$i<$nregistos;$i++)
				{ $registo=mysqli_fetch_assoc($result);
				  $message = wordwrap($registo['titulo'], 30, "<br>", true);
				  $update="updateBar('titulo','".$registo["titulo"]."');";
				 
				echo '<tr><td>'.($i+1).'.</td><td width="45%">'.$message.'</td><td>';
				
				if($registo["public"]==1)echo 'P&uacute;blico';
				else if($registo["public"]==NULL)echo '<font color="red">Pendente de valida&ccedil&atildeo</font>';
				else echo '<font color="blue">Privado</font>';
				
				echo '</td><td><a href="'.$registo["path_file"].'" target="conteudo" onclick="'.$update.'">Visualizar</a></td><td><a href="editar.php?iddoc='.$registo["iddoc"].'" target="conteudo">Editar</a></td><td><a href="apagar.php?iddoc='.$registo["iddoc"].'" target="conteudo">Apagar</a></td></tr>';
				
				}
				echo "</table>";
				mysqli_close($ligaBD);
			}
	}
	
	
	
function getCategorias(){
		
		$host="localhost"; 
		$username="root"; 
		$password=""; 
		$db_name="db_engweb";  
				
		$ligaBD = mysql_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!"); 
		
		mysql_select_db("$db_name")or die("Imposs&iacutevel ligar a '$db_name'");
		
			$sql="SELECT * FROM categoriadoc";
			$result=mysql_query($sql);
			$nregistos=mysql_num_rows($result);
			
			for($i=0;$i<$nregistos;$i++)
			{ $registo=mysql_fetch_assoc($result);
			    if(isset($_POST["categoria"])&&$_POST["categoria"]==$registo['oid'])echo '<option value="'.$registo['oid'].'" selected>'.$registo['descricao']."</option>";
				else echo '<option value="'.$registo['oid'].'">'.$registo['descricao']."</option>";
			}
		
		mysql_close($ligaBD);
}

?>