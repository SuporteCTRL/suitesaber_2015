<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      menu_modificardb.php
 * @desc:      Amending the setting of the database
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
$lang=$_SESSION["lang"];
include("../config.php");

// ARCHIVOS DE LENGUAJE
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// VERIFICACION DE LA PERMISOLOTIA
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDEF"])){

}else{
	die;
}

// LECTURA DE LAS VARIABLES GET O POST
include("../common/get_post.php");

// EXTRACCIÓN DEL NOMBRE DE LA BASE DE DATOS
if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// INCLUSION DE LOS SCRIPTS
?>
<script src=../dataentry/js/lr_trim.js></script>
<script languaje=javascript>

function Update(Option){
	if (document.update_base.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "fdt":
			document.update_base.action="fdt.php"
			document.update_base.type.value="bd"
			<?php if (isset($arrHttp["encabezado"])) echo "document.update_base.encabezado.value=\"s\"\n"?>
			break;
		case "leader":
			document.update_base.action="fdt.php"
			document.update_base.type.value="leader.fdt"
			<?php if (isset($arrHttp["encabezado"])) echo "document.update_base.encabezado.value=\"s\"\n"?>
			break;
		case "fdt_new":
			document.update_base.action="fdt_short_a.php"
			document.update_base.type.value="bd"
			<?php if (isset($arrHttp["encabezado"])) echo "document.update_base.encabezado.value=\"s\"\n"?>
			break;
		case "fst":
			document.update_base.action="fst.php"
			break;
		case "fmt":
			document.update_base.action="fmt.php"
			break;
		case "pft":
			document.update_base.action="pft.php"
			break;
		case "typeofrecs":
			<?php
			$archivo=$path_db.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecs.tab";
			if (!file_exists($archivo))  $archivo=$path_db.$arrHttp["base"]."/def/".$lang_db."/typeofrecs.tab";
			if (file_exists($archivo))
				$script="typeofrecs_edit.php";
			else
				$script="typeofrecs_edit.php";
			echo "\ndocument.update_base.action=\"$script\"\n";
			?>
			break;
		case "fixedfield":
			document.update_base.action="typeofrecs_marc_edit.php"
			break;
		case "fixedmarc":
			document.update_base.action="fixed_marc.php"
			break;
		case "recval":
			document.update_base.action="typeofrecs.php"
			break;
		case "bases":
			document.update_base.action="databases_list.php"
			break;
		case "par":
			document.update_base.action="editpar.php"
			break;
		case "search":
			document.update_base.action="advancedsearch.php"
			break;
		case "IAH":
			document.update_base.action="iah_edit_db.php"
			break
		case "stats_var":
			document.update_base.action="../statistics/config_vars.php"
			break
		case "stats_tab":
			document.update_base.action="../statistics/tables_cfg.php"
			break
        case "help":
        	document.update_base.action="help_ed.php"
	}
	document.update_base.submit()
}

</script>
<body>

<?
// ENCABEZAMIENTO DE LA PÁGINA
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "<div class=\"sectionInfo\"><div class=\"language\">";
	
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<span><strong>". $msgstr["back"]."</strong></span></a> <br />";
}	
	
echo "</div></div>
		<div class=\"breadcrumb\">";
		echo	"<h3>$msgstr[updbdef]:$arrHttp[base]</h3>";
echo		"</div><div class=\"actions\">";
		

echo	"</div>";

// para verificar si en la FDT tiene el campo LDR Definido y ver si se presenta el tipo de registro MARC
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt"))
	$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt");
else
	$fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt");
$ldr="";
foreach ($fp as $value){
	$value=trim($value);
	if (!empty($value)) {
		$fdt=explode('|',$value);
		if ($fdt[0]=="LDR"){
			$ldr="s";
			break;
		}
	}
}

// AYUDA EN CONTEXTO E IDENTIFICACIÓN DEL SCRIPT QUE SE ESTÁ EJECUTANDO
// OPCIONES DEL MENU
 ?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/admin.html target=_blank><?php echo $msgstr["help"]?></a> <br />&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/admin.html target=_blank>".$msgstr["edhlp"]."</a> <br />";
echo "<font color=white>&nbsp; &nbsp; Script: menu_modificardb.php";
?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
</center>
<table  align=center>
	<tr>
		<td align="center">
			<form name=update_base onSubmit="return false">
			<input type=hidden name=Opcion value=update>
			<input type=hidden name=type value="">
			<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
			<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>

			<a id="botoes" style="width: 300px;" href='javascript:Update("fdt")'><?php echo $msgstr["fdt"]?></a> <br />
			<a id="botoes" style="width: 300px;"  href='javascript:Update("fdt_new")'><?php echo $msgstr["fdt_compressed"]?></a> <br />
			<?php
// SI ES UN REGISTRO MARC SE INCLUYE LA OPCION PARA MANEJO DE LOS TIPOS DE REGISTRO DE ACUERDO AL LEADER
			if ($ldr=="s" ){
				echo "<a id=\"botoes\" style=\"width: 300px;\"  href=javascript:Update(\"leader\")>". $msgstr["ft_ldr"]."</a> <br />";
				echo "<a id=\"botoes\" style=\"width: 300px;\"  href=javascript:Update(\"fixedmarc\")>".$msgstr["typeofrecord_ff"]."</a> <br />";
				echo "<a id=\"botoes\" style=\"width: 300px;\"  href=javascript:Update(\"fixedfield\")>". $msgstr["typeofrecord_aw"]."</a> <br />";
			}
			?>
			<a id=botoes style="width: 300px;"  href=javascript:Update("fst")><?php echo $msgstr["fst"]?></a> <br />
			<a  id=botoes style="width: 300px;"  href=javascript:Update("fmt")><?php echo $msgstr["fmt"]?></a> <br />
			<a id=botoes style="width: 300px;"  href=javascript:Update("pft")><?php echo $msgstr["pft"]?></a> <br />
			<?php
			if (!isset($ldr) or $ldr!="s" )
// SI NO ES UN REGISTRO MARC SE INCLUYE EL MANEJO DE LOS TIPOS DE REGISTRO NO MARC
			    echo "<a style=\"width: 300px;\"  id=botoes href=javascript:Update(\"typeofrecs\")>".$msgstr["typeofrecords"]."</a> <br />";
			?>

			<a id="botoes" style="width: 300px;"  href=javascript:Update("recval")><?php echo $msgstr["recval"]?></a> <br />
		<!--	<a id="botoes" style="width: 300px;" href=javascript:Update("delval")><?php echo $msgstr["delval"]?></a> <br /> -->
			<a id="botoes" style="width: 300px;"  href=javascript:Update("search")><?php echo $msgstr["advsearch"]?></a> <br />
			<a  id="botoes" style="width: 300px;" href=javascript:Update("bases")><?php echo $msgstr["dblist"]?></a> <br />
			<a  id="botoes" style="width: 300px;" href=javascript:Update("par")><?php echo $msgstr["dbnpar"]?></a> <br />
         <a id="botoes" style="width: 300px;"  href=javascript:Update("help")><?php echo $msgstr["helpdatabasefields"]?></a> <br />
         <a  id="botoes" style="width: 300px;"  href=javascript:Update("IAH")><?php echo $msgstr["iah-conf"]?></a> <br />
         <a  id="botoes" style="width: 300px;"  href=javascript:Update("stats_var")><?php echo $msgstr["estadisticas"]." - ".$msgstr["var_list"]?></a> <br />
         <a  id="botoes" style="width: 300px;"  href=javascript:Update("stats_tab")><?php echo $msgstr["estadisticas"]." - ".$msgstr["tab_list"]?></a> <br />
            
			</form>
		</td>
</table>
<br>
</div>
</div>
<?
// PIE DE PÁGINA
include("../common/footer.php");
?>
</body>
</html>