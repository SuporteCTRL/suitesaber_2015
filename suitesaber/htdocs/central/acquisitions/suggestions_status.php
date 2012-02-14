<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      suggestions_status.php
 * @desc:      Suggestions status
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
$lang=$_SESSION["lang"];
include("../lang/acquisitions.php");

include("../common/get_post.php");
if(isset($_SESSION["permiso"]["ACQ_ACQALL"]))
	if (!isset($arrHttp["see_all"]))$arrHttp["see_all"]="Y";
include("../common/header.php");
$encabezado="";
echo "<script>
function Editar(Mfn){
	document.EnviarFrm.Mfn.value=Mfn
	document.EnviarFrm.Opcion.value=\"editar\"
	document.EnviarFrm.submit()

function Mostrar(Mfn){
	msgwin.focus()
</script>
";
echo "<body>\n";
include("../common/institutional_info.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

// Se ubican todas las solicitudes que est�n pendientes (STATUS=0)
// se asigna el formato correspondiente a la clave de clasificaci�n
// se lee el t�tulo de las columnas de la tabla
switch($arrHttp["sort"]){
		$index="ti.pft";
		$tit="ti_tit.tab";
		break;
	case "RB":
		$index="rb.pft";
		$tit="rb_tit.tab";
		break;
	case "DR":
		$index="dr.pft";
		$tit="dr_tit.tab";
		break;
	case "OP":
		$index="op.pft";
		$tit="op_tit.tab";
		break;
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
$tit_tab=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($tit_tab)) $tit_tab=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit";
if (!file_exists($Formato)){
	die;
if (!file_exists($tit_tab)){
	echo $msgstr["missing"] ." $tit";

}
$fp=file($tit_tab);
$tit_tab=implode("",$fp);
$Formato="@$Formato,/";
$Expresion="STA_0 ";
if (!isset($arrHttp["see_all"])) $Expresion.="and OPERADOR_".$_SESSION["login"];

$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){
	$value=trim($value);
	if ($value!="")	{
		$s=explode('|',$value);
		while (strlen($ix)<4) $ix="0".$ix;
		$key=$s[0].$ix;
		$recom[$key]=$value;



ksort($recom);
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>

document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma("")
    return true;
  }
function Enviar(sort){
	url="suggestions_status.php?base=suggestions&sort="+sort
	if (document.sort.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url
</script>
<?php

?>
<div class="sectionInfo">
<div class="language">		
<?php include("suggestions_menu.php");?>
</div>
</div>

	<div class="breadcrumb"><h3>
		<?php echo $msgstr["suggestions"].": ".$msgstr["approve"]."/".$msgstr["reject"]?>
	</h3></div>
	<div class="actions">
	</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/approval_rejection.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/approval_rejection.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: suggestions_status.php</font>\n";
?>
	</div>
<form name=sort>
<div class="middle form">
	<div class="formContent">
         <?php echo $msgstr["pending_sort"]?>
		<div class="pagination">
			<a id="botoes"  href=javascript:Enviar("TI") class="singleButton singleButtonSelected">

						<?php echo $msgstr["title"]?>
	
					</a>
			<a id="botoes" href=javascript:Enviar("RB") class="singleButton singleButtonSelected">
					
						<?php echo $msgstr["recomby"]?>

					</a>
			<a id="botoes" href=javascript:Enviar("DR") class="singleButton singleButtonSelected">

						<?php echo $msgstr["date_sug"]?>
		
					</a>
			<a id="botoes" href=javascript:Enviar("OP") class="singleButton singleButtonSelected">
	
						<?php echo $msgstr["operator"]?>
		
					</a>
			<p align=right><input type=checkbox name=see_all
			<?php if (isset($arrHttp["see_all"])) echo " value=Y checked"?>><?php echo $msgstr["all_oper"]?>
		</div>
		</h5>
	<table class=listTable cellspacing=0 border=1>
		<tr>

<?php
// se imprime la lista de recomendaciones pendientes
	echo "<th>&nbsp;</th>";
	$t=explode('|',$tit_tab);
	foreach ($t as $v)  echo "<th>".$v."</th>";

	foreach ($recom as $value){
		$ix1="";
		foreach ($r as $cell){
				$ix1=1;
			else
				if ($ix1==1){
					<a href=javascript:Mostrar($cell)><img src=\"../images/zoom.png\"></a>
					</td>";
					$ix1=2;
	 				echo "<td>$cell</td>";

	}
?>
</table>

</div>
	</div>
</div>
</form>
<form name=EnviarFrm method=post action=suggestions_status_ex.php>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=Mfn value="">
<input type=hidden name=Opcion value="">
<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
<input type=hidden name=retorno value=../acquisitions/suggestions_status.php>
<input type=hidden name=encabezado value="S">
<?php if (isset($arrHttp["see_all"])) echo "<input type=hidden name=see_all value=\"S\"> ";?>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>