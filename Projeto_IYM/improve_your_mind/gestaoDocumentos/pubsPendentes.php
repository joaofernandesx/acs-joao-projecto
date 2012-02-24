<?php
	$host="localhost"; 
	$username="root"; 
	$password=""; 
	$db_name="db_engweb";
	if(isset($_POST['form_iddoc']))$iddoc = $_POST['form_iddoc'];
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
<body onload="updateBar('titulo','Validar Documentos');">
</body>
</html>

<?php
	global $PHP_SELF;

	//Ligação Base de Dados
	$ligaBD = mysqli_connect("$host", "$username", "$password")or die("Imposs&iacutevel estabelecer liga&ccedil&atildeo!"); 
	mysqli_select_db($ligaBD,"$db_name") or die("Imposs&iacutevel ligar a '$db_name'");
	
	//Codigo para validacao
	if(isset($_POST['btn_validar'])){
		
		$sql_command = "update documento set public=true where iddoc=".$iddoc;		
		
		$r=mysqli_query($ligaBD,$sql_command);
		
		if(!$r){echo "Erro ao Validar Documento !";}	
		
		}
		
	if(isset($_POST['btn_recusar'])){
		
		$sql_command = "update documento set public=false where iddoc=".$iddoc;		
		
		$r=mysqli_query($ligaBD,$sql_command);
		
		if(!$r){echo "Erro ao Validar Documento !";}	
		
		}
	
	$sql_command = "select * from documento where public is null;";
	
	$r=mysqli_query($ligaBD,$sql_command);
	
	$nregistos=mysqli_num_rows($r);
	
	
	echo "<br><br><h2 align='center'>Documentos Pendentes (".$nregistos.")</h2><br><br>";
	
	if($nregistos>0)
		echo "<table width='100%' border='0' cellspacing='20' <tr><th align='left'>Documento</th><th align='left'>Data de Cria&ccedil&atildeo</th><th align='left'>Data de Modifica&ccedil&atildeo</th><th colspan=2 >Validar</th></tr>";
	
	for($i=0;$i<$nregistos;$i++)
			{ $registo=mysqli_fetch_assoc($r);
			  $update="updateBar('titulo','".$registo["titulo"]."');";
			
	//ALTERAR CAMINHO PARA VISUALIZAR DOCUMENTO (HREF)
				echo '<tr><td width="30%"><a href="'.$registo["path_file"].'" target="conteudo" onclick="'.$update.'">'.$registo['titulo'].'</a></td><td>'.$registo['datacriacao'].'</td><td>'.$registo['datamodificacao'].'</td><td><form method="post" action="'.$PHP_SELF.'"><input type="hidden" name="form_iddoc" value="'.$registo['iddoc'].'"></input><input type="submit" name="btn_validar" value="&nbsp;Aceitar&nbsp;"></input><td><input type="submit" name="btn_recusar" value="Recusar"></input></td></form></td></tr>';
			}
	
	echo "</table>";
	
	//DESLIGA DA BASE DE DADOS
	mysqli_close($ligaBD);
?>