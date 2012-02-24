<?php
ob_start();
session_cache_expire(1);
session_start();
?>
<html>
<head>
	<title>Apagar Documento</title>
	<link rel="stylesheet" href="../layout.css" type="text/css">
	<script type="text/javascript" src="editor/nicEdit.js"></script>
	<script type="text/javascript">
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	</script>
	<script type="text/javascript">
			updateBar=function(id,tit){
				if(tit==''){
					window.parent.document.getElementById(id).innerHTML='';
				}else{
					window.parent.document.getElementById(id).innerHTML='<h2>'+ tit+'</h2>';
				}
			}
	</script>
	<?php 
			function formulario(){
					global $PHP_SELF;
					$iddoc=$_GET['iddoc'];
					 
					include("ligacao.php");
					 
					mysqli_select_db($ligax,"db_engweb");
					 
					$res=mysqli_query($ligax,"select * from categoriadoc");
					$doc=mysqli_query($ligax,"select * from documento where iddoc='".$iddoc."'");
					$registoDoc=mysqli_fetch_assoc($doc);
					
					$nregistos=mysqli_num_rows($res);
					
					echo '<div align="center"><form action="'.$PHP_SELF.'" method="post">';
					echo "</br><input type='hidden' name='iddoc'  maxlength=20  value=".$iddoc." /></br>";
					
					if($registoDoc['public']==1) echo 'O documento é P&uacute;blico, de certeza que o quer apagar?';
					else echo 'Quer mesmo apagar o documento?';
					echo"</br></br><div align='center'><input type='submit' name='sim' style='width: 10%;height: 10%;' value='Sim'/>";
					echo"&nbsp;&nbsp;<input type='submit' name='nao' style='width: 10%;height: 10%;' value='Não'/></div>";
					echo "</form></div>";
					mysqli_close($ligax);
					}
	?>
</head>

<body onload="updateBar('titulo','Apagar Documento');">

	<div id="menu"></div>
	<br/></br>
	<div>
		<?php
		if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
		{
			header("Location:Login.php");
			exit();
		}else{
				if(isset($_POST['sim'])&&isset($_POST['iddoc'])){
											$iddoc=$_POST['iddoc'];
											$user=$_SESSION["oid"];
											$ligacao=mysqli_connect('localhost','root','');
											if($ligacao){
														mysqli_select_db($ligacao,'db_engweb');
														$eliminar='delete from documento where iddoc='.$iddoc;
														 $conf=mysqli_query($ligacao,$eliminar);
														 if($conf){	
																echo "<div align='center'>Documento Apagado.</div>";
														}
														else echo "<p>Erro com a base de dados.<br>";
											}
											else echo "<p>Erro:Falha no acesso &agrave;  base de dados.<br>";
											mysqli_close($ligacao);
											header('Refresh: 1;consultarDocsPrivados.php');
				}
				else if(isset($_POST['nao'])){echo "<div align='center'>Documento Não Apagado.</div>";header('Refresh: 1;consultarDocsPrivados.php');}
				else formulario();
		}
		?>
	</div>
	<div style="clear: both;"></div>
	</div>
</body>
</html>