<?
  ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluaci&oacute;n de Desempe&ntilde;o USB | DGCH </title>
        <link rel="shortcut icon" href="img/favicon.ico"> 
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-select.min.css">
        <link href="js/datepicker/css/datepicker.css" rel="stylesheet"> 
        <link href="js/BootstrapHelpers/css/bootstrap-formhelpers.css" rel="stylesheet">
        <link rel="stylesheet" href="js/select2/select2.css">
        <link href="assets/css/bootstrap-formhelpers.css" rel="stylesheet">
        <link href="css/user.css" rel="stylesheet">
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> 
        <script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>      
    </head>
    <body>
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/bootstrap-confirm.js" type="text/javascript"></script>
    <script src="js/bootstrap.file-input.js" type="text/javascript"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="js/datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="js/datepicker/js/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
    <script src="js/BootstrapHelpers/js/bootstrap-formhelpers-selectbox.js" type="text/javascript"></script>
    <script src="js/select2/select2.js"></script>
    <script src="js/select2/select2_locale_es.js"></script>
    <script src="js/BootstrapHelpers/js/bootstrap-formhelpers-phone.format.js"></script>
    <script src="js/BootstrapHelpers/js/bootstrap-formhelpers-phone.js"></script>
    <script>
        jQuery(function ($) {
            $("a").tooltip()
        });                  
    </script>
    <script>
    $(document).ready(function() {
        $('a[href=#confirm]').click(function(e) {
          //var data = $(this).data('data');
          //var data = $(this).data('data');
          //alert(url+" "+data);
 
          //Link untuk menghapus
          var url = $(this).data('url');
          bootbox.dialog('Esta Seguro de continuar?', [{
                         'label':'No',
                         'class':'btn'
                        },
                        {
                         'label':'Si',
                         'class':'btn',
                         'callback':function() {
                                return location.href = url;
                         }
                        }]);
        });
        $('.selectpicker').selectpicker();
        $('.select2').select2({ width: '310px' });
        $('.datepicker').datepicker()
    });
 
    </script>

<?
  if (isset($_SESSION['USBID'])){
    echo "
    <div class='navbar navbar-fixed-top '>
    <div class='navbar-inner'>
      <div class='container'>
        <a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
          <span class='icon-bar'></span>
          <span class='icon-bar'></span>
          <span class='icon-bar'></span>
        </a>
       <a class='brand' href='index.php'>Inicio</a>
       <div class='nav-collapse collapse' id='main-menu'>
        <ul class='nav' id='main-menu-left'>
          <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>Persona <b class='caret'></b></a>
            <ul class='dropdown-menu' id='swatch-menu'>
              <li><a href='vPersona.php'>Crear Persona</a></li>
              <li><a href='vListarPersonas.php'>Listar Persona</a></li>
            </ul>
          </li>
          <li class='dropdown' id='preview-menu'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>Unidad <b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='vUnidad.php'>Crear Unidad</a></li>
              <li><a href='vListarUnidades.php'>Listar Unidad</a></li>
            </ul>
          </li>
          <li class='dropdown' id='preview-menu'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>Cargo<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='vCargo.php'>Crear Cargo</a></li>
              <li><a href='vListarCargos.php'>Listar Cargo</a></li>
              <li class='divider'></li>
              <li><a href='vFamiliaC.php'>Crear Grupo de Cargos</a></li>
              <li><a href='vListarFamiliasC.php'>Listar Grupo de Cargos</a></li>
	      <li class='divider'></li>
              <li><a href='vFamiliaR.php'>Crear Grupo de Roles</a></li>
              <li><a href='vListarFamiliasR.php'>Listar Grupo de Roles</a></li>
            </ul>
          </li>
          <li>
            <a href='SubirArchivo.php'>Cargar CSV</a>
          </li>
          <li class='dropdown' id='preview-menu'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>Evaluaciones<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='vEvaluaciones.php'>Administrar Procesos de Evaluación</a></li>
              <li><a href='vBusquedaResultados.php'>Ver Resultados</a></li>
              <li class='divider'></li>
              <li><a href='vEncuestas.php'>Administrar Evaluaciones</a></li>
              <li class='divider'></li>
              <li><a href='vEncuestasLimesurvey.php'>Administrar Encuestas Limesurvey</a></li>
              <li><a href='vImportarEncuesta.php'>Importar Encuesta Limesurvey</a></li>              
            </ul>
          </li>
          <li class='dropdown' id='preview-menu'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>Reportes<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='vReportePersonas.php?report=cargo'>Personas por Cargo</a></li>
              <li><a href='vReportePersonas.php?report=unidad'>Personas por Unidad</a></li>
              <li><a href='vReportePersonas.php?report=rol'>Personas por Rol</a></li>
              <li class='divider'></li>
              <li><a href='vReportePersonas.php?report=sincargo'>Personas sin Cargo</a></li>
              <li><a href='vReportePersonas.php?report=sinsupervisor'>Personas sin Evaluador</a></li>
            </ul>
          </li>
          <li>
            <a href='vNotificaciones.php'>Notificaciones&nbsp;"; if($notificaciones){echo "<span class='badge'>".$notificaciones."</span>";} 
    echo "</a></li>
        </ul>
        <ul class='nav pull-right' id='main-menu-right'>
          <li><a class='dropdown-toggle' data-toggle='dropdown' href='#'>";mostrarDatosUsuario(); echo "<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a rel='tooltip' target='_blank' href='http://localhost/limesurvey/admin' title='Ir a Limesurvey' onclick='_gaq.push(['_trackEvent', 'click', 'outbound', 'builtwithbootstrap']);'>Limesurvey <i class='icon-share-alt'></i></a></li>
              <li class='divider'></li>
              <li><a rel='tooltip' href='salir.php' title='Cerrar Sesi&oacute;n'>Salir <i class='icon-off'></i></a></li>
            </ul>
          </li>
        </ul>
       </div>
     </div>
   </div>
 </div>
 ";
}
?>

    <div class="container">  
      <div class="text-center">
        <p>
        <br><br><img src="img/header.png" width="800">
        </p>
	<br>
        <h1>Sistema de Evaluaci&oacute;n de Desempeño USB</h1>
      </div>
      <br><br><br>
      <div class="span12">
        <?   
        if (isset($_GET['success'])){
        echo "  <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>¡Operación realizada con éxito!</strong> ".$_SESSION['MSJ'].".
                </div>";
        }else if (isset($_GET['error'])) {
                echo "  <div class='alert alert-error'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>¡Parece que algo salió mal!</strong> ".$_SESSION['MSJ'].".
                </div>";
        }

        ?>
        <legend><? echo $Legend ?></legend>
  
