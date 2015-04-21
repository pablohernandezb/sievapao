<?php

    session_start();
    require "cAutorizacion.php";
    require "cResultados.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();


    // Include the main TCPDF library (search for installation path).
   require_once('tcpdf/tcpdf.php');
   // require_once('tcpdf/examples/tcpdf_include.php');
   

   
   // Extend the TCPDF class to create custom Header and Footer
   class MYPDF extends TCPDF {

    //Page header
    public function Header() {
         // Logo
         $image_file = K_PATH_IMAGES.PDF_HEADER_LOGO;
         $this->Image($image_file, 10, 10, 190, 25, 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
         // Set font
         $this->SetFont('helvetica', 'B', 20);
         // Add new line
         $this->Ln('', false);
         // Title
//          $this->Cell(0, 25, 'Sistema Vernier', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	 
    }
	
    // Page footer
    public function Footer() {
        // Position at 30 mm from bottom
        $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $image_cebolla = K_PATH_IMAGES.'cebolla_70_45.jpg';
        $this->Image($image_cebolla, 10, '', 0, 0, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
        $htmlFooter ='
                        <div class="span11" style="font-size: 12px; line-weight:100%;">
                            <a href="http://www.usb.ve/home/node/68">e-virtual</a> | <a href="https://webmail.usb.ve/" target="_blank">Correo</a> |<a href="http://www.usb.ve/buscador.php" target="_blank"> </a><a href="https://esopo.usb.ve">esopo</a> |<a href="http://www.usb.ve/buscador.php" target="_blank"> </a><a href="http://www.youtube.com/canalusb" target="_blank">canalUSB</a> | <a href="http://www.usb.ve/agenda.php" target="_blank">Agenda Cultural</a> | <a href="http://usbnoticias.info/" target="_blank">USBnoticias</a> |<span> </span><span> </span><a href="http://www.usb.ve/home/node/55">Calendario</a>
                            <br>Sede Sartenejas, Baruta, Edo. Miranda - Apartado 89000 - Cable Unibolivar - Caracas Venezuela. Tel&eacute;fono +58 0212-9063111
                            <br>Sede Litoral, Camur&iacute; Grande, Edo. Vargas Parroquia Naiguat&aacute;. Tel&eacute;fono +58 0212-9069000
                        </div>';
        $this->writeHTMLCell(0, 0, '', '', $htmlFooter, 0, 1, 0, true, '', true);
        // Page number
        $this->Cell(0, 10, 'Pág. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
   }

   // create new PDF document
   $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

   // set document information
   $pdf->SetCreator(PDF_CREATOR);
   $pdf->SetAuthor(PDF_AUTHOR);
   $pdf->SetTitle('Evaluación de desempeño');
   $pdf->SetSubject('Evaluación del desempeño del personal administrativo y obrero de la Universidad Simón Bolívar');
   $pdf->SetKeywords('DGCH, PDF, evaluación, USB');

   // set default header data
   $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
   $pdf->setFooterData(array(0,64,0), array(0,64,128));

   // set header and footer fonts
   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

   // set default monospaced font
   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

   // set margins
   $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
   $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

   // set auto page breaks
   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

   // set image scale factor
   $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

   // ---------------------------------------------------------

   // set default font subsetting mode
   $pdf->setFontSubsetting(true);

   // Set font
   // dejavusans is a UTF-8 Unicode font, if you only need to
   // print standard ASCII chars, you can use core fonts like
   // helvetica or times to reduce file size.
   $pdf->SetFont('helvetica', '', 12, '', true);

   // set text shadow effect
   $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

   // ---------------------------------------------------------------------
   
   if (isset($_GET['id_encuesta_ls'])){
   
      //Obtención de la familia de cargos asociada a la encuesta
      $sql ="SELECT nombre ";
      $sql.="FROM FAMILIA_ROL WHERE id='".(int)$_GET['id_fam']."'";
      $atts = array("nombre");
      $FAMILIA_ROL_EVALUADO= obtenerDatos($sql, $conexion, $atts, "Fam");   
      
      //-----------------------------------------------------------------------------------------
      // Añade una página
      $pdf->AddPage();
      
      $pdf->SetFont('helvetica', 'BI', 12);
         
      $pdf->Cell('', '', 'EVALUACIÓN DEL DESEMPEÑO', 0, 1, 'C', false, '', 0, false, 'T', 'C');       
      $pdf->Cell('', '', 'PERSONAL SUPERVISADO', 0, 1, 'C', false, '', 0, false, 'T', 'C');  
        
      $texto_encuesta=$FAMILIA_ROL_EVALUADO['Fam']['nombre'][0];
      $pdf->Cell('', '', $texto_encuesta, 0, 1, 'C', false, '', 0, false, 'T', 'C'); 
         
      $pdf->Cell('', '', 'PROCESO DE EVALUACIÓN - '.$PERIODO.' ', 0, 1, 'C', false, '', 0, false, 'T', 'C');  
      
      $pdf->Ln(5, false);
      
      $pdf->SetFont('helvetica', '', 12);
      
      //Tabla de Datos del Trabajador
      $tbl ='
         <table border="1" cellpadding="4" cellspacing="2" align="center">
            <tr nobr="true">
               <th colspan="2" bgcolor="#cccccc"> DATOS DEL TRABAJADOR</th>
            </tr>
            <tr nobr="true" align="left">
               <td><small>1.1 Apellidos y Nombres: '.$NOMBRE.'</small></td>
               <td><small>1.2 No. Cédula de Identidad: '.$CEDULA.'</small></td>
            </tr>
            <tr nobr="true" align="left">
               <td><small>1.3 Cargo: '.$CARGO.'</small></td>
               <td><small>1.4 Ubicación: '.$UNIDAD.'</small></td>
            </tr>
         </table>';
         
      $pdf->writeHTML($tbl, true, false, false, true, '');
      
      $pdf->Ln(10, false);
      
      //-----------------------------------------------------------------------------------------
   
   
      //Lista de preguntas
      $sql ="SELECT id_encuesta_ls, id_pregunta, id_pregunta_ls, titulo, seccion ";
      $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."' AND id_pregunta_root_ls IS NULL ";
      $sql.="ORDER BY seccion, id_pregunta_ls";
      $atts = array("id_encuesta_ls", "id_pregunta", "id_pregunta_ls", "titulo", "seccion");
      
      $LISTA_PREGUNTAS= obtenerDatos($sql, $conexion, $atts, "Preg");
      
      for($i=0; $i<$LISTA_PREGUNTAS[max_res]; $i++){


         //Lista de subpreguntas de la pregunta correspondiente
         $sql ="SELECT id_encuesta_ls, id_pregunta, id_pregunta_ls, titulo, seccion ";
         $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."' AND id_pregunta_root_ls='".$LISTA_PREGUNTAS['Preg']['id_pregunta_ls'][$i]."'";        
         $atts = array("id_encuesta_ls", "id_pregunta", "id_pregunta_ls", "titulo", "seccion");
         
         $LISTA_SUBPREGUNTAS= obtenerDatos($sql, $conexion, $atts, "Preg");
         
         
         $pdf->SetFont('helvetica', '', 12);
      
         
         if(strcmp($LISTA_PREGUNTAS['Preg']['seccion'][$i],"competencia")==0 && $instruc_comp!=1){
            $texto_seccion='I. INSTRUCCIÓN GENERAL<br />
			   <br />El propósito de esta encuesta es recolectar información sobre el desempeño del trabajador, a fin de conocer las áreas que deban ser fortalecidas, utilizando programas de formación y adiestramiento para llegar al nivel de  desempeño requerido. Al llenar la encuesta debe considerar todos los factores  sin  omitir alguno. La veracidad de sus respuestas contribuirá a reflejar conductas generadas que inciden en el desempeño.<br />';
                           
            $texto_seccion.='<br />
                           II. ESCALA DE EVALUACIÓN<br />
                           Coloque la calificación que identifique la frecuencia de la conducta en cada aspecto de la encuesta de acuerdo a su percepción. Por favor evalúe la conducta como la observa, no como a usted le gustaría que fuera. <br />Utilice la siguiente la escala: Nunca, Rara vez, A veces, Con frecuencia, Generalmente y Siempre.<br /><br />
                           III. EVALUACIÓN DE FACTORES DE DESEMPEÑO <br />
			   Las respuestas se verán marcadas con una "X" en color <span style="color: rgb(0, 94, 255);">azul</span> para el Supervisor Inmediato y con una "O" en color <span style="color: rgb(0, 128, 64);">verde</span> para el Evaluado.<br /> ';
		           
            $instruc_comp = 1;

            $pdf->writeHTML($texto_seccion, true, false, true, true, '');
            
            $pdf->Ln(5, false); 
            
         }else{
            if(strcmp($LISTA_PREGUNTAS['Preg']['seccion'][$i],"factor")==0 && $instruc_fac!=1){
               $texto_seccion="IV. INSTRUCCIÓN GENERAL<br/>
                           <br/>
                           El propósito principal de esta parte de la evaluación es el de recolectar evidencias sobre factores o acciones que influyen en el
                           desempeño profesional de una persona, con la intención de construir un juicio constructivo sobre la percepción que se tiene del
                           trabajador sobre su rol y perfil profesional.<br/>
                           <br/>
                           <br/>
                           V. ESCALA DE EVALUACIÓN DE DESEMPEÑO<br/>
                           <br/>
                           Para evaluar utilice la siguiente escala:<br/><br/> 
                           Excelente: Es una persona que además de superar las expectativas, plantea acciones innovadoras que van mas allá de lo que el rol le exige.<br/>
                           Sobre lo esperado: Cuando supera las expectativas en congruencia con lo que se espera para ese rol.<br/> 
                           En lo esperado: Es cuando la persona es congruente con lo que se espera de sus acciones, dentro del promedio.<br/> 
                           Por debajo de lo esperado: Es cuando la persona no alcanza el mínimo requerido para el rol que esta desempeñando junto con las expectativas 
                           del supervisor inmediato. 
                           <br/><br/>
                           VI. EVALUACIÓN DE FACTORES DE DESEMPEÑO";
               $instruc_fac = 1;
               
               // Añade una página
               $pdf->AddPage();
               
               $pdf->writeHTML($texto_seccion, true, false, true, true, '');
               
               $pdf->Ln(5, false); 
               
            }
         }  
         
         $htmlPregunta =$LISTA_PREGUNTAS['Preg']['titulo'][$i];
         
         $pdf->SetFont('helvetica', '', 10);         
         
         if($LISTA_SUBPREGUNTAS[max_res]>0){
            $tbl ='
            <table border="1" cellpadding="2" cellspacing="2" align="center">
               <tr nobr="true">
                  <td width="40%">Factor > <strong>'.$htmlPregunta.'</strong></td>
                  <td width="10%"><p style="font-size:9px">Nunca</p></td>
                  <td width="10%"><p style="font-size:9px">Rara vez</p></td>
                  <td width="9%"><p style="font-size:9px">A veces</p></td>
                  <td width="12%"><p style="font-size:9px">Con frecuencia</p></td>
                  <td width="10%"><p style="font-size:9px">Generalmente</p></td>
                  <td width="9%"><p style="font-size:9px">Siempre</p></td>
               </tr>';
         
            for($j=0; $j<$LISTA_SUBPREGUNTAS[max_res]; $j++){
               $htmlSubPregunta =$LISTA_SUBPREGUNTAS['Preg']['titulo'][$j];
               
               $tbl.='
                  <tr nobr="true">
                     <td><p style="font-size:13px">'.$LISTA_SUBPREGUNTAS['Preg']['titulo'][$j].'</p></td>';

		     // Busco las respuestas del evaluado
		     switch($LISTA_COMPETENCIAS['Preg']['resultado'][$i+$j]) {
			case 'Nunca':
		              $RESP_EVA[0]='O';
			      break;
			case 'Rara vez':
		              $RESP_EVA[1]='O';
			      break;
			case 'A veces':
		              $RESP_EVA[2]='O';
			      break;
			case 'Con frecuencia':
		              $RESP_EVA[3]='O';
			      break;
			case 'Generalmente':
		              $RESP_EVA[4]='O';
			      break;
			case 'Siempre':
		              $RESP_EVA[5]='O';
			      break;
			default:
			      break;
		     }               

		    // Busco las respuestas del supervisor inmediato que hace la consulta
                    $ind_sup = 0;
		    for($k=0; $k<count($LISTA_EVALUADORES['Eva']['token_ls']); $k++) {
			if($LISTA_EVALUADORES['Eva']['token_ls'][$k]==$_GET['token_ls']) {
				$ind_sup = $k;
			}
		    }

		     switch($LISTA_EVALUADORES['Eva']['re_competencia'][$ind_sup][$i+$j]) {
			case 'Nunca':
		              $RESP_SUP[0]='X';
			      break;
			case 'Rara vez':
		              $RESP_SUP[1]='X';
			      break;
			case 'A veces':
		              $RESP_SUP[2]='X';
			      break;
			case 'Con frecuencia':
		              $RESP_SUP[3]='X';
			      break;
			case 'Generalmente':
		              $RESP_SUP[4]='X';
			      break;
			case 'Siempre':
		              $RESP_SUP[5]='X';
			      break;
			default:
			      break;
		     }         


          $tbl.='<td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[0].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[0].'</span></td>
                 <td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[1].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[1].'</span></td>
                 <td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[2].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[2].'</span></td>
                 <td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[3].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[3].'</span></td>
		 <td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[4].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[4].'</span></td>
		 <td><span style="color: rgb(0, 128, 64);">'.$RESP_EVA[5].'</span> &nbsp; <span style="color: rgb(0, 94, 255);">'.$RESP_SUP[5].'</span></td>';
               $tbl.='</tr>';

	     // Limpio los arreglos usados para escribir las respuestas
             unset($RESP_EVA);
	     unset($RESP_SUP);   

            }
            
            $tbl.='</table> <br>';
            
            $pdf->writeHTML($tbl, true, false, false, true, '');
            
             //Añade una página
	     if($i%3==0 || $i==0){
	             $pdf->AddPage();
	     }

      

         }else{
               $pdf->SetFont('helvetica', '', 12);
               
               if(strcmp($LISTA_PREGUNTAS['Preg']['seccion'][$i],"competencia")==0 && $texto_impreso1!=1){
                  $texto_subseccion = "PERCEPCIÓN GLOBAL DE LA EVALUACIÓN DE COMPETENCIAS";
                  $pdf->writeHTML($texto_subseccion, true, false, true, true, '');
                  $pdf->Ln(5, false); 
                  $texto_impreso1 = 1;
               }else{
                  if(strcmp($LISTA_PREGUNTAS['Preg']['seccion'][$i],"factor")==0 && $texto_impreso2!=1){
                     $texto_subseccion = "PERCEPCIÓN GLOBAL DE LA EVALUACIÓN DE DESEMPEÑO";
                     $pdf->writeHTML($texto_subseccion, true, false, true, true, '');
                     $pdf->Ln(5, false); 
                     $texto_impreso2 = 1;
                  }
               }
                
               $pdf->writeHTML($htmlPregunta, true, false, true, true, '');
               
               $pdf->Ln(5, false);
               
               $pdf->writeHTMLCell(0, 20, '', '', '', 1, 1, 0, true, '', true);
               
               $pdf->Ln(5, false);
         }
         
      }
      
      //-----------------------------------------------------------------------------------------

      $pdf->AddPage();      

      $pdf->Ln(10, false);
      
      $pdf->Cell('', '', 'CONFORMACIÓN DEL PROCESO DE EVALUACIÓN', 0, 1, 'L', false, '', 0, false, 'T', 'C');
      
      $pdf->Ln(5, false);
      
      //Tabla de Datos del Supervisor Inmediato
      $tbl ='
         <table border="1" cellpadding="4" cellspacing="2" align="center">
            <tr nobr="true" align="left">
               <th colspan="2" bgcolor="#cccccc">Supervisor Inmediato</th>
            </tr>
            <tr nobr="true" align="left">
               <td><small>Nombre y Apellidos: '.$LISTA_EVALUADORES['Eva']['nombre'][$ind_sup].'</small>
                  <br/>
                  <small>Cargo: '.$LISTA_EVALUADORES['Eva']['nombre_cargo'][$ind_sup].'</small>
                  <br/>
                  <small>Unidad: '.$LISTA_EVALUADORES['Eva']['nombre_unidad'][$ind_sup].'</small>
                  <br/><br/>
                  __________________
                  <br/>
                  <small >Firma y Sello&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Fecha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                  </small>
               </td>
               <td><small>Comentarios:</small></td>
            </tr>
         </table>';
         
      $pdf->writeHTML($tbl, true, false, false, true, '');
      
      $pdf->Ln(10, false);
      
            //Tabla de Datos del Supervisor Jerárquico
      $tbl ='
         <table border="1" cellpadding="4" cellspacing="2" align="center">
            <tr nobr="true" align="left">
               <th colspan="2" bgcolor="#cccccc">Supervisor Jerárquico</th>
            </tr>
            <tr nobr="true" align="left">
               <td><small>Nombre y Apellidos: '.$SUPERVISOR_JER['nombre'].'</small>
                  <br/>
                  <small>Cargo: '.$SUPERVISOR_JER['nombre_cargo'].'</small>
                  <br/>
                  <small>Unidad: '.$SUPERVISOR_JER['nombre_unidad'].'</small>
                  <br/><br/>
                  __________________
                  <br/>
                  <small >Firma y Sello&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Fecha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                  </small>
               </td>
               <td><small>Comentarios:</small></td>
            </tr>
         </table>';
      
         $pdf->writeHTML($tbl, true, false, false, true, '');
      
   }
    
   //--------------------------------------------------------------------------------------------

   // cleaning the buffer before Output()
   ob_clean();

   // Close and output PDF document
   // This method has several options, check the source code documentation for more information.
   $pdf->Output('prueba.pdf', 'I');
   //============================================================+
   // END OF FILE
   //============================================================+
php?>
