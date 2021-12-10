 <?php
  include("funciones.global.inc.php");
//  include("funciones.inc.php");


  verifica_sesion(false);

?>

<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <title>Portal de Sistemas Clinicos- Armada de Chile</title>
    <link rel="shortcut icon" href="img/favicon.ico">
    


    <!-- Core stylesheets -->
  
<?php if ($_SESSION["portal"]["email"] !=""){ ?>

	<script src="menu/libreria/jquery.min.js"></script>
    <script src="menu/libreria/bootstrap.min.js"></script>
    <script src="menu/libreria/custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.min.css">

    <link rel="stylesheet" href="css/services.css">
		<link rel="stylesheet" href="jquery-ui/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" />
<?php
}else{
?>
<script src="menu/libreria/jquery.min.js"></script>
    <script src="menu/js/tether.min.js"></script>
    <script src="menu/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="menu/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu/font-awesome-4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" href="menu/css/style.default.css" id="theme-stylesheet">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="menu/css/pages/login.css">
	<link rel="stylesheet" href="jquery-ui/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" />
<?php
}
?>
<script src="jquery-ui/js/jquery-ui-1.10.0.custom.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="jquery/css/ui.jqgrid.css" />
<script src="jquery/js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="jquery/js/jquery.form.js"></script>
<script src="portal.js?dummy=<?php echo rand();?>"></script>

	 
	
	
<script>
function carga_contenido(cod_categ,sn_adm,sn_elimordenlab) {
    if(sn_adm =="S")
	$( "#content" ).load( "Vistas/Usuarios.php" );
	else if(sn_elimordenlab =="S")
	$( "#content" ).load( "Vistas/ElimOrdenLab.php" );
	
	else
    $( "#content" ).load( "Vistas/Escritorio.php?cod_categ="+cod_categ );
}

</script>

<style>
  /*.ui-dialog-titlebar { height: 100px; }*/
<?php if ($_SESSION["portal"]["email"] !=""){ ?>  
body {
	margin: 0;			/* Remove body margin/padding */
	padding: 0;
	overflow-y: scroll;	/* Remove scroll bars on browser window */	

}
<?php }else{ ?>
html,body {
	margin: 0;			/* Remove body margin/padding */
	padding: 0;
	overflow: hidden;	/* Remove scroll bars on browser window */	
    font-size: 85%;
}

<?php } ?>

</style>
</head>
 <body class="nav-md">


<?php if ($_SESSION["portal"]["email"] !=""){ ?>

<input type="hidden" id="conectado" value="S">
<div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="http://registrosclinicos.hospitalnaval.cl/index.php" class="site_title"><!--<i class="fa fa-anchor"></i>--> <span>Portal de Sistemas</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <!--<div class="profile_pic">
                <img src="img/usuario.png" alt="..." class="img-circle profile_img">
              </div>-->
              <div class="profile_info">
			  
              <span>Bienvenido(a) :</span><br>
             <div style="color:white;font-size:15px;"><?php echo $_SESSION["portal"]["nombres"]." ".$_SESSION["portal"]["apellido_paterno"]." ".$_SESSION["portal"]["apellido_materno"]." "; ?>  <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" href="logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a></div>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            
           <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">      
   
		  <?php
		  $db = genera_adodb();
		  if($_SESSION["portal"]["sn_admin"] =="S")
		  $recordset = $db->Execute("select * from categoria where sn_adm in ('S','N') order by 1 ");
		  else
		  $recordset = $db->Execute("select * from categoria where sn_adm in ('N') order by 1 ");
		  
  if (!$recordset) die("Err : " . $db->ErrorMsg());
  $encontrado=0;
  while ($arr = $recordset->FetchRow()) {
         print(' <li><a href="#" onclick="carga_contenido('.$arr["cod_categ"].',\''.$arr["sn_adm"].'\',\'N\');"><span>'.strtoupper(utf8_encode($arr["desc_categ"])).'</span></a></li>');
  }
  if($_SESSION["portal"]["sn_elimordenlab"] =="S")
   print(' <li><a href="#" onclick="carga_contenido(\'\',\'N\',\'S\');"><span>ELIMINACION DE OT LABORATORIO ENVIADA A PORTAL</span></a></li>');

		  $db->disconnect();
		  ?>
       
      
   </ul>
             
            </div>
            

          </div>
          <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              
             
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <!--<div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>-->

              <ul class="nav navbar-nav ">
                <li class="">
                  <a>&nbsp;</a>
                </li>
              </ul>      

             
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

      <!-- page content -->
<div class="right_col" role="main" >
<div class="">
  
  <style>
      .marg{
        margin-bottom:20px;
      }
    </style>

      <center><section style="max-width:1024px;">
          <div class="container">

  <div id="content" ></div>
   </div></div></section> </center>

</div>
<!-- /page content -->
<!-- -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            copyright © 2019 Hospital Naval | Almirante Nef
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
<?php
}else{
?>
<section class="hero-area">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-md-12 ">
                <div class="contact-h-cont">
                  <h3 class="text-center">Portal de sistemas clínicos</h3><br>
                  <p>Por Favor, ingrese datos de Correo Sanidad Naval. </p>
                  <form  id="form_login" method="post" action="login.php">
                    <div class="form-group">
                      <label for="username">Usuario</label>
                      <input type="text" id="email" name="email"  placeholder="" class="form-control"> 
                    </div>  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Contraseña</label>
                      <input class="form-control" type="password" id="clave" name="clave"> 
                    </div>
					<div class="form-group">
                    <input class="mt-5" type="checkbox" id="condiciones" name="condiciones" value="S">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Al ingresar a este Portal, acepto dar cumplimiento a los términos definidos en el artículo N°13 de la ley N° 20.584 (deberes y derechos de los pacientes) y la ley N° 19.628 (protección de la vida privada). Además, por éste mismo acto, tomo conocimiento que todas las acciones de lectura y/o registro quedarán asociadas a mi identidad de Usuario del sistema.<p class="mt-3">Tomar conocimiento de la existencia de Registros Clínicos Paralelos en:<p/>

<p><b>Diálisis:</b> “Protocolo de Hemodiálisis” y “Hoja de Exámenes y Tratamiento”<p/>

<p><b>Radioterapia:</b> “Cartola de Tratamiento de Radioterapia”.<p/>

<p><b>Medicina Nuclear:</b> CD con imágenes de exámenes, hojas de “Registro de Procedimiento de Medicina Nuclear” y  Consentimientos Informados.<p/>

<p><b>Hemodinamia y Angiografía:</b> CD con imágenes de exámenes y procedimientos.<p/>

<p><b>Imagenología:</b> Consentimientos Informados de exámenes ambulatorios efectuados con medio de contraste.<p/>


					</div>
					
					<br><br>	
                    <button style="text-align:right;"  type="submit"  id="button-login" class="btn  btn-blue" role="button"><i fa fa-right-arrow></i>Iniciar sesión</button>
                  </form>
                  <br><br>
                  
                  <p style="text-align:right;"><i class="fa fa-phone fa -2x"></i> Soporte Informática: soportehnv@sanidadnaval.cl<br>
                   Anexo:3076. </p>
                </div>
            </div>
          </div>  
        </div>
      </section>
      
    <!--Global Javascript -->
    
    
<?php
}
?>


<script>   carga_contenido(1);</script>

</body>
</html>
