<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
if(isset($_SESSION["permiso"]["ACQ_ACQALL"]))
	if (!isset($arrHttp["see_all"])) $arrHttp["see_all"]="Y";
include("../common/header.php");
$encabezado="";
echo "<script>
function Mostrar(Mfn){
	M=Mfn.split('_');
	Mfn=M[0]
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
		$index="ti_order.pft";
		$tit="ti_order_tit.tab";
		break;
	case "PV":      //provider
		$index="pv_order.pft";
		$tit="pv_order_tit.tab";
		break;
	case "DA":      // date of approval
		$index="da_order.pft";
		$tit="da_order_tit.tab";
		break;
		break;
	case "SN":      // date of approval
		$index="sn_order.pft";
		$tit="sn_order_tit.tab";
		break;
		break;
	case "OP":
		$index="op_order.pft";
		$tit="op_order_tit.tab";
		break;
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$index" ;
$tit=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/$tit";
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$index" ;
if (!file_exists($Formato)){
	die;
if (!file_exists($tit)) $tit=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/$tit" ;
if (!file_exists($tit)){
	echo $msgstr["missing"] ." $tit";

}
$fp=file($tit);
$tit_tab=implode("",$fp);
$Formato_order=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/pv_order.pft" ;
if (!file_exists($Formato_order)) $Formato_order=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/pv_order.pft" ;
$Formato="@$Formato,/";
$Expresion="STA_4";
if (!isset($arrHttp["see_all"])) $Expresion.=" and OPERADOR_".$_SESSION["login"];
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$recom=array();
$ix=-1;
foreach ($contenido as $value){
	$value=trim($value);
	if ($value!="")	{
		$ix=$ix+1;
		$s=explode('|',$value);
		$key=$s[0].$ix;
		$recom[$key]=$value;
	}



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
	url="order.php?base=suggestions&sort="+sort
	if (document.order.see_all.checked)
		url+="&see_all=Y"
	self.location.href=url

}

function EnviarForma(){
	Mfn=""
			sel="S"
				Mfn+=document.order.oc[i].value+"\n"
				sel="S"
			}
	if (sel=="N"){
		return
	document.order.Mfn_sel.value=Mfn
	document.order.submit()

</script>
<?php

?>
<div class="sectionInfo">
	<div class="language">
		<?php include("order_menu.php");?>
	</div>
</div>
	<div class="breadcrumb"><h3>
		<?php echo $msgstr["purchase"].": ".$msgstr["createorder"]?>
	</h3></div>
	<div class="actions">

	</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/order.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/order.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: order.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
	<form name=order method=post action=order_ex.php onsubmit='return false'>
		<input type=hidden name=Mfn_sel>
		<input type=hidden name=sort value=<?php echo $arrHttp["sort"]?>>
		<?php echo $msgstr["approvacq"]." ".$msgstr["sorted"]?>
		<div class="pagination">
			<a  id="botoes" href=javascript:Enviar("PV") class="singleButton singleButtonSelected">

				<?php echo $msgstr["provider"]?> 

			</a>
			<a id="botoes" href=javascript:Enviar("TI") class="singleButton singleButtonSelected">

				<?php echo $msgstr["title"]?> 

			</a>
			<a id="botoes"  href=javascript:Enviar("DA") class="singleButton singleButtonSelected">

				 <?php echo $msgstr["date_app"]?> 

			</a>
			<a  id="botoes" href=javascript:Enviar("SN") class="singleButton singleButtonSelected">

				<?php echo $msgstr["suggestno"]?>

			</a>
			<a  id="botoes" href=javascript:Enviar("OP") class="singleButton singleButtonSelected">

				<?php echo $msgstr["operator"]?>

			</a>
			<p align=right><input  id="botoes" type=checkbox name=see_all
			<?php if (isset($arrHttp["see_all"])) echo " checked"?>><?php echo $msgstr["all_oper"]?>
		</div>

		</h5>
	<table class=listTable cellspacing=0 border=1>
		<tr>

<?php
// se imprime la lista de recomendaciones pendientes
	echo "<th>&nbsp;</th>";
	$t=explode('|',$tit_tab);
	foreach ($t as $v)  echo "<th>".$v."</th>";
    $ixelem=0;
	foreach ($recom as $value){
		if (trim($r[9])=="")    //ALREADY INCLUDED IN AN PURCHASE ORDER?
			$check="SI";
		else
			$check="NO";
		$ix1=0;
		$at=0;
		if ($check=="SI"){
			foreach ($r as $cell){
					$ix1=1;
				else
					if ($ix1==1){
						echo "<input type=checkbox name=oc value=\"$cell\">&nbsp;";
						echo "</td>";
						$ix1=2;
							$ixpos=strpos($cell,'^',2);

        }
	}
?>
</table>
&nbsp; &nbsp;<input  id="botoes" type=submit name=send value=<?php echo $msgstr["order"]?> onclick=EnviarForma()>
</form>
</div>
	</div>
</div>
</form>
<?php echo "\n<script>ncheck=$ixelem</script>\n" ?>
<?php include("../common/footer.php");
echo "</body></html>" ;
?>