<?php
/**
 *Editado em 18/12/2012
 *Roger C. Guilherme
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CIRC_CIRCALL"])  and (!isset($_SESSION["permiso"]["CIRC_DELSUS"])or !isset($_SESSION["permiso"]["CIRC_DELFINE"]))){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");

$lang=$_SESSION["lang"];

include("../lang/prestamo.php");

include("../common/get_post.php");
$Mfn=explode('|',$arrHttp["Mfn"]);
foreach ($Mfn as $value) {
	if (!empty($value)) {
		$ValorCapturado="00102";
		$ValorCapturado=urlencode($ValorCapturado);
		$IsisScript=$xWxis."actualizar.xis";
		$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=".$value."&Opcion=actualizar&ValorCapturado=".$ValorCapturado;
    	include("../common/wxis_llamar.php");
    }
}
header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$arrHttp["usuario"]);
?>