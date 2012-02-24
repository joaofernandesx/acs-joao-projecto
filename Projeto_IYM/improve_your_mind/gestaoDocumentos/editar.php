<?php
ob_start();
session_cache_expire(1);
session_start();
?>
<html>
<head>
	<title>Editar Documento</title>
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
	<script>
				function avaliar(titulo,id,texto,chaves){
					 if(titulo=="")
							{alert("É necessário preencher o título.");
							 return(false);}
					 else if(id=="")
							{alert("É necessário seleccionar uma categoria.");
							return(false);}
					 else if(chaves=="")
							{alert("É necessário fornecer pelo menos uma palavra-chave.");
							return(false);}
					 else    
							return(true);
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
					
					echo '<form action="'.$PHP_SELF.'" method="post" onsubmit="return avaliar(titulo.value,idcategoria.value,myArea2,chaves.value)">';
					echo"<div align='right'><input type='submit' style='width: 50%;height: 10%;font-size: larger;' value='Submeter'/></div>";
					echo "</br>Título: <input type='hidden' name='iddoc'  maxlength=20  value=".$iddoc." /><br>";
					echo "<input type='text' name='titulo' size=50 maxlength=250  style='width: 100%;'  value='".$registoDoc['titulo']."' /><br><br>";
					echo "Categoria: ";
				    echo'<select name="idcategoria">';
						 for($i=0;$i<$nregistos;$i++)
							 {  $registo=mysqli_fetch_assoc($res);
							    if($registoDoc['categoriadoc_oid']==$registo['oid']) echo '<option value="'.$registo['oid'].'" selected>'.$registo['descricao']."</option>";
								else echo '<option value="'.$registo['oid'].'">'.$registo['descricao']."</option>";
							 }
					echo"</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if($registoDoc['public']==1||$registoDoc['public']==NULL) echo '<input type="checkbox" name="privado" value="1">&nbsp;Tornar privado<br><br/>';
					else echo '<input type="checkbox" name="public" value="1">&nbsp;Publicar<br><br/>';
					echo "Palavras Chave:<br>";
					echo "<input type='text' name='chaves' size=50 maxlength=250 style='width: 100%;' value='".$registoDoc['keywords']."' /><br/><br/>";
					
					$documento= file_get_contents($registoDoc['path_file']);
					
					echo "<textarea style='width: 100%; height: 100%;' name='myArea2' id='myArea2' readonly='readonly' >".$documento."</textarea><br />";
					echo "</form>";
					mysqli_close($ligax);
					}
	?>
</head>

<body onload="updateBar('titulo','Editar Documento');">

	<div id="menu"></div>
	<br/></br>
	<div>
		<?php
		if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
		{
			header("Location:Login.php");
			exit();
		}else{
				if(isset($_POST['myArea2'])&&isset($_POST['titulo'])&&isset($_POST['idcategoria'])&&isset($_POST['chaves'])){
				
											
											$keywords=$_POST['chaves'];
											$texto=$_POST['myArea2'];
											$titulo=$_POST['titulo'];
											$oid=$_POST['idcategoria'];
											$iddoc=$_POST['iddoc'];
											$user=$_SESSION["oid"];
											 
											$now=new DateTime;
											$mysqldate = $now->format("Y-m-d H:i:s");
											 
											$ligacao=mysqli_connect('localhost','root','');
											if($ligacao){
											
														mysqli_select_db($ligacao,'db_engweb');
														
														 $fileName = "documentos/DOC".$iddoc."_USER".$user.".html";
														 $fileHandle = fopen($fileName, 'w') or die("can't open file");
														 fwrite($fileHandle, $texto);
														 fclose($fileHandle);
														 
														 if($_SESSION["group"]==1){
																if(isset($_POST['public']))
																	  $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'" ,datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", public=1, categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
																 else if(isset($_POST['privado']))
																	  $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'",datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", public=0, categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
																 else $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'" ,datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
														 }else{
																 if(isset($_POST['public']))
																	  $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'" ,datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", public=NULL, categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
																 else if(isset($_POST['privado']))
																	  $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'",datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", public=0, categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
																 else $actualizar='UPDATE documento SET titulo="'.$titulo.'", path_file="'.$fileName.'" ,datamodificacao="'.$mysqldate.'", keywords="'.$keywords.'", public=NULL, categoriadoc_oid='.$oid.' WHERE user_oid='.$user.' AND iddoc='.$iddoc;
														}
														 $conf=mysqli_query($ligacao,$actualizar);
														 if($conf){	
																echo "<div align='center'>Documento Actualizado.</div>";
														}
														else echo "<p>Erro com a base de dados.<br>";
												}
											else echo "<p>Erro:Falha no acesso &agrave;  base de dados.<br>";
											
											
											header('Refresh: 1;consultarDocsPrivados.php');
											mysqli_close($ligacao);
				}
				else formulario();
		}
		?>
	</div>
	<div style="clear: both;"></div>
	</div>
</body>
</html>