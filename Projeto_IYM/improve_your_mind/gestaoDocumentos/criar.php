<?php
ob_start();
session_cache_expire(1);
session_start();
?>
<html>

<head>
	<title>Criar Documento</title>
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
							{alert("� necess�rio preencher o t�tulo.");
							 return(false);}
					 else if(id=="")
							{alert("� necess�rio seleccionar uma categoria.");
							return(false);}
					 else if(chaves=="")
							{alert("� necess�rio fornecer pelo menos uma palavra-chave.");
							return(false);}
					 else    
							return(true);
				}			
	</script>
		
	<?php 
			function formulario(){
					global $PHP_SELF;
					 
					include("ligacao.php");
					 
					mysqli_select_db($ligax,"db_engweb");
					 
					$res=mysqli_query($ligax,"select * from categoriadoc");
					$nregistos=mysqli_num_rows($res);
					
					echo '<form action="'.$PHP_SELF.'" method="post" onsubmit="return avaliar(titulo.value,idcategoria.value,myArea2,chaves.value)">';
					echo"<div align='right'><input type='submit' style='width: 50%;height: 10%;font-size: larger;' value='Submeter'/></div>";
					echo "</br>T�tulo:<br>";
					echo "<input type='text' name='titulo' size=50 maxlength=250  style='width: 100%;'/><br><br>";
					echo "Categoria: ";
				    echo'<select name="idcategoria">';
						 for($i=0;$i<$nregistos;$i++)
							 {  $registo=mysqli_fetch_assoc($res);
								echo '<option value="'.$registo['oid'].'">'.$registo['descricao']."</option>";
							 }
					echo"</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					if(isset($_SESSION["group"])&&$_SESSION["group"]==1) echo "Nova Categoria: <input type='text' name='novacategoria' size=30 maxlength=25'/>";
					echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo '<input type="checkbox" name="public" value="1">&nbsp;Publicar<br><br/>';
					
					
					echo "Palavras Chave:<br>";
					echo "<input type='text' name='chaves' size=50 maxlength=250 style='width: 100%;'/><br/><br/>";
					echo "<textarea style='width: 100%; height: 100%;' name='myArea2' id='myArea2' readonly='readonly' ></textarea><br />";
					echo "</form>";
					mysqli_close($ligax);
					}
	?>
</head>
<body onload="updateBar('titulo','Criar Documento');">
	<div id="menu"></div>
	<br/>
	<div>
	</br></br>
	<?php
		if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
		{
			header("Location:Login.php");
			exit();
		}else{
				if(isset($_POST['myArea2'])&&isset($_POST['titulo'])&&isset($_POST['idcategoria'])&&isset($_POST['chaves'])){
				
											$user=$_SESSION["oid"];
											$keywords=$_POST['chaves'];
											$texto=$_POST['myArea2'];
											$titulo=$_POST['titulo'];
											$oid=$_POST['idcategoria'];
											$now=new DateTime;
											$mysqldate = $now->format("Y-m-d H:i:s");
											 
											$ligacao=mysqli_connect('localhost','root','');
											if($ligacao){
														 mysqli_select_db($ligacao,'db_engweb');
														
														 $res=mysqli_query($ligacao,"select MAX(iddoc)+1 as doc from documento");
														 $iddoc=mysqli_fetch_assoc($res);
														
														 $fileName = "documentos/DOC".$iddoc['doc']."_USER".$user.".html";
														 $fileHandle = fopen($fileName, 'w') or die("can't open file");
														 fwrite($fileHandle, $texto);
														 fclose($fileHandle);
														  
														 if(isset($_POST['public'])&&$_SESSION["group"]==1){
																  if(isset($_POST['novacategoria'])){
																	  $inserircat='insert into categoriadoc (descricao) values("'.$_POST["novacategoria"].'")';
																	  $conf1=mysqli_query($ligacao,$inserircat);
																	  if($conf1){	
																		  $getcat='select oid from categoriadoc where descricao="'.$_POST["novacategoria"].'"';
																		  $resoid=mysqli_query($ligacao,$getcat);
																		  $newoid=mysqli_fetch_assoc($resoid);
																		  $oid=$newoid['oid'];
																	  }
																  }
														         $inserir='insert into documento (titulo,path_file,datacriacao,datamodificacao,keywords,public,categoriadoc_oid,user_oid) values ("'.$titulo.'","'.$fileName.'","'.$mysqldate.'","'.$mysqldate.'","'.$keywords.'",1,'.$oid.','.$user.')';
														 }else if(isset($_POST['public']))
														  $inserir='insert into documento (titulo,path_file,datacriacao,datamodificacao,keywords,public,categoriadoc_oid,user_oid) values ("'.$titulo.'","'.$fileName.'","'.$mysqldate.'","'.$mysqldate.'","'.$keywords.'",NULL,'.$oid.','.$user.')';
														 else $inserir='insert into documento (titulo,path_file,datacriacao,datamodificacao,keywords,public,categoriadoc_oid,user_oid) values ("'.$titulo.'","'.$fileName.'","'.$mysqldate.'","'.$mysqldate.'","'.$keywords.'",0,'.$oid.','.$user.')';
														  
														 $conf=mysqli_query($ligacao,$inserir);
														 if($conf){	
																echo "<div align='center'>Documento Guardado.</div>";
														}
														else echo "<p>Erro com a base de dados.<br>";
												}
											else echo "<p>Erro:falha no acesso &agrave; base de dados.<br>";
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