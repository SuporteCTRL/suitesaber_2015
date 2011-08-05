<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      usuario.php
 * @desc:      Routine to store loans, renewals and returns
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
// rutina para almacenar los préstamos otorgados,las renovaciones y las devoluciones
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
// se lee la configuración local
include("locales_read.php");
// se leen las politicas de préstamo
include("loanobjects_read.php");
// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");

$valortag = Array();
include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

include ('../dataentry/leerregistroisispft.php');
include("../common/header.php");

Function Iso2Fecha($fecha){
	$f=substr($fecha,6,2)."/".substr($fecha,4,2)."/".substr($fecha,0,4);
	return $f;
}
/*
// se determina si el préstamo está vencido
function compareDate ($FechaP){
global $locales,$config_date_format;

//Se convierte la fecha a formato ISO (yyyymmaa) utilizando el formato de fecha local
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
	$exp_date=$year."-".$mes."-".$dia;
	$todays_date = date("Y-m-d");
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	return $diff;

}//end Compare Date
*/

// ------------------------------------------------------



echo "<body>";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">
		<a href="javascript:history.back()" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/prestamo_procesar.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "        		<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/prestamo_procesar.html target=_blank>".$msgstr["edhlp"]."</a>";
  echo "<font color=white>&nbsp; &nbsp; Script: usuario_prestamos_presentar.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<form name=ecta>
<?php

include("ec_include.php");  //se incluye el procedimiento para leer el usuario y los préstamos pendientes
echo $ec_output;
if ($cont=="S" and ($reservas_p==0 or $posicion_cola==1)){
	echo " <a href=usuario_prestamos_prestar.php?usuario=".$arrHttp["usuario"]."&inventario=".$arrHttp["inventory"]."&signatura=".$signatura."&reserva=$posicion_cola class=class=\"submit\"><dd><h4>".$msg_1.": </font>".$msgstr["inventory"].": ".$arrHttp["inventory"]."</h4></a>";
}
?>
</form></div></div>
<?php include("../common/footer.php");?>
</body>
</html>

