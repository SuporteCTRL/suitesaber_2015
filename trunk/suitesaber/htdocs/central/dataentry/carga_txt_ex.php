<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      carga_txt_ex.php
 * @desc:      process txt file and download it in database
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
include ("../config.php");
$lang=$_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");
include("../common/header.php");

set_time_limit(420);

?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["cnv_import"]." ".$msgstr["cnv_txt"]?>
	</div>
	<div class="actions">
<?php echo "<a href=javascript:self.close()  class=\"defaultButton cancelButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["cerrar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/txt2isis.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: carga_txt_ex.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";




// se incluye la rutina que convierte los r�tulos a tags isis
include ("rotulos2tags.php");

function Delimited($rotulos,$registro){
	$salida=array();
	if (trim($registro!="")){
		foreach ($rotulos as $value){
	 		if (trim($value[1])!=""){
	 			$tag[$value[0]]=$value[1];
	 			$repetible[$value[0]]=$value[4];
	 		}
	 	}
	 	$ix=0;
	 	foreach ($t as $val) {
	 		$ix=$ix+1;
	 		if (trim($val)!="")
	 			if (isset($tag[$ix]))
	 				$salida[$tag[$ix]]=str_replace("\n"," ",$val);
	 				$salida[$tag[$ix]]=str_replace("\r"," ",$val);
	}
 	return $salida;

}

function SubCampos($campo,$subc,$delim){
	$subc=rtrim($subc);
	$ixpos=0;
	for ($i=0;$i<strlen($subc);$i++){
		$sc=substr($subc,$i,1);
		$ed=substr($delim,$i,1);
		if ($i==0){
			if ($ed==" ")
				$campo='^'.$sc.$campo;
			else
				$campo=str_replace($ed,'^'.$sc,$campo);
				$campo=str_replace('^'.$sc." ",'^'.$sc,$campo);
		}else{
			$campo=str_replace($ed,'^'.$sc,$campo);
			$campo=str_replace('^'.$sc." ",'^'.$sc,$campo);
		}
	}
	return $campo;
}

//Se ajuntan las etiquetas isis para crear el string de actualizaci�n de la Base de datos
function ProcesarBD($base,$salida,$rotulo){
global $arrHttp;
	$ValorCapturado="";

	foreach ($salida as $key=>$value) {
		if (isset($rotulo[$key][2]))
			$subc=$rotulo[$key][2];
		else
			$subc="";
		if (isset($rotulo[$key][3]))
			$delim=$rotulo[$key][3];
		else
			$delim="";
		$rep=$rotulo[$key][4];
		$formato=$rotulo[$key][5];
		switch (strlen($key)){
			case 1:
			 	$key="000".$key;
			 	break;
			case 2:
				$key="00".$key;
			 	break;
			case 3:
				$key="0".$key;
			 	break;
		}
		if (trim($value)!=""){
			if (trim($rep)!=""){
				$sal=explode($rep,$value);
				foreach ($sal as $campo){
					if (trim($subc)!="") $campo=SubCampos($campo,$subc,$delim);
					if ($ValorCapturado=="")
						$ValorCapturado=$key.trim($campo);
					else
						$ValorCapturado.="\n".$key.trim($campo);
				}
			}else{
				if (trim($subc)!="") $value=SubCampos($value,$subc,$delim);
				if ($ValorCapturado=="")
					$ValorCapturado=$key.trim($value);
				else
					$ValorCapturado.="\n".$key.trim($value);
			}

		}


	}
	ActualizarRegistro($base,$ValorCapturado);

}

//Se lee la tabla con la estructura de conversi�n de r�tulos a tags isis
function LeerTablaCnv(){
Global $separador,$arrHttp,$db_path;
	$fp=file($db_path.$arrHttp["base"]."/cnv/".$arrHttp["cnv"]);
	$ix=-1;
	foreach($fp as $value){
		if (substr($value,0,2)<>'//'){
			if ($ix==-1){
				$separador=trim($value);
				$ix=0;
			}else{
				$ix=$ix+1;
				$t=explode('|',$value);
				$t[1]=trim($t[1]);
				$t[0]=trim($t[0]);
//				echo $t[0]."=".$t[1]."<br>";
				$rotulo[$t[1]][0]=$t[0];
				$rotulo[$t[1]][1]=$t[1];
				$rotulo[$t[1]][2]=$t[2];
				if (isset($t[3])) $rotulo[$t[1]][3]=$t[3];
				if (isset($t[4])) $rotulo[$t[1]][4]=$t[4];
				if (isset($t[5])) $rotulo[$t[1]][5]=$t[5];
			}
		}
	}
	return $rotulo;
}





function ActualizarRegistro($base,$ValorCapturado){
global $arrHttp,$Wxis,$xWxis,$db_path,$wxisUrl,$lang_db,$msgstr;

	$ValorCapturado=urlencode($ValorCapturado);
	$Mfn="New";
	$base=$arrHttp["base"];
	$IsisScript=$xWxis."crear_registro.xis";
	$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["base"];
	if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["base"];
	$query = "&base=$base&cipar=".$db_path."par/$base.par" ."&login=".$_SESSION["login"]."&Mfn=$Mfn"."&Formato=$Formato"."&ValorCapturado=".$ValorCapturado;
	$contenido="";
    include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		if (substr($linea,0,4)=="MFN:" or substr($linea,0,10)=="<IMAGENES>") {
	//	    $arrHttp["Mfn"]=trim(substr($linea,4));
		}else{
			echo $linea."\n";
		}
	}

}
//Fin Actualizar Registro


//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------

include("../common/get_post.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
echo "<script>
function RefreshDB(){
	window.opener.location.href='inicio_base.php?base=".$arrHttp["base"]."'
	self.close()
}
</script>
";
$Errores=false;
echo "<form method=post name=forma1 action=carga_txt_ex.php>
<input type=hidden name=Actualizar value=SI>\n";
if (!isset($arrHttp["Actualizar"])){
	foreach ($arrHttp as $var => $value) {
		echo "<input type=hidden name=$var value=\"".urlencode($value)."\">\n";
	}
}
if (isset($arrHttp["Actualizar"])) $value=urldecode($arrHttp["bdd"]);
$value=stripslashes($value);
$value=str_replace('&nbsp;&nbsp;',"&nbsp;",$value);
if (trim($value)!="") {
	$noLocalizados="";
	$separador="";
	$base=$arrHttp["base"];
	echo "<p><h4>".$arrHttp["base"]."</h4>";
	$rotulo=LeerTablaCnv();
	//echo urldecode($HTTP_POST_VARS[$var]);
	if ($separador!='[TABS]'){
		$variables=explode($separador,$value);
	}else{
	foreach($variables as $registro){
		$noLocalizados="";
		if ($separador=='[TABS]'){
			$salida=Rotulos2Tags($rotulo,$registro);
		}
		if (count($salida)>0){
			echo "<p><b>--------</b> <br>";
			if (!isset($arrHttp["Actualizar"])) {
				echo "<br>";
				foreach ($salida as $key=>$value) echo "($key) ".$rotulo[$key][0]." $value<br>";
			}
			if (isset($arrHttp["Actualizar"])) ProcesarBD($arrHttp["base"],$salida,$rotulo);
		}
		if (trim($noLocalizados)!="") {
			$Errores=true;
			echo "<font color=red><b>".$msgstr["cnv_nol"]."</b></font color=black><br>". nl2br($noLocalizados);
		}
//		if (isset($arrHttp["Actualizar"])) ProcesarBD($arrHttp["base"],$salida,$rotulo);
	}
	$arrHttp[$var]=$salida;
}

if (!isset($arrHttp["Actualizar"])){
	echo "<p><strong>".$msgstr["bd"].": ".$arrHttp["base"]."</strong> <input type=submit value=".$msgstr["actualizar"].">";
} else{
	echo "<a href=javascript:RefreshDB()>".$msgstr["reopendb"]."</a>";
echo "</form>
</div>
</div>
</body>
</html>";

die;
?>