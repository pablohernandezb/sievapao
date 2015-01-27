<?
  ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluaci&oacuten USB</title>
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

    <div class="container">  
      <div class="text-center">
        <p>
        <br><br><img src="img/header.png" width="800">
        </p>
        <h1>Sistema de Evaluaci&oacuten USB</h1>
      </div>

      <div class="span12">
        <?   
        if (isset($_GET['success'])){
        echo "  <div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>¡Operación realizada con Exito!</strong> ".$_SESSION['MSJ'].".
                </div>";
        }else if (isset($_GET['error'])) {
                echo "  <div class='alert alert-error'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>¡Parece que algo salió mal!</strong> ".$_SESSION['MSJ'].".
                </div>";
        }

        ?>
        <legend><? echo $Legend ?></legend>
  
