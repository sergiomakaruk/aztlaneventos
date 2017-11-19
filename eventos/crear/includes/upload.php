
<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Eventos</title>
<link rel="icon" type="../../image/png" href="favicon.png">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

<link href="../site/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../site/bootstrap/css/bootstrap-switch.min.css" rel="stylesheet">
<!-- The main CSS file -->
<link href="mini-upload-form/assets/css/style.css" rel="stylesheet" />

<link rel="stylesheet/less" type="text/css" href="../site/less/estilos.less" />
<script src="../site/less/less-1.4.1.min.js"></script>

<script src="js/jquery-1.10.2.min.js"></script>


<script src="mini-upload-form/assets/js/jquery.knob.js"></script>

<?php echo '<script>var idEvento='.$evento->idEvento.';</script>'?>
<!-- jQuery File Upload Dependencies -->
<script src="mini-upload-form/assets/js/jquery.ui.widget.js"></script>
<script src="mini-upload-form/assets/js/jquery.iframe-transport.js"></script>
<script src="mini-upload-form/assets/js/jquery.fileupload.js"></script>
		
<!-- Our main JS file -->
<script src="mini-upload-form/assets/js/script.js"></script>



<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if IE ]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<link href="http://aztlan.com.ar/site/css/ie.css" rel="stylesheet">
			<![endif]-->
			
<style type="text/css">
  .btn,.btn:visited{margin-top:20px;color:white;};
  
  </style>			

</head>
	<body>	
	
	<nav class="header-nav" style="margin-bottom:30px;">
<div class="header container">
    <div class="row">
    
    	<div class="logo col-xs-2 col-sm-3 col-md-4 hidden-xs ">
    		<img src="../images/logo.png"  class="pull-left">
    		<div  class="pull-left hidden-sm">
    			<h1 class="h1Header">Aztlan</h1>
    			<h4 class="h4Header">Director León Azulay</h4>
    		</div>    		
    	</div>    	
     	
    	<div class="slogan col-xs-8 col-sm-8 col-md-6">
    		<h1 class="h1Header">Escuela de Filosofía y Psicología</h1>
    		<h4 class="h4Header"><strong>Enseñanza Privada Nivel Terciario - No oficial</strong></h4>
    		<p class="pHeader hidden-xs">Personería Jurídica Nº I.G.J. 748</p>
    		<p class="pHeader hidden-xs">Centro Nacional de Organizaciones de la Comunidad C.E.N.O.C. Nº 16528</p>
    	</div>
    	<div  class="slogan col-xs-2 col-sm-2 col-md-2">
    	<a href="http://aztlan.com.ar/eventos" ><span style="font-size:50px;" class="glyphicon glyphicon-home"></span></a>
    	</div>
    </div>
</div>  
 </nav>
	
	<div class="container">
	<?php if(isset($_GET['success']) && $_GET['success']==1){
	if(isset($_GET['changed'])) $palabra = "MODIFICADO";
	else $palabra = "CREADO";
		echo '<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <span class="glyphicon glyphicon-ok" style="font-size: 50px;"></span> <span style="font-size: 30px;padding-left:30px;">El evento fue '. $palabra .' correctamente.</span>
		</div>';
	}
	?>
		
		
		<div class="row">
		
			<div class="col-sm-4 col-sm-offset-1">
				<?php 
				$path = '../../images/eventos/home/';
				$modificar = isset($_GET['modificar']);				
				if(!$modificar && file_exists($path.$_GET['idEvento'].'.jpg')){
					echo '<p><strong>FOTO HOME</strong></p>';
					echo '<img src="'. $path.$_GET['idEvento'].'.jpg?k='.time().'" width="330" height="258">';
					echo '<div class="btn-toolbar" role="toolbar" >';
					echo '<a class="btn btn-warning" href="eventoCreado.php?idEvento='.$_GET['idEvento'].'&modificar=1" >Modificar</a>';
					echo '<a class="btn btn-warning" href="http://www.aztlan.com.ar" >Ver Home</a>';
					echo '</div>';
				}else{
					echo 
					'<form class="upload" id="upload-1" method="post" action="mini-upload-form/upload-1.php?idEvento='. $_GET['idEvento'].'" enctype="multipart/form-data">
					<div id="drop">
						Foto HOME		
						<a>Cargar foto</a>
						<input type="file" name="upl" multiple />
					</div>
		
					<ul>
						<!-- The file uploads will be shown here -->
					</ul>
		
					</form>';
				}
						
				?>
				
			</div>
			
			<div class="col-sm-4 col-sm-offset-1">
				<?php 
				$path = '../../images/eventos/landing/';
				if(!$modificar && file_exists($path.$_GET['idEvento'].'.jpg')){
					echo '<p><strong>FOTO LANDING</strong></p>';
					echo '<img src="'. $path.$_GET['idEvento'].'.jpg?k='.time().'"  height="30%">';
					echo '<div class="btn-toolbar" role="toolbar" >';
					echo '<a class="btn btn-warning" href="eventoCreado.php?idEvento='.$_GET['idEvento'].'&modificar=1" >Modificar</a>';
					echo '<a class="btn btn-warning" href="http://www.aztlan.com.ar/pages/psi/?c='.$evento->idEvento.'/3/7" >Ver Landing</a>';
					echo '</div>';
				}else{
					echo 
					'<form class="upload" id="upload-2" method="post" action="mini-upload-form/upload-2.php?idEvento='. $_GET['idEvento'].'" enctype="multipart/form-data">
					<div id="drop">
						Foto LANDING		
						<a>Cargar foto</a>
						<input type="file" name="upl" multiple />
					</div>
		
					<ul>
						<!-- The file uploads will be shown here -->
					</ul>
		
					</form>';
				}
						
				?>
				
			</div>
			
		</div>
	
	</div>



</body>
</html>