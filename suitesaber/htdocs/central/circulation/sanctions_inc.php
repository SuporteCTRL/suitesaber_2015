<?php

require_once("fecha_de_devolucion.php");

function Sanciones($fecha_d,$atraso,$cod_usuario,$inventario,$politica){
global $Wxis,$xWxis,$db_path,$locales,$arrHttp,$msgstr;
	$p=explode('|',$politica);
	$multa=trim($p[7]);
	$multa_reserva=trim($p[8]);
	$dias=trim($p[9]);
	$dias_reserva=trim($p[10]);
	$sancion="";
	$ValorCapturado="";
	if ($multa!=0 and $multa!="") $sancion="M";
	if ($dias!=0 and $dias!="") $sancion="S";
	if ($sancion=="") return;
	switch ($sancion){
		case "M":
			$tipor="M";                                     		//v1
			$status="0";	                                  		//v10
			//cod_usuario                                     		//v20
  			$concepto=$msgstr["fine"]." (".$inventario.")";    		//v40
     		$fecha=date("Ymd");              						//v30
       		$monto=$atraso*$p[7]*$locales["fine"];                		//v50
       		$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0050$monto\n";
			break;
		case "S":
			$tipor="S";                      						//v1
			$status="0";	                 						//v10
			//cod_usuario                    						//v20
  			$concepto=$msgstr["suspend"]." : ".$msgstr["overdue"]." (".$inventario.")";    //v40
     		$fecha=date("Ymd");              						//v30
     		$lapso=$atraso*$p[9];
     		$fecha_v=FechaDevolucion($lapso,"D");                 	//v60
     		$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0060$fecha\n";
			break;
		default:
			return;
			break;
	}
//	print "<xmp>$ValorCapturado</xmp>";
	if ($ValorCapturado!=""){
		$ValorCapturado=urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar.xis";
   		$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
        include("../common/wxis_llamar.php");
//        foreach ($contenido as $value) echo "$value<br>";
	}
}
?>