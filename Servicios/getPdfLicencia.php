<?php

include("../funciones.global.inc.php");
include("../funciones.inc.php");
include("../funciones.inc.firma.php");
$db=genera_adodb();
include ('../libs/phppdf/class.ezpdf.php');
verifica_sesion(false);
$nro_licencia=substr($_REQUEST["nro_licencia"],4,6);
$cod_repart=substr($_REQUEST["nro_licencia"],0,4);
$licencia=retorna_licencia($db,$nro_licencia,$cod_repart);
$datos_m=retorna_datos_medico($db,$licencia[0]["medico"],$cod_repart);
$tipo_lic=retorna_tablas($db,1,"S");
$tipo_reposo=retorna_tablas($db,2,"S");
$tipo_reposo_parcial=retorna_tablas($db,3,"S");
$lugar_reposo=retorna_tablas($db,4,"S");
$tipo_categoria=retorna_tablas($db,5,"S");
$tipo_subcategoria=retorna_tablas($db,6,"S");
$sn=array();
$sn["1"]="SI";
$sn["0"]="NO";
$tipo_prof=array();
$tipo_prof["1"]="MEDICO";
$tipo_prof["2"]="DENTISTA";
$tipo_prof["3"]="MATRONA";

$ano = date('Y');
$hoja = 'LETTER';
$tipo = 'portrait';
$tam_font = 8;  
$file="licencia_".$_REQUEST["nro_licencia"].".pdf";
$pdf = new Cezpdf($hoja,$tipo);
set_time_limit(3000);
$pdf ->ezSetMargins(30,50,30,30);
$pdf ->selectFont('../libs/phppdf/fonts/Helvetica.afm');
$pdf->ezStartPageNumbers(320,20,10,'','Pag. {PAGENUM} de {TOTALPAGENUM}',1);
$pdf->ezText("<b> LICENCIA MEDICA NRO : ".$_REQUEST["nro_licencia"]."</b>",12,array('justification' => 'right'));
$pdf->ezText("\n",8,array('justification'=>'left'));
$pdf->ezText("<b> SECCION A : </b> USO Y RESPONSABILIDAD EXCLUSIVA DEL PROFESIONAL",8,array('justification' => 'left'));
$pdf->ezText("1.- IDENTIFICACION DEL FUNCIONARIO",8,array('justification' => 'left'));
$filas=array();
$filas_cabeza=array('colu1' => "",'colu2'  => "",'colu3'  => "");
 $filas[] =  array('colu1' => "GRADO : <b>".$licencia[0]["grado"] ."</b>",
                   'colu2' => "RUN : <b>".$licencia[0]["run"]."-".$licencia[0]["dv_run"]."</b>",
                   'colu3' => "NPI : <b>".$licencia[0]["npi"]."</b>"
                  );
$filas[] =  array('colu1' => "<b>".$licencia[0]["apellido_paterno"]."</b>\nAPELLIDO PATERNO",
                   'colu2' =>"<b>". $licencia[0]["apellido_materno"]."</b>\nAPELLIDO MATERNO",
                   'colu3' =>"<b>". $licencia[0]["nombres"]."</b>\nNOMBRES"
                  );
 $filas[] =  array('colu1' => "EDAD : <b>".$licencia[0]["edad"]."</b>",
                   'colu2' => "SEXO : <b>".$licencia[0]["ind_sexo"]."</b>",
                   'colu3' => ""
                  );
$filas[] =  array('colu1' => "<b>".$licencia[0]["fec_emision"]."</b>\nFECHA EMISION LICENCIA",
                   'colu2' => "<b>".$licencia[0]["fec_inicio_reposo"]."</b>\nFECHA INICIO DE REPOSO",
                   'colu3' => "<b>".$licencia[0]["fec_termino_reposo"]."</b>\nFECHA TERMINO DE REPOSO"
                  );
$filas[] =  array('colu1' => "NRO DE DIAS : <b>".$licencia[0]["dias_reposo"]."</b>",
                   'colu2' => "<b>".$licencia[0]["dias_reposo_pal"]."</b>\nNRO DE DIAS EN PALABRAS",
                   'colu3' => ""
                  );
$filas[] =  array('colu1' => "REPARTICION : <b>".$licencia[0]["reparticion"]."</b>",
		  'colu2' => "",
                   'colu3' => ""
                  );
$pdf->ezTable($filas,$filas_cabeza,null,
		      array('fontSize' => 8,
			     'titleFontSize' => 8,
			     'showLines' => '0',
                             'showHeadings' => '0',
			     'shaded' => '2',
			    'shadeCol' => array(0.9,0.9,0.9),
			    'shadeCol2' => array(0.9,0.9,0.9), 
			    'cols' => array('colu1' => array('justification'=>'center' ,'width' =>180),
					    'colu2' => array('justification'=>'center', 'width' =>180),
                                            'colu3' => array('justification'=>'center', 'width' =>180)   
					      )
			     )
			     );
$pdf->ezText("2.- IDENTIFICACION DEL HIJO.Solo para licencias por enfermedad grave hijo menor de un anno y post natal",8,array('justification' => 'left'));
$filas=array();
$filas_cabeza=array('colu1' => "",'colu2'  => "",'colu3'  => "");
$filas[] =  array('colu1' => $licencia[0]["fec_nac_hijo"]."\nFECHA DE NACIMIENTO",
                   'colu2' => "",
                   'colu3' => "RUN : ".$licencia[0]["run_hijo"]
                  );
$filas[] =  array('colu1' => $licencia[0]["apellido_paterno_hijo"]."\nAPELLIDO PATERNO",
                   'colu2' => $licencia[0]["apellido_materno_hijo"]."\nAPELLIDO MATERNO",
                   'colu3' => $licencia[0]["nombres_hijo"]."\nNOMBRES"
                  );
$pdf->ezTable($filas,$filas_cabeza,null,
		      array('fontSize' => 8,
			     'titleFontSize' => 8,
			     'showLines' => '0',
                             'showHeadings' => '0',
			     'shaded' => '2',
			    'shadeCol' => array(0.9,0.9,0.9),
			    'shadeCol2' => array(0.9,0.9,0.9), 
			    'cols' => array('colu1' => array('justification'=>'center' ,'width' =>180),
					    'colu2' => array('justification'=>'center', 'width' =>180),
                                            'colu3' => array('justification'=>'center', 'width' =>180)   
					      )
			     )
			     );
$filas=array();
$filas_cabeza=array('colu1' => "3.- TIPO DE LICENCIA",'colu2'  => "4.- CARACTERISTICAS DEL REPOSO");
$filas[] =  array('colu1' => $tipo_lic[$licencia[0]["cod_tipo_lic"]],
                   'colu2' => $tipo_reposo[$licencia[0]["cod_tipo_reposo"]]."\n".$tipo_reposo_parcial[$licencia[0]["cod_tipo_reposo_parcial"]]
                  );
$filas[] =  array('colu1' => "RECUPERABILIDAD LABORAL : ".$sn[$licencia[0]["sn_rec_laboral"]]."  INICIA TRAMITE DE INVALIDEZ : ".$sn[$licencia[0]["sn_inicia_tram_inval"]],
                   'colu2' => $lugar_reposo[$licencia[0]["cod_lugar_reposo"]]
                  );
$filas[] =  array('colu1' => "FECHA DEL ACCIDENTE DEL TRABAJO O DEL TRAYECTO : ".$licencia[0]["fec_accidente_trab_tray"].
                             "\n\nHORA Y MINUTO DEL ACCIDENTE DEL TRABAJO O DEL TRAYECTO : ".$licencia[0]["hora_accidente_trab_tray"].":".$licencia[0]["minuto_accidente_trab_tray"]." TRAYECTO : ".$sn[$licencia[0]["sn_trayecto"]],
                   'colu2' => "JUSTIFICAR SI ES OTRO : ".$licencia[0]["otro_lugar_reposo"]
                  );
$filas[] =  array('colu1' => "FECHA DE LA CONCEPCION : ".$licencia[0]["fec_concepcion"],
                   'colu2' => "DIRECCION;CALLE;NRO;DEPTO;COMUNA : ".$licencia[0]["direccion"]."\nTELEFONO (PERSONAL O DE CONTACTO) : ".$licencia[0]["telefono"]
                  );
$pdf->ezTable($filas,$filas_cabeza,null,
		      array('fontSize' => 8,
			     'titleFontSize' => 8,
			     'showLines' => '1',
                             'showHeadings' => '1',
			     'shaded' => '2',
			    'shadeCol' => array(0.9,0.9,0.9),
			    'shadeCol2' => array(0.9,0.9,0.9), 
			    'cols' => array('colu1' => array('justification'=>'center' ,'width' =>300),
					    'colu2' => array('justification'=>'center', 'width' =>240)

					      )
			     )
			     );
$filas=array();
$filas_cabeza=array('colu1' => "5.- TIPO DE CATEGORIA",'colu2'  => "");
$subcateg="";
if($licencia[0]["espec"]==1){
  $subcateg="\nSUB CATEGORIA : ".$tipo_subcategoria[$licencia[0]["cod_subcategoria"]];
}
$filas[] =  array('colu1' => $tipo_categoria[$licencia[0]["cod_tipo_categoria"]]."\nCATEGORIA EN LETRAS : ".$licencia[0]["categoria_pal"].$subcateg,
                   'colu2' => "\n\n\n\n\n\n\n__________________________________________\nFIRMA DEL TRABAJADOR"
                  );
$pdf->ezTable($filas,$filas_cabeza,null,
		      array('fontSize' => 8,
			     'titleFontSize' => 8,
			     'showLines' => '0',
                             'showHeadings' => '1',
			     'shaded' => '2',
			    'shadeCol' => array(0.9,0.9,0.9),
			    'shadeCol2' => array(0.9,0.9,0.9), 
			    'cols' => array('colu1' => array('justification'=>'center' ,'width' =>300),
					    'colu2' => array('justification'=>'center', 'width' =>240)

					      )
			     )
			     );
$pdf->ezText("6.- IDENTIFICACION DEL PROFESIONAL",8,array('justification' => 'left'));
$filas=array();
$filas_cabeza=array('colu1' => "",'colu2'  => "",'colu3'  => "");
$filas[] =  array('colu1' => "<b>".$datos_m["apellido_paterno"]."</b>\nAPELLIDO PATERNO",
                   'colu2' =>"<b>". $datos_m["apellido_materno"]."</b>\nAPELLIDO MATERNO",
                   'colu3' =>"<b>". $datos_m["nombres"]."</b>\nNOMBRES"
                  );
$filas[] =  array('colu1' => "<b>".$datos_m["especialidad"]."</b>\nESPECIALIDAD",
                   'colu2' => "<b>".$tipo_prof[$datos_m["tipo_usuario"]]."</b>\nTIPO PROFESIONAL",
                   'colu3' => ""
                  );
$filas[] =  array('colu1' => "<b>".$datos_m["email"]."</b>\nCORREO ELECTRONICO",
		  'colu2' => "",
                   'colu3' =>"<b>". $datos_m["direccion"]."</b>\nDIRECCION"
                  );
$filas[] =  array('colu1' =>  "<b>".$datos_m["fono"]."</b>\nTELEFONO",
		  'colu2' =>  "<b>".$datos_m["fax"]."</b>\nFAX",
                   'colu3' => ""
                  );
$pdf->ezTable($filas,$filas_cabeza,null,
		      array('fontSize' => 8,
			     'titleFontSize' => 8,
			     'showLines' => '0',
                             'showHeadings' => '0',
			     'shaded' => '2',
			    'shadeCol' => array(0.9,0.9,0.9),
			    'shadeCol2' => array(0.9,0.9,0.9), 
			    'cols' => array('colu1' => array('justification'=>'center' ,'width' =>180),
					    'colu2' => array('justification'=>'center', 'width' =>180),
                                            'colu3' => array('justification'=>'center', 'width' =>180)   
					      )
			     )
			     );
$pdf->ezNewPage();
$pdf->ezText("<b> SECCION B : </b> USO Y RESPONSABILIDAD EXCLUSIVA DEL SERVICIO DE ORIENTACION MEDICO Y ESTADISTICO DEL HOSPITAL",8,array('justification' => 'left'));
$pdf->ezText("7.- DIAGNOSTICO",8,array('justification' => 'left'));
if(count($licencia[0]["diag_pri"])>0){
  $pdf->ezText("<b> Diagnosticos Principales:</b>",8,array('justification' => 'left'));
  $pdf->ezText("\n",2,array('justification'=>'left'));
  $filas_cabeza=array('cod' => "Codigo",
		      'descrip'  => "Descripcion");
  $pdf->ezTable(
		$licencia[0]["diag_pri"],$filas_cabeza,null,
		array('fontSize' => 8,
		      'titleFontSize' => 8,
		      'showLines' => '2',
		      'showHeadings' => '1',
		      'shaded' => '0',
		      'shadeCol2' => array(1,1,0),
		      'cols' => array('cod' => array('justification'=>'center' ,'width' =>100),
				      'descrip' => array('justification'=>'left', 'width' =>440)
				      )
                                       
		      )
		);
 }
$pdf->ezText("\n",8,array('justification'=>'left'));
if(count($licencia[0]["diag_sec"])>0){
  $pdf->ezText("<b> Diagnosticos Secundarios:</b>",8,array('justification' => 'left'));
  $pdf->ezText("\n",2,array('justification'=>'left'));
  $filas_cabeza=array('cod' => "Codigo",
		      'descrip'  => "Descripcion");
  $pdf->ezTable(
		$licencia[0]["diag_sec"],$filas_cabeza,null,
		array('fontSize' => 8,
		      'titleFontSize' => 8,
		      'showLines' => '2',
		      'showHeadings' => '1',
		      'shaded' => '0',
		      'shadeCol2' => array(1,1,0),
		      'cols' => array('cod' => array('justification'=>'center' ,'width' =>100),
				      'descrip' => array('justification'=>'left', 'width' =>440)
				      )
                                       
		      )
		);
 }
$pdf->ezText("\n",8,array('justification'=>'left'));
$pdf->ezText("<b> ANTECEDENTES CLINICOS : </b>\n".$licencia[0]["antecedentes_clinicos"],8,array('justification' => 'center'));
$pdf->ezText("\n",8,array('justification'=>'left'));
$pdf->ezText("<b> EXAMENES DE APOYO DIAGNOSTICO : </b>\n".$licencia[0]["examenes_apoyo"],8,array('justification' => 'center'));
$pdf->ezText("\n",8,array('justification'=>'left'));
$pdf->ezText("<b> INDICACIONES : </b>\n".$licencia[0]["indicaciones"],8,array('justification' => 'center'));
$options=array();
$options['Content-Disposition']=$file;
$db->disconnect();
$pdf->ezStream($options);
?>
