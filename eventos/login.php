<?php

if($_POST){
	//var_dump($_POST);die;

		$dsn = 'mysql:dbname=azwuser_usuarios;host=localhost';
		$user = 'root';
		$password = '';

		/*$dsn = 'mysql:dbname=azwuser_usuarios;host=localhost;port=3306';
		$user = 'azwuser_admin';
		$password = 'Acuario1936BASE';*/

		try{
			$dbh = new PDO($dsn,$user,$password);
			$user = htmlspecialchars($_POST['user']);
			$pass = htmlspecialchars($_POST['pass']);

			$sql = "SELECT id FROM login WHERE
			user = '$user' AND
			pass = '$pass'
			";
			//echo $sql;
			$result = $dbh->query($sql);
			$id = $result->fetchObject();
			if($id){
				 session_start();
				  $_SESSION['start'] = time(); // Taking now logged in time.
				  $_SESSION['log'] = 'in';
            	// Ending a session in 30 minutes from the starting time.
           		  //$_SESSION['expire'] = $_SESSION['start'] + (60);
           		  if($id->id == 1) $_SESSION['expire'] = $_SESSION['start'] + (60 * 30);
           		  else $_SESSION['expire'] = $_SESSION['start'] + (5*60);

            	header('Location: '.'index.php');
			}
			else{
				$_POST = null;
				$_POST['error'] = true;
			}
		} catch (PDOException $e) {
			echo 'Conexi�n fallida: '.$e->getMessage();
		}


}
?>


<!DOCTYPE html>
<html lang="es">
  <head>
   <!--  <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

     <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- Bootstrap -->
  <link href="site/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet/less" type="text/css" href="site/less/estilos.less" />
<script src="site/less/less-1.4.1.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
    	<a href="http://aztlan.com.ar/eventos" ><span style="font-size:50px;" class="glyphicon glyphicon-home"></span></a>
    	</div>
    </div>
</div>
 </nav>


    <div class="container">
    <div class="row">

	<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

	<?php if (isset($_POST['error'])){
      echo '<div class="alert alert-danger" role="alert">';
  		echo '<strong>Usuario no registrado</strong></div>';

      }?>

      <!-- <form class="form-signin" method="post" action="login.php"> -->
      <form class="form-horizontal login-form" role="form" action="login.php" method="POST">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="email" id="inputEmail" name="user" class="form-control" placeholder="Usuario" required autofocus>
        <label for="inputPassword" class="sr-only">Contrase�a</label>
        <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Contrase�a" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit" >Entrar</button>
      </form>

       </div>
		</div> <!-- /row -->
    </div> <!-- /container -->


  </body>
</html>
