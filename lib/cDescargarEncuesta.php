<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

    // Include the main TCPDF library (search for installation path).
   require_once('tcpdf/tcpdf.php');
   require_once('tcpdf/examples/tcpdf_include.php');
   
   
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
      $sql.="FROM FAMILIA_CARGO WHERE id='".$_GET['id_fam']."'";
      $atts = array("nombre");
      $FAMILIA_CARGO_EVALUADO= obtenerDatos($sql, $conexion, $atts, "Fam");   
      
      //-----------------------------------------------------------------------------------------
      // Añade una página
      $pdf->AddPage();
      
      $pdf->SetFont('helvetica', 'BI', 12);
         
      $pdf->Cell('', '', 'EVALUACIÓN DEL DESEMPEÑO', 0, 1, 'C', false, '', 0, false, 'T', 'C');       
      $pdf->Cell('', '', 'PERSONAL SUPERVISADO', 0, 1, 'C', false, '', 0, false, 'T', 'C');  
        
      $texto_encuesta=$FAMILIA_CARGO_EVALUADO['Fam']['nombre'][0];
      $pdf->Cell('', '', $texto_encuesta, 0, 1, 'C', false, '', 0, false, 'T', 'C'); 
         
      $pdf->Cell('', '', 'PROCESO DE EVALUACIÓN DEFINITIVO __________________', 0, 1, 'C', false, '', 0, false, 'T', 'C');  
      
      $pdf->Ln(5, false);
      
      $pdf->SetFont('helvetica', '', 12);
      
      //Tabla de Datos del Trabajador
      $tbl ='
         <table border="1" cellpadding="4" cellspacing="2" align="center">
            <tr nobr="true">
               <th colspan="2" bgcolor="#cccccc"> DATOS DEL TRABAJADOR</th>
            </tr>
            <tr nobr="true" align="left">
               <td><small>1.1 Apellidos y Nombres:</small></td>
               <td><small>1.2 No. Cédula de Identidad:</small></td>
            </tr>
            <tr nobr="true" align="left">
               <td><small>1.3 Cargo:</small></td>
               <td><small>1.4 Ubicación:</small></td>
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
            $texto_seccion="I. INSTRUCCIÓN GENERAL<br/>
                           <br/>
                           El propósito principal de esta parte de la evaluación es recolectar evidencias sobre conductas asociadas al desempeño
                           profesional de una persona, con la intención de construir un juicio constructivo sobre su nivel de desarrollo en relación con un
                           perfil profesional. Al mismo tiempo, identificar aquellas áreas de desempeño que deban ser fortalecidas, utilizando programas
                           de formación y adiestramiento para llegar al nivel de competencia requerido.";
                           
            $texto_seccion.="Si usted está realizando su auto-evaluación, construya mentalmente las oraciones en primera persona. por ejemplo, si la
                           conducta es: &quot;Aplicar normas y procedimientos&quot; al hacer el trabajo, en primera persona diría: &quot;¿Yo aplico normas y
                           procedimientos al hacer el trabajo?&quot;. Lo mismo hará cuando evalúe a terceros, por ejemplo, diría: &quot;¿él o ella
                           aplica normas y procedimientos al hacer el trabajo?&quot;.<br/>
                           <br/>
                           <br/>
                           II. ESCALA DE EVALUACIÓN DE COMPETENCIAS<br/>
                           <br/>
                           Para evaluar aparece una lista de conductas relacionadas a cada competencia. Usted deberá marcar el nivel de frecuencia
                           que ha observado dicha conducta para el período de evaluación. Utilice la siguiente escala:<br/><br/> 
                           Nunca: No se observa, no se aplica o no se pone en práctica una conducta requerida. <br/>
                           Pocas veces: La conducta evaluada se pone en práctica ocasionalmente y se observan largos períodos de ausencia de la misma,
                           en los momentos en que requiere ser observada o es pertinente. <br/>
                           Casi siempre: La conducta se observa casi continuamente en los momentos requeridos.<br/>
                           Siempre: La conducta se observa fija, estable y el individuo la realiza todo el tiempo que se requiere.
                           <br/><br/>
                           <br/><br/>
                           III. EVALUACIÓN DE COMPETENCIAS";
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
                  <td width="60%">'.$htmlPregunta.'</td>
                  <td width="10%">Nunca</td>
                  <td width="10%">Pocas veces</td>
                  <td width="10%">Casi siempre</td>
                  <td width="10%">Siempre</td>
               </tr>';
         
            for($j=0; $j<$LISTA_SUBPREGUNTAS[max_res]; $j++){
               $htmlSubPregunta =$LISTA_SUBPREGUNTAS['Preg']['titulo'][$j];
               
               $tbl.='
                  <tr nobr="true">
                     <td>'.$LISTA_SUBPREGUNTAS['Preg']['titulo'][$j].'</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>';
            }
            
            $tbl.='</table>';
            
            $pdf->writeHTML($tbl, true, false, false, true, '');
            
            // Añade una página
            $pdf->AddPage();
         
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
               <td><small>Nombre y Apellidos:</small>
                  <br/>
                  <small>Cargo:</small>
                  <br/>
                  <small>Ubicación:</small>
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
               <td><small>Nombre y Apellidos:</small>
                  <br/>
                  <small>Cargo:</small>
                  <br/>
                  <small>Ubicación:</small>
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