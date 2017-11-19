<?php
 //echo base_convert('1000', 10, 36);die;
 session_start();
 $_SESSION['now'] = time();
 // var_dump($_SESSION);
 if (!isset($_SESSION['log'])) {
        header('Location: '.'login.php');
    }
    else {
        $now = time(); // Checking the time now when home page starts.

        if ($now > $_SESSION['expire']) {
            session_destroy();
           header('Location: '.'login.php');
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
  <title>Eventos</title>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- Bootstrap -->
  <link href="site/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link href="site/bootstrap/css/bootstrap-switch.min.css" rel="stylesheet">
 <!--
<link rel="stylesheet/less" type="text/css" href="site/less/estilos.less" />
<script src="site/less/less-1.4.1.min.js"></script>
-->

<link href="site/css/estilos.css?v=0.2" rel="stylesheet">


 <!-- PLUGINS -->
 <link href="../site/css/plugins/toastr.css" rel="stylesheet">

 <script src="site/js/script.js?random=<?php echo uniqid(); ?>"></script>

 <?php
 	$limit = (((($_SESSION['expire'] - $_SESSION['now'])/60)*60)*1000) + 300000;
 	echo '<script>var endtime='.$limit.';</script>';
 ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if IE ]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<link href="site/css/ie.css" rel="stylesheet">
      <![endif]-->
    </head>
    <body>

<nav class="header-nav">
<div class="header container">
    <div class="row">

    	<div class="logo col-xs-2 col-sm-2 col-md-4 hidden-xs ">
    		<img src="images/logo.png"  class="pull-left">
    		<div  class="pull-left hidden-sm">
    			<h1 class="h1Header">Aztlan</h1>
    			<h4 class="h4Header">Director Le�n Azulay</h4>
    		</div>
    	</div>

    	<div class="slogan col-xs-8 col-sm-8 col-md-6">
    		<h1 class="h1Header">Escuela de Filosof�a y Psicolog�a</h1>
    		<h4 class="h4Header"><strong>Ense�anza Privada Nivel Terciario - No oficial</strong></h4>
    		<p class="pHeader hidden-xs">Personer�a Jur�dica N� I.G.J. 748</p>
    		<p class="pHeader hidden-xs">Centro Nacional de Organizaciones de la Comunidad C.E.N.O.C. N� 16528</p>
    	</div>
    	<div  class="slogan col-xs-2 col-sm-2 col-md-2">
    	<div class="btn-home"><a href="http://aztlan.com.ar/eventos" ><button class="btn btn-default"><span style="font-size:15px;" class="glyphicon glyphicon-home"></span><strong> Home</strong></a></button></div>
    	<div class="btn-salir"><a href="logout.php"><button class="btn btn-default"><span style="font-size:15px;" class="glyphicon glyphicon-remove"></span> <strong> Salir</strong></a></button></div>
    	</div>
    </div>
</div>
 </nav>

  <nav class="nav-section">
 	<div class="container">
 	<div class="row">
  		<h2 class="pull-left"><span>�ltimos</span> Eventos</h2>
  		<div class=" pull-right">
        <input type="text" name="buscador" value="" class="buscador">
  		  <button type="button" class="btn btn-default btn-lg buscar" style="font-size:20px;" > Buscar</button>

		  <a type="button" class="btn btn-default btn-lg" style="font-size:20px;" href="crear/evento.php"><span class="glyphicon glyphicon-ok-sign" style="font-size:20px;"></span> Crear Nuevo Evento</a>
		</div>
  	</div>
  	</div>
  </nav>

  <div id="form" class="container">

  	   <form class="form-horizontal" role="form">

		<div class="form-group" >
			<label for="inputName" class="col-sm-2 control-label">Nombre</label>
			<div class="col-sm-10">
				<input type="text" class="form-control"  name="nombre" validate chars="2" msg="Debes ingresar tu nombre" value="Sergio"
					placeholder="Nombre">
			</div>

		</div>

		<div class="form-group" >
			<label for="inputLastname" class="col-sm-2 control-label">Apellido</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="apellido" validate chars="2" msg="Debes ingresar tu apellido" value="Makaruk"
					placeholder="Apellido">
			</div>

		</div>

		<div class="form-group" >
			<label for="dni" class="col-sm-2 control-label">Dni</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="dni" validate chars="8" msg="Debes ingresar tu dni" value="32392290"
					placeholder="33322211">
			</div>

		</div>

		<div class="form-group">
			<label for="inputTel" class="col-sm-2 control-label">Tel�fono</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="telefono" validate  msg="Debes ingresar tu tel�fono" value="15.6378.5701"
					placeholder="Tel�fono">
			</div>
		</div>
		<input type="hidden" name="lugares" value="1">
		<!-- <div class="form-group">
			<label for="inputCantidad" class="col-sm-2 control-label">Lugares</label>
			<div class="col-sm-10">
				<select class="form-control" name="lugares">
				  <option>1</option>
				  <option>2</option>
				  <option>3</option>
				  <option>4</option>
				</select>
			</div>
		</div> -->

		<div class="form-group">
			<label  class="col-sm-2 control-label">Owner</label>
			<div class="col-sm-10">
				<select class="form-control" name="owner" id="owner">
				  <option></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label  class="col-sm-2 control-label">Fuente</label>
			<div class="col-sm-10">
				<select class="form-control" name="fuente" id="fuente">
				  <option></option>
				</select>
			</div>
		</div>

		<input type="text" class="form-control" name="tipo" id="tipo" style="display:none">
		<input type="text" class="form-control" name="idEvento" id="idEvento" style="display:none">

		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <div class="checkbox">
		        <label>
		          <input class="form-control" type="checkbox" name="addBase" value="0">
		         Agregar a base de emails
		        </label>
		      </div>
		    </div>
		  </div>

		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <div class="checkbox">
		        <label>
		          <input class="form-control" type="checkbox" name="guardarEmail" value="0">
		         Guardar Email
		        </label>
		      </div>
		    </div>
		  </div>

		<div class="form-group">
			<label for="inputEmail" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control locked" name="email" validate="email"  msg="Debes ingresar tu email" value="maka_idei@hotmail.com"
					placeholder="Email" disabled>
			</div>

		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btnSend btn btn-warning">Enviar</button>
				<div class="loading-form">
					<h4>Enviando...</h4>
						<div class="slider">
							<div class="line"></div>
						  <div class="break dot1"></div>
						  <div class="break dot2"></div>
						  <div class="break dot3"></div>
						</div>
				</div>

			</div>
		</div>

	</form>
  </div>

    <div class="evento-template row" style="display:none;">
		<div class="col-md-6 col-xs-12">
			<h3 class="titulo">Nombre de Evento</h3>
			<h3 class="subtitulo">Subtitulo</h3>
			<h4 class="fecha">Fecha</h4>
			<h5 class="lugar">Lugar</h5>
		</div>
		<div class="col-md-6 col-xs-12">
			<ul class="list-unstyled list-inline reservas">
			<li>
				 <ul  class="list-unstyled">
				 	<li>Reservas</li>
				 	<li class="cantidad n-reservas">120</li>
				 </ul>
				</li>
				<li>
				 <ul  class="list-unstyled" >
				 	<li>Confirmados</li>
				 	<li class="cantidad confirmados">120</li>
				 </ul>
				</li>
				 <li>
				 <ul  class="list-unstyled" >
				 	<li>Asistencia</li>
				 	<li class="cantidad asistencia">0</li>
				 </ul>
				 </li>
				<li>
				<ul  class="list-unstyled" >
				 	<li>Anotados</li>
				 	<li class="cantidad anotados">0</li>
				 </ul>
				 </li>
				<li>
				 <ul  class="list-unstyled">
				 	<li>Disponibilidad</li>
				 	<li class="cantidad disponibilidad">120</li>
				 </ul>
				</li>
			</ul>
			<ul class="list-unstyled list-inline links">
				<li><button  type="button" class="btn btn-warning btn-xs btn-volver">Volver</button></li>
				<li><button  type="button" class="btn btn-warning btn-xs btn-form">Ver Formulario</button></li>
				<li><button  type="button" class="btn btn-warning btn-xs btn-lista">Ver Listado</button></li>
				<li><button  type="button" class="btn btn-warning btn-xs btn-links">Ver Links</button></li>
				<li><button  type="button" class="btn btn-warning btn-xs btn-ver">Ver Asistencia</button></li>
				<li><button  type="button" class="btn btn-warning btn-xs btn-editar">Editar Asistencia</button></li>
			</ul>
		</div>
	</div>

  <div id="lista" class="container">

  	<div class="row">
  		<table class="table table-striped">
	  		<thead>
		        <tr>
		          <th>#</th>
		          <th>Nombre y Apellido</th>
			   	 <!-- <th>Dni</th> -->
		          <th>Email</th>
		         <!--  <th>Tel�fono</th> -->
		          <th>Estado</th>
		          <th>Lugares</th>
		          <th>Link</th>
		          <th>Fuente</th>
		          <th>Acciones</th>
		        </tr>
		      </thead>
		      <tbody>
      		  </tbody>
		</table>
		<div class="btn-group template-btn" style="display:none;">
			<button type="button" class="btn btn-default btn-estado btn-sm" data-estado="0"> <span class="glyphicon glyphicon-remove"></span></button>
			<button type="button" class="btn btn-default btn-estado btn-sm" data-estado="9"> <span class="glyphicon glyphicon-phone-alt"></span></button>
			<button type="button" class="btn btn-default btn-estado btn-sm" data-estado="8"> <span class="glyphicon glyphicon-envelope"></span></button>
			<button type="button" class="btn btn-default btn-estado btn-sm" data-estado="1"> <span class="glyphicon glyphicon-ok"></span> </button>
			<button type="button" class="btn btn-default btn-estado btn-sm btn-borrar" data-estado="2"> <span class="glyphicon glyphicon-trash"></span></button>
			<button type="button" class="btn btn-default btn-usuario btn-sm"> <span class="glyphicon glyphicon-user"></span></button>
		</div>
  	</div>

  </div>

  <div id="lista-editar-asistencia" class="container">

  	<div class="row">
  		<table class="table table-striped">
	  		<thead>
		        <tr>
		          <th>#</th>
		          <th>Nombre y Apellido</th>
		          <th>Email</th>
		          <th>Presente</th>
		          <th>Lugares</th>
		          <th>Pago</th>
		          <th>Anotado</th>
		        </tr>
		      </thead>
		      <tbody>
			<tr class="last-line">
		          <td>TOTAL:</td>
		          <td></td>
		          <td></td>
		          <td></td>
		          <td></td>
		          <td class="total-pagos"></td>
		          <td></td>
		        </tr>
      		  </tbody>
		</table>
  	</div>

	<div class="footer-editar"><button type="button" class="btn btn-default btn-lg btn-guardar"> GUARDAR</button>	</div>
  </div>

  <div id="lista-ver-asistencia" class="container">

  	<div class="row">
  		<table class="table table-striped">
	  		<thead>
		        <tr>
		          <th>#</th>
		          <th>Nombre y Apellido</th>
			   	  <th>Dni</th>
		          <th>Email</th>
		          <th>Tel�fono</th>
		          <th>Presente</th>
		          <th>Lugares</th>
		          <th>Pago</th>
		          <th>Anotado</th>
		          <th>Link</th>
		          <th>Fuente</th>
		        </tr>
		      </thead>
		      <tbody>
      		  </tbody>
		</table>
  	</div>

  </div>

		<div id="login" class="container">
			<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">Login</h3>
				  </div>
				  <div class="panel-body">
				   <form role="form">
					  <div class="form-group">
					    <label >Email address</label>
					    <input type="email" class="form-control" placeholder="Enter email">
					  </div>
					  <div class="form-group">
					    <label >Password</label>
					    <input type="password" class="form-control"  placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-default">Login</button>
					</form>
				  </div>
				</div>

			</div>

			</div>
		</div>
		<div id="dashboard" class="container">
			<div class="evt-container"></div>
			<div class="evento row">
				<div class="col-md-6 col-xs-12">
					<h3 class="titulo">Nombre de Evento</h3>
					<h3 class="subtitulo">Subtitulo</h3>
					<h4 class="fecha">Fecha</h4>
					<h5 class="lugar">Lugar</h5>
				</div>
				<div class="col-md-6 col-xs-12">
					<ul class="list-unstyled list-inline reservas">
						<li>
				 <ul  class="list-unstyled">
				 	<li>Reservas</li>
				 	<li class="cantidad n-reservas">120</li>
				 </ul>
				</li>
				<li>
				 <ul  class="list-unstyled" >
				 	<li>Confirmados</li>
				 	<li class="cantidad confirmados">120</li>
				 </ul>
				</li>
				 <li>
				 <ul  class="list-unstyled" >
				 	<li>Asistencia</li>
				 	<li class="cantidad asistencia">0</li>
				 </ul>
				 </li>
				<li>
				<ul  class="list-unstyled" >
				 	<li>Anotados</li>
				 	<li class="cantidad anotados">0</li>
				 </ul>
				 </li>
				<li>
				 <ul  class="list-unstyled">
				 	<li>Disponibilidad</li>
				 	<li class="cantidad disponibilidad">120</li>
				 </ul>
				</li>
					</ul>
					<ul class="list-unstyled list-inline links">
						<li><button  type="button" class="btn btn-warning btn-xs btn-form">Ver Formulario</button></li>
						<li><button  type="button" class="btn btn-warning btn-xs btn-lista">Ver Listado</button></li>
						<li><button  type="button" class="btn btn-warning btn-xs btn-edit-evento">Editar Evento</button></li>
						<li><button  type="button" class="btn btn-warning btn-xs btn-links">Ver Links</button></li>

					</ul>
					<ul class="list-unstyled list-inline links">
						<li><button  type="button" class="btn btn-warning btn-xs btn-ver">Ver Asistencia</button></li>
						<li><button  type="button" class="btn btn-warning btn-xs btn-editar">Editar Asistencia</button></li>
						<li><button  type="button" class="btn btn-warning btn-xs btn-descargar">Descargar CSV</button></li>
					</ul>
				</div>
			</div>
			</div>

  <nav class="footer " role="navigation">
  	<div class="container">
	  <div class="row">
     <span>&copy; 2014 ESCUELA AZTLAN - Almagro, Ciudad Aut�noma de Buenos Aires, Argentina - <a href="mailto:info@aztlan.com.ar">info@aztlan.com.ar</a> - 4981-0592/2442</span>

  	</div>
	</div>
  </nav>

  <div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ver links</h4>
      </div>
      <div class="modal-body">
        <select id="owner"></select>
        <select id="fuente"></select>
        <ul class="link-resultado list-unstyled">
			  <li class="view-link"><input class="form-control col-xs-6"></input><li>
<!-- 			  <li class="view-link-copy"><button class="btn btn-warning">Copiar Link</button></li>  -->
			  <li class="view-link-csv"><button class="btn btn-warning">Descargar Todos</button></li>
        </ul>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="site/bootstrap/js/bootstrap.min.js"></script>
  <script src="site/bootstrap/js/bootstrap-switch.min.js"></script>

<script>
	setTimeout(function(){ window.location.reload(); }, endtime);
</script>

</body>
</html>
