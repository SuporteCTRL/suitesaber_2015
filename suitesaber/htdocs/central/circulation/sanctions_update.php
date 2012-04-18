<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      sanctions_update.php
 * @desc:      Update sanctions in database
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *  
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *  
 * == END LICENSE ==
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
// Se lee el calendario de días hábiles
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

// se calcula la fecha de vencimiento de la sanción sumando los días de suspensión
if ($arrHttp["type"]=="S"){

}
switch ($arrHttp["type"]){
	case "M":
		$tipor="M";                                     		//v1
		$status="0";	                                  		//v10
		$cod_usuario=$arrHttp["usuario"];                  		//v20
 		$concepto=$arrHttp["reason"];    						//v40
    	$fecha=$fecha_desde;	              					//v30
      	$monto=$arrHttp["units"]*$p[7]*$locales["fine"];        //v50
      	$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0050$monto\n";
      	if (isset($arrHttp["comments"])) $ValorCapturado.="0100".$arrHttp["comments"];
		break;
	case "S":
	// se calcula la fecha en que vence la suspensión
		$exp_date=mktime(0,0,0,$mes,$dia+$arrHttp["units"],$year);
		$exp_date=date("Ymd",$exp_date);
		$mes=substr($exp_date,4,2);
		$dia=substr($exp_date,6,2);
	// Se traslada el día al primer día hábil
		$d=0;
	    $df=0;
	    $diaFeriado=substr($feriados[$mes],$dia-1,1);
	    $dia_sem="";
	    $ds=date("w",strtotime($exp_date));
	    if (!isset($locales[$ds]["from"])) $dia_sem="F";
	 	$date=strtotime(exp_date);
	// se determinan los días feriados
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
    	$ValorCapturado="0001$tipor\n0010$status\n0020$cod_usuario\n0030$fecha\n0040$concepto\n0060$fecha_v\n";
    	if (isset($arrHttp["comments"])) $ValorCapturado.="0100".$arrHttp["comments"];
		break;
}
$ValorCapturado=urlencode($ValorCapturado);
$IsisScript=$xWxis."actualizar.xis";
$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
include("../common/wxis_llamar.php");

header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$arrHttp["usuario"]);
?>
