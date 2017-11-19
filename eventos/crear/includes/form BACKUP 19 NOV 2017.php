<?php
if(count($_POST) > 0){
	
	echo "RECORD";
	//var_dump($_POST);die;
	
	$newEvento = GET_eventos::setEvento($_POST);
	
	//var_dump($evento);die;
	if(isset($_POST['idEvento'])){
		header('Location: eventoCreado.php?success=1&changed=1&idEvento='.$newEvento);
	}	
	else {
		GET_Eventos::setCamp($newEvento);
		header('Location: eventoCreado.php?success=1&idEvento='.$newEvento);
	}
	exit;
}


?>



<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8">
<title>Eventos</title>
<link rel="icon" type="../../image/png" href="favicon.png">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

<link href="../site/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../site/bootstrap/css/bootstrap-switch.min.css" rel="stylesheet">
<link href="../site/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<link rel="stylesheet/less" type="text/css" href="../site/less/estilos.less" />
<script src="../site/less/less-1.4.1.min.js"></script>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="../site/bootstrap/js/bootstrap-switch.min.js"></script>

<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/adapters/jquery.js" type="text/javascript" ></script>
	
<script src="js/script.js"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if IE ]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<link href="http://aztlan.com.ar/site/css/ie.css" rel="stylesheet">
			<![endif]-->

</head>
	<body>	
	
	<nav class="header-nav">
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
	
	

<div id="form" class="container" style="padding-top:50px;">
  
  	   <form class="form-horizontal" role="form" action="evento.php" method="POST">
  	   
  	   <?php 
  	   	if(isset($evento) && !is_null($evento)){
  	   		
  	   		echo '<div class="form-group" style="display:none;">';
		    echo '<label for="idEvento" class="col-sm-3 control-label">IdEvento</label>';
		    echo '<div class="col-sm-8">';
		    echo '<input type="number" class="form-control" id="idEvento" name="idEvento"  value="'.$evento->idEvento.'">';
			echo '</div>';
		  	echo '</div>';  
  	   	}
  	   ?>
  	   <div class="form-group">  	  
		     <label for="activo" class="col-sm-3 control-label">Activo</label>
		     <div class="col-sm-8">
		      <div class="switch-wrapper">		     	
		     	<?php		
		      		echo '<input id="switch-state" type="checkbox" name="activo"';
		      		if(!isset($evento) || $evento->activo == 1) echo 'checked';
		      		echo ' >';		      	
		     	?>	
		     </div> 
		     </div>
	   </div>
		       
		<div class="form-group">  	  
		     <label for="mostrarHome" class="col-sm-3 control-label">Mostrar en Home</label>
		     <div class="col-sm-8">
		      <div class="switch-wrapper">		     
		     	<?php		
		      		echo '<input id="switch-state-2" type="checkbox" name="mostrarHome"';
		      		if(!isset($evento) || $evento->mostrarHome == 1) echo 'checked';
		      		echo ' >';		      	
		     	?>	     	
		     </div> 
		     </div>
	   </div> 
	   
	  <div class="form-group">  	  
		     <label for="mostrarAstro" class="col-sm-3 control-label">Mostrar en Web Astrología</label>
		     <div class="col-sm-8">
		      <div class="switch-wrapper">
		      <?php		
		      		echo '<input id="switch-state-3" type="checkbox" name="mostrarAstro"';
		      		if(!isset($evento) || $evento->mostrarAstro == 1) echo 'checked';
		      		echo ' >';		      	
		     	?>	     	
		     </div> 
		     </div>
	   </div> 
	   
	   <div class="form-group">  	  
		     <label for="mostrarPsico" class="col-sm-3 control-label">Mostrar en Web Psicología</label>
		     <div class="col-sm-8">
		      <div class="switch-wrapper">
		      <?php		
		      		echo '<input id="switch-state-4" type="checkbox" name="mostrarPsico"';
		      		if(!isset($evento) || $evento->mostrarPsico == 1) echo 'checked';
		      		echo ' >';		      	
		     	?>	     	
		     </div> 
		     </div>
	   </div>  
		        
  <div class="form-group">
    <label for="tipoEvento" class="col-sm-3 control-label">Tipo Evento</label>
    <div class="col-sm-8">
		<select class="form-control"  name="tipoEvento" >
			<option>----------SIN CLASIFICAR ------------------------------------------------------------</option>
			<option value="3" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 3 || !isset($evento))echo 'selected';?> >3 // Landing sin horario >> Terapia Transpersonal</option>
			<option value="4" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 4)echo 'selected';?> >4 // Landing sin horario >> Curso de Mindfulness</option>
			<option value="25" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 25)echo 'selected';?> >25 // Landing sin horario >> Curso de Astrología Holística</option>
			<option value="30" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 30)echo 'selected';?> >30 // Landing sin horario >> Tarot como Oráculo</option>
			<option>----------PSICOLOGÍA ------------------------------------------------------------</option>
			<option value="18" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 18)echo 'selected';?> >18 // LUN 21/08 - 19:00 hs >> Alcanzá una Mente Libre</option>
			<option value="28" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 28)echo 'selected';?> >28 // MAR 22/08 - 11:30 hs >> Vencé el Miedo</option>
			<option value="32" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 32)echo 'selected';?> >32 // MAR 22/08 - 19:30 hs >> Vencé el Miedo</option>
			<option value="33" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 33)echo 'selected';?> >33 // MIE 23/08 - 11:30 hs >> Psicología Transpersonal</option>
			<option value="102" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 102)echo 'selected';?> >102 // MIE 23/08 - 19:30 hs >> Psicología Transpersonal</option>
			<option value="103" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 103)echo 'selected';?> >103 // JUE 24/08 - 11:30 hs >> Cómo vivir en el Presente</option>
			<option>----------ASTROLOGÍA ------------------------------------------------------------</option>
			<option value="112" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 112)echo 'selected';?> >112 // LUN 21/08 - 18:30 hs >> Liberate de tu Karma Negativo</option>
			<option value="19" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 19)echo 'selected';?> >19 // MAR 22/08 - 10:30 hs >> Conocé tu Ascendente</option>
			<option value="20" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 20)echo 'selected';?> >20 // MAR 22/08 - 18:30 hs >> Conocé tu Ascendente</option>
			<option value="26" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 26)echo 'selected';?> >26 // MIE 23/08 - 10:30 hs >> Conocé los Miedos</option>
			<option value="29" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 29)echo 'selected';?> >29 // MIE 23/08 - 18:30 hs >> Conocé los Miedos</option>
			<option value="34" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 34)echo 'selected';?> >34 // JUE 24/08 - 10:30 hs >> La Profesión Ideal</option>
			<option>----------TAROT ------------------------------------------------------------</option>
			<option value="108" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 108)echo 'selected';?> >108 // LUN 21/08 - 18:30 hs >> TAROT ADIVINATORIO</option>
			<option>----------TALLERES Y OTROS CURSOS PROPIOS ------------------------------------------------------------</option>
			<option value="31" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 31)echo 'selected';?> >31 // SÁBADOS 10 hs >> Curso de Yoga</option>
			<option value="117" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 117)echo 'selected';?> >117 // SÁBADOS 10 hs >> Profesorado y Clases de Yoga</option>
			<option>----------EVENTOS Y OTROS ------------------------------------------------------------</option>
			<option value="7" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 7)echo 'selected';?> >7 // VIE 25/08 - 19 hs >> Cineclub</option>
			<option value="118" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 118)echo 'selected';?> >118 // SAB 30/09 - 10:30 hs >> Rafael Más</option>
			<option value="119" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 119)echo 'selected';?> >119 // SAB 02/09 - 18:30 hs >> Medicina Sintergética</option>
			<option>----------FUERA DE USO ------------------------------------------------------------</option>
			<option value="109" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 109)echo 'selected';?> >109 // VIE 18/08 - 10:30 hs >> TAROT COMO ORÁCULO</option>
			<option value="105" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 105)echo 'selected';?> >105 // DOM 20/08 - 18:30 hs >> Aprendé Tarot</option>
			<option value="100" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 100)echo 'selected';?> >100 // LUN 14/08 - 11:30 hs >> Terapia Transpersonal</option>
			<option value="106" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 106)echo 'selected';?> >106 // LUN 21/08 - 18:30 hs >> Liberate de tu Karma Negativo</option>
			<option value="9" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 9)echo 'selected';?> >9 // LUN 21/08 - 18:30 hs >> Conocé las Energías</option>
			<option value="101" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 101)echo 'selected';?> >101 // JUE 17/08 - 18:30 hs >> Astrología Holística</option>
			<option value="114" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 114)echo 'selected';?> >114 // JUE 17/08 - 18:30 hs >> Astrología Holística</option>
			<option value="111" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 111)echo 'selected';?> >111 // JUE 17/08 - 11:30 hs >> Astrología Holística</option>
			<option value="27" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 27)echo 'selected';?> >27 // VIE 18/08 - 19 hs >> Lama Rinchen Kandro</option>
			<option value="24" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 24)echo 'selected';?> >24 // DOM 20/08 - 18 hs >> Numerología Esotérica</option>
			<option value="104" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 104)echo 'selected';?> >104 // DOM 20/08 - 18 hs >> Numerología Esotérica</option>
			<option value="107" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 107)echo 'selected';?> >107 // DOM 20/08 - 19:30 hs >> Psicología Transpersonal</option>
			<option value="110" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 110)echo 'selected';?> >110 // Wagner</option>
			<option value="113" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 113)echo 'selected';?> >113 // Astrología y Autoconocimiento</option>
			<option value="115" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 115)echo 'selected';?> >115 // Astrología Kármica</option>
			<option value="116" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 116)echo 'selected';?> >116 // Taller Mindfulness</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 120)echo 'selected';?> >120 // fuera de uso</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 131)echo 'selected';?> >131 // Psicología 1</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 132)echo 'selected';?> >132 // Psicología 2</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 133)echo 'selected';?> >133 // Psicología 3</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 134)echo 'selected';?> >134 // Astrología 1</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 135)echo 'selected';?> >135 // Astrología 2</option>
			<option value="120" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 136)echo 'selected';?> >136 // Astrología 3</option>
			<!-- <option value="1" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 1)echo 'selected';?> >1 // Cineclub</option>
			<option value="2" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 2)echo 'selected';?> >2 // Taller</option> -->
			<!-- <option value="8" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 8)echo 'selected';?> >8 // Consultoría Astrológica</option> -->
			<!-- OPTION value 18 > ex: Charla Psicología y Astrología, actual: Taller I Ching -->
			<!-- <option value="10" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 10)echo 'selected';?> >10 // Consulta Psicología</option>
			<option value="11" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 11)echo 'selected';?> >11 // Consulta Astrología</option>
			<option value="12" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 12)echo 'selected';?> >12 // Consulta Tarot</option>
			<option value="13" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 13)echo 'selected';?> >13 // Entrevista Psicología</option>
			<option value="14" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 14)echo 'selected';?> >14 // Entrevista Astrología</option>
			<option value="17" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 17)echo 'selected';?> >17 // Entrevista Tarot</option>
			<option value="15" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 15)echo 'selected';?> >15 // Beca Psicología</option>
			<option value="16" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 16)echo 'selected';?> >16 // Beca Astrología</option>-->
			<!-- OPTION value 18 > ex: Psicología con Videos, actual: Seminario Wagner -->
			<!-- OPTION value 18 > ex: Astrología con Videos, actual: Taller de Mindfulness -->
			<!-- OPTION value 18 > ex: Tarot con Videos, actual: Curso de Mindfulness -->
			<!-- OPTION value 28 > ex: Consultas Cursos y Talleres 2017, actual: Seminario Bhagavad-Gita -->
			<!-- <option value="21" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 21)echo 'selected';?> >21 // Psicologia Charla 2016</option>
			<option value="22" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 22)echo 'selected';?> >22 // Astrologia Charla 2016</option>
			<option value="23" <?php if(isset($evento) && $evento->tipoEvento_idTipo == 23)echo 'selected';?> >23 // Tarot Charla 2016</option> -->
			<!-- OPTION value 30 > ex: Consultas Astrología 2017, actual: Charla Astrología opción 2 -->
			<!-- OPTION value 31 > ex: Consultas Tarot 2017, actual: Curso de Yoga -->
			<!-- OPTION value 32 > ex: Descuento Psicología 2017, actual: Curso de Cocina -->
			<!-- OPTION value 33 > ex: Descuento Astrología 2017, actual: Charla Psicología opción 2 -->
			<!-- OPTION value 34 > ex: Descuento Tarot 2017, actual: Taller Anti-Estrés Nivel 1 y 2 -->
		</select>
    </div>
  </div>
  
  <div class="form-group">
    	<label for="disponibilidad" class="col-sm-3 control-label">Disponibilidad</label>
    	<div class="col-sm-8">
     	<input type="number" class="form-control" id="disponibilidad" name="disponibilidad" placeholder="Disponibilidad" value="120">
		</div>
  </div>
  
  <div class="form-group">
    	<label for="lugar" class="col-sm-3 control-label">Lugar</label>
    	<div class="col-sm-8">
	     	 <select class="form-control"  name="lugar" >
			  <option value="1" <?php if(isset($evento) && $evento->lugar_idLugar == 1)echo 'selected';?> >Apart Hotel Congreso - Sala Grande</option>
			  <option value="2" <?php if(isset($evento) && $evento->lugar_idLugar == 2)echo 'selected';?> >Apart Hotel Congreso - Sala Chica</option>
			  <option value="3" <?php if(isset($evento) && $evento->lugar_idLugar == 3 || !isset($evento))echo 'selected';?>>Escuela Aztlan - Sede Central</option>
			  <option value="4" <?php if(isset($evento) && $evento->lugar_idLugar == 4)echo 'selected';?> >Escuela Aztlan - Sede Almagro II</option>			  
			  <option value="5" <?php if(isset($evento) && $evento->lugar_idLugar == 5)echo 'selected';?> >Jardín de los Ángeles</option>
			  <option value="6" <?php if(isset($evento) && $evento->lugar_idLugar == 6)echo 'selected';?> >Sr. Duncan - Centro Cultural</option>
			  <option value="7" <?php if(isset($evento) && $evento->lugar_idLugar == 7)echo 'selected';?> >Salon</option>
			</select>
		</div>
  </div>
  
  <div class="form-group">
    <label for="fecha" class="col-sm-3 control-label">Fecha Sistema</label>
    <div class="col-sm-8">      
			<div class='input-group date' id='datetimepicker5'>
				<input type='text' class="form-control" data-date-format="YYYY/MM/DD"  name="fecha" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>			
		</div>
		<?php if(isset($evento)){
		echo '<script type="text/javascript">
			$(function (){
			 /* $("#setDate").click(function () {*/
                    $("#datetimepicker5").data("DateTimePicker").setDate("'.$evento->date.'");
               /* });
                
                $("#datetimepicker5").data("DateTimePicker").show();   */          
                
            });
             
        </script>';
		}
		?>
        
    </div>
    
    <div class="form-group">
    	<label for="titulo" class="col-sm-3 control-label">Título</label>
    	<div class="col-sm-8">
      	<input type="text" class="form-control" id="titulo" placeholder="Título" name="titulo" <?php if(isset($evento)) echo 'value="'.utf8_decode($evento->titulo).'"'?> >
		</div>
    </div>
    
    <div class="form-group">
    	<label for="subtitulo" class="col-sm-3 control-label">Subtítulo</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="subtitulo" placeholder="Subtítulo"  name="subtitulo"  <?php if(isset($evento)) echo 'value="'.utf8_decode($evento->subtitulo).'"'?>>
		</div>
    </div>
    
    <div class="form-group">
    	<label for="fechaVisible" class="col-sm-3 control-label">Fecha Visible</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="fechaVisible" placeholder="Fecha Visible"  name="fechaStr"  <?php if(isset($evento)) echo 'value="'.utf8_decode($evento->fechaStr).'"'?>>
		</div>
    </div>
    
    <div class="form-group">
    	<label for=""horario"" class="col-sm-3 control-label">Horario</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="horario"   name="horario"  <?php if(isset($evento)) echo 'value="'.utf8_decode($evento->horario).'"'; else echo 'value=17:00'; ?>>
		</div>
    </div>
    <div class="form-group">
    	<label for="maxHorario" class="col-sm-3 control-label">Max Horario</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="maxHorario"   name="maxHorario"  <?php if(isset($evento)) echo 'value="'.utf8_decode($evento->maxHorario).'"'; else echo 'value=17:15'; ?>>
		</div>
    </div>
    
    <div class="form-group <?php echo (isset($evento) && $evento->tipoEvento_idTipo == 1) ? 'visible' : 'hidden'?> ">
    	<label for="idYoutube" class="col-sm-3 control-label">Video de YouTube (solo ID)</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="idYoutube" placeholder="Solo si es CINECLUB, insertar ID de Video de YOUTUBE"  name="idYoutube"  <?php if(isset($evento) && $evento->idYoutube != '') echo 'value="'.$evento->idYoutube.'"'?>>
		</div>
    </div>
    
    <div class="form-group <?php echo (isset($evento) && $evento->tipoEvento_idTipo == 1) ? 'visible' : 'hidden'?> ">
    	<label for="link" class="col-sm-3 control-label">Link</label>
    	<div class="col-sm-8">
      <input type="text" class="form-control" id="link" placeholder="Link"  name="link"  <?php if(isset($evento) && $evento->link != '') echo 'value="'.$evento->link.'"'?>>
		</div>
    </div>
    
    <div class="form-group">
    	<label for="fechaVisible" class="col-sm-3 control-label">Texto</label>
    	<div class="col-sm-8">
      		
      		<textarea name="texto" id="editorEditar"  rows="10" class="ckeditor required form-control" ><?php if(isset($evento)) echo utf8_decode(htmlspecialchars_decode($evento->texto))  ?></textarea>
		</div>		
		
    </div>
  <?php  	if(isset($evento) && !is_null($evento)){ 
		echo '<button type="submit" class="btn btn-warning btn-lg col-sm-offset-3">Editar Evento</button>';
  }else echo '<button type="submit" class="btn btn-warning btn-lg col-sm-offset-3">Crear Evento</button>';
  ?> 
</form>

<?php if(isset($evento) && !is_null($evento)){  	   		
  	   		echo '<a  class="btn btn-warning btn-lg col-sm-offset-3" href="eventoCreado.php?idEvento='.$evento->idEvento.'">Modificar fotos</a>';  
  	   	}
 ?>


</div>

</body>
</html>