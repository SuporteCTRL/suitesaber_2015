<?php
/**
 *Editado em 18/12/2012
 *Roger C. Guilherme
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
//die;
// se leen los valores locales para convertir la fecha a ISO
include("locales_read.php");
// Se lee el calendario de d�as h�biles
include("calendario_read.php");

$FechaP=$arrHttp["date"];
$df=explode('/',$config_date_format);
switch ($df[0]){
	case "DD":
		$dia=substr($FechaP,0,2);
		break;
	case "MM":
		$mes=substr($FechaP,0,2);
		break;
}
switch ($df[1]){
	case "DD":
		$dia=substr($FechaP,3,2);
		break;
	case "MM":
		$mes=substr($FechaP,3,2);
		break;
}
$year=substr($FechaP,6,4);
$fecha_desde= $year.$mes.$dia;

// se calcula la fecha de vencimiento de la sanci�n sumando los d�as de suspensi�n
if ($arrHttp["type"]=="S"){

}
switch ($arrHttp["type"]){
	case "M":
		$tipor="M";                                     		//v1
		$status="0";	                                  		//v10
		$cod_usuario=$arrHttp["usuario"];                  		//v20
 		$concepto=$arrHttp["reason"];    						//v40
 		$monto=str_replace(",","","$arrHttp[units]");
 		$fecha=$fecha_desde;	              					//v30
      	//$monto=$arrHttp["units"]*$p[7]*$locales["fine"];        //v50
      	$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0050$monto\n";
      	if (isset($arrHttp["comments"])) $ValorCapturado.="0100".$arrHttp["comments"];
		break;
	case "S":
	// se calcula la fecha en que vence la suspensi�n
		$exp_date=mktime(0,0,0,$mes,$dia+$arrHttp["units"],$year);
		$exp_date=date("Ymd",$exp_date);
		$mes=substr($exp_date,4,2);
		$dia=substr($exp_date,6,2);
	// Se traslada el d�a al primer d�a h�bil
		$d=0;
	    $df=0;
	    $diaFeriado=substr($feriados[$mes],$dia-1,1);
	    $dia_sem="";
	    $ds=date("w",strtotime($exp_date));
	    if (!isset($locales[$ds]["from"])) $dia_sem="F";
	 	$date=strtotime(exp_date);
	// se determinan los d�as feriados
	    while ($diaFeriado=="F" or $dia_sem=="F"){
	    	$df++;
	    	$exp_date_01=mktime(0,0,0,$mes,$dia+1,$year);
	    	$exp_date=date("Ymd",$exp_date_01);
			$mes=substr($exp_date,4,2)*1;
			$dia=substr($exp_date,6,2)*1;
			$year=substr($exp_date,0,4);
			$diaFeriado=trim(substr($feriados[$mes],$dia-1,1));
	    	$dia_sem="";
	    	if ($diaFeriado==""){
	    		$ds=date("w",$exp_date_01);
	    		if (!isset($locales[$ds]["from"])) $dia_sem="F";
	    	}
	    }
		$tipor="S";                      						//v1
		$status="0";	                 						//v10
		$cod_usuario=$arrHttp["usuario"]; 						//v20
 		$concepto=$arrHttp["reason"];    						//v40
    	$fecha=$fecha_desde;	          						//v30
    	$fecha_v=$exp_date;	                 					//v60
    	$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0050$monto\n0060$fecha_v\n";
    	if (isset($arrHttp["comments"])) $ValorCapturado.="0100".$arrHttp["comments"];
		break;
}
$ValorCapturado=urlencode($ValorCapturado);
$IsisScript=$xWxis."actualizar.xis";
$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
include("../common/wxis_llamar.php");

header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$arrHttp["usuario"]);
?>
