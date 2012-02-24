<?php
	ob_start();
	session_cache_expire(1);
	session_start();
?>
<html>
<head>
	<title>IYM</title>
	<script type="text/javascript">
	<!--Este script não permite que a página principal seja visualizada dentro de uma frame -->
		if (top.location!= self.location) {
			top.location = self.location.href
		}
	</script>
	<link rel="stylesheet" href="layout.css" type="text/css">
	<LINK REL="SHORTCUT ICON" HREF="images/brain2.ico">

	<script type="text/javascript">
			
			function welcomeMessage(){
				
				var ifrm = document.getElementById('conteudo');
				ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
	            ifrm.document.open();
    	        ifrm.document.write('<div style="font-family: arial, verdana, serif;"><h1 style="padding:0% 0% 0% 10%">Bem-Vindo !</h1><br>');
    	        ifrm.document.write('<p style="padding:0% 0% 0% 10%">O "Improve Your Mind" destina-se a todos os interessados pelo conhecimento.</p>');
    	        
    	        ifrm.document.write('<p style="padding:0% 0% 0% 10%">Aqui, os utilizadores poder&atildeo </p>');

    	        ifrm.document.write('<ol style="padding:0% 0% 0% 15%">');

    	        ifrm.document.write('<li style="padding:10">Consultar Documentos P&uacuteblicos</li>');    	        
    	        ifrm.document.write('<li style="padding:10">Criar Documentos Pessoais</li>');
    	        ifrm.document.write('<li style="padding:10">Editar Documentos</li>');
    	        ifrm.document.write('<li style="padding:10">Publicar Documentos</li>');

    	        ifrm.document.write('</ol>');    	        
    	        
    	        ifrm.document.write('</div>');
    	        
        	    ifrm.document.close();
				
				}
				
				function homepage(){window.location = "index.php";}
				function cursorhand(){document.body.style.cursor = "hand";}
				function cursordefault(){document.body.style.cursor = "default";}
				
				
				updateBar=function(id,tit){
				if(tit=''){
				document.getElementById(id).innerHTML='';
				}else{
					document.getElementById(id).innerHTML='<h2>'+ tit+'</h2>';
				}
				}
	</script>
</head>
	
<body onload="welcomeMessage();">

	<!--Divisão Links-->
	<div id="links">
	<?php
	if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
	{
		echo '<p><a href="gestaoLogin/login.php" target="conteudo">Autentica&ccedil&atildeo</a></p>
		<p><a href="gestaoDocumentos/consultarDocsPubs.php" target="conteudo">Consultar Documentos</a></p>';

	}else if(isset($_SESSION["group"])&&$_SESSION["group"]==1){
	
		echo '<p><a href="gestaoDocumentos/consultarDocsPubs.php" target="conteudo">Consultar Documentos</a></p>
			  <p><a href="gestaoDocumentos/pubsPendentes.php" target="conteudo">Validar Documentos</a></p>
			  <p><a href="gestaoDocumentos/consultarDocsPrivados.php" target="conteudo">Documentos Pessoais</a></p>
			  <p><a href="gestaoDocumentos/criar.php" target="conteudo">Criar Documento</a></p>
			  <p><a href="gestaoUtilizadores/gerirUtilizadores.php" target="conteudo">Gerir Utilizadores</a></p>
			  <p align=right>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#33ff00">Admin: </font><font color="yellow">'.$_SESSION["sessionusername"].'</font>&nbsp;&nbsp; <a href="gestaoLogin/Logout.php">Sair</a></p>';
	}
	else if(isset($_SESSION["group"])&&$_SESSION["group"]==2){
	
		echo '<p><a href="gestaoDocumentos/consultarDocsPubs.php" target="conteudo">Consultar Documentos</a></p>
			  <p><a href="gestaoDocumentos/consultarDocsPrivados.php" target="conteudo">Documentos Pessoais</a></p>
			  <p><a href="gestaoDocumentos/criar.php" target="conteudo">Criar Documento</a></p>
			  <p align=right>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="yellow">'.$_SESSION["sessionusername"].'</font>&nbsp;&nbsp; <a href="gestaoLogin/Logout.php">Sair</a></p>';
	}
	else if(isset($_SESSION["group"])&&$_SESSION["group"]==3){
	
		echo '<p>O seu acesso ao site foi restringido. Por favor contacte o administrador em webmaster@improveyourmind.com.</p>
		<p align=right>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="yellow">'.$_SESSION["sessionusername"].'</font>&nbsp;&nbsp; <a href="gestaoLogin/Logout.php">Sair</a></p>';
	}
	
	else{
	
		echo '<p>Utilizador inexistente.</p>';
	}
	?>
	</div>

	<!--Divisão cabecalho-->
	<div id="heading">

		<!--Divisão cabecalho coluna esquerda-->
		<div id="heading-left"><img onMouseover="cursorhand()" onMouseout="cursordefault()" src="images/impym.png" onclick="homepage();"></div>
		
		<!--Divisão cabecalho coluna direita-->
		<div id="heading-right">
		<?php
			if(!isset($_SESSION["sessionusername"]) || !isset($_SESSION["sessionpassword"]) || !isset($_SESSION["logado"]) || ($_SESSION["logado"] != TRUE))
			{
				echo '<p><a href="gestaoLogin/RecuperarPassword.php" target="conteudo">Recuperar Dados</a></p>
			<p><a href="gestaoLogin/RegistarUtilizador.php" target="conteudo">Registar</a></p>
			<p><a href="gestaoLogin/login.php" target="conteudo">Entrar</a></p>';

			}
		?>

		</div>

	</div>

	<!--Divisão main-->
	<div id="main">
		
	<!--Divisão main CENTER COLUMN-->
		<div id="main-middle">
		<!--<h1>Website Template Layout #8</h1>-->
		<div id="titulo" name="titulo"></div>
		
		<iframe id="conteudo" name="conteudo" float="center" frameborder="no" width="100%" height="100%" scrolling="auto" ></iframe>
	</div>
	
	<!--Divisão main RIGHT COLUMN-->
	<div id="main-right">
	<div id="lastpubs" ><h2>&Uacuteltimas Publica&ccedil&otildees</h2></div>
	
	<iframe id="lastPosts" float="center"  width="243" height="500" scrolling="vertical" src="gestaoDocumentos/lastpubs.php" frameborder="no"></iframe>
	</div>
	</div>
	<!--Divisão footer-->
	<div id="footer"><address>Copyright &copy; 2012 - improveyourmind.com - All Rights Reserved</address></div>
	
</body>
</html>






