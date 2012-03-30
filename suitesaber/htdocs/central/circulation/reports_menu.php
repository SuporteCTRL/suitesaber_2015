<?php
/**
�* @program:�� ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
�* @copyright:� Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
�* @file:����� reports_menu.php
�* @desc:����� Menu reports
�* @author:��� Guilda Ascencio
�* @since:���� 20091203
�* @version:�� 1.0
�*
�* == BEGIN LICENSE ==
�*
�*��� This program is free software: you can redistribute it and/or modify
�*��� it under the terms of the GNU Lesser General Public License as
�*��� published by the Free Software Foundation, either version 3 of the
�*��� License, or (at your option) any later version.
�*
�*��� This program is distributed in the hope that it will be useful,
�*��� but WITHOUT ANY WARRANTY; without even the implied warranty of
�*��� MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.� See the
�*��� GNU Lesser General Public License for more details.
�*�� 
�*��� You should have received a copy of the GNU Lesser General Public License
�*��� along with this program.� If not, see <http://www.gnu.org/licenses/>.
�*�� 
�* == END LICENSE ==
*/

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");

if (!isset($_SESSION["login"])){
	die;

function DoList($database){
	if (file_exists($db_path."$database/pfts/".$_SESSION["lang"]."/formatos.dat"))
		$fp = file($db_path."$database/pfts/".$_SESSION["lang"]."/formatos.dat");
	else
		if (file_exists($db_path."$database/pfts/".$lang_db."/formatos.dat"))
			$fp = file($db_path."$database/pfts/".$lang_db."/formatos.dat");

	if ($fp){
		echo "<strong>".$msgstr["reports_$database"].": $database</strong>";
		echo "<ul>";
		foreach ($fp as $value){
			$value=trim($value);
			if (!empty($value)) {
				$pp=explode('|',$value);
				echo "<li><a href=reports_menu_recsel.php?base=$database&list=".urlencode($value)."$encabezado>".$pp[1]."</a>";
			}
		}
		echo "</ul>";

	}
    echo "<p>";


// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//


include("../common/get_post.php");

if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";

$arrHttp["login"]=$_SESSION["login"];
$arrHttp["password"]=$_SESSION["password"];

$base ="trans";
$cipar ="trans.par";


if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";

include("../common/header.php");
?>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script language=Javascript src=../dataentry/js/selectbox.js></script>
<style type=text/css>

td{
	font-family:Arial;

div#useexformat{

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}


div#testformat{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#savesearch{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script languaje=javascript>

TipoFormato=""
C_Tag=Array()

//IF THE TYPE OF OUTPUT IS NOT IN COLUMN, HEADINGS ARE NOT ALLOWED
function CheckType(){
		document.forma1.pft.focus()


function CopiarExpresion(){
	Expr=document.forma1.Expr.options[document.forma1.Expr.selectedIndex].value
	document.forma1.Expresion.value=Expr

}

function CopySortKey(){
	Sort=document.forma1.sort.options[document.forma1.sort.selectedIndex].value
	document.forma1.sortkey.value=Sort
}

function CreateSortKey(){
	msgwin=window.open("","sortkey","resizable,scrollbars, width=600,height=600")
	msgwin.focus()

function AbrirVentana(Archivo){
	xDir=""
	msgwin=window.open(xDir+"ayudas/"+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function EsconderVentana( whichLayer ){

	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
	vis.display = 'none';
	vis.display =  'none';
}


function toggleLayer( whichLayer ){
	var elem, vis;

	switch (whichLayer){
<?php if ($arrHttp["Opcion"]!="new"){
			document.forma1.fgen.selectedIndex=-1
			EsconderVentana("useexformat")
            if (save=="Y"){
			//	document.forma1.nombre.value=""
			//	document.forma1.descripcion.value=""
			}
			break
			';
}
?>
		case "useexformat":
			EsconderVentana("createformat")
			break

	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
		vis.display = ( elem.offsetWidth != 0 && elem.offsetHeight != 0 ) ? 'block':'none';
	vis.display = ( vis.display == '' || vis.display == 'block' ) ? 'none':'block';
}



function BorrarRango(){
	document.forma1.Mfn.value=''
	document.forma1.to.value=''
}


function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function EnviarForma(vp){
	if (vp=="P") {
		document.forma1.vp.value="S"
		document.forma1.target="VistaPrevia"
	}else{
		document.forma1.vp.value=vp
		document.forma1.target=""
	}
	de=Trim(document.forma1.Mfn.value)
  	a=Trim(document.forma1.to.value)
  	if (de!="" || a!="") {
	  	document.forma1.Opcion.value="rango"
  		Se=""
		var strValidChars = "0123456789";
		blnResult=true
   	//  test strString consists of valid characters listed above
   		for (i = 0; i < de.length; i++){
    		strChar = de.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	for (i = 0; i < a.length; i++){
    		strChar = a.charAt(i);
    		if (strValidChars.indexOf(strChar) == -1){
    			alert("<?php echo $msgstr["especificarvaln"]?>")
	    		return
    		}
    	}
    	de=Number(de)
    	a=Number(a)
    	if (de<=0 || a<=0 || de>a ||a>top.maxmfn){
	    	alert("<?php echo $msgstr["numfr"]?>")
	    	return
		}
	}

	if (document.forma1.fgen.selectedIndex<1 ){
	  	alert("<?php echo $msgstr["r_selgen"]?>")
	  	return
	}
	if (Trim(document.forma1.Expresion.value)=="" && (Trim(document.forma1.Mfn.value)=="" )){
		alert("<?php echo $msgstr["r_selreg"]?>")
		return
	}
	msgwin=window.open("","VistaPrevia","resizable, status, scrollbars")
  	document.forma1.submit()
  	msgwin.focus()
}

function Buscar(){
	base='<?php echo $arrHttp["base"]?>'
	cipar=base+".par"
	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}


function GuardarBusqueda(){
	document.savesearch.Expresion.value=Trim(document.forma1.Expresion.value)
	if (document.savesearch.Expresion.value==""){
		alert("<?php echo $msgstr["faltaexpr"]?>")
		return
	}
	Descripcion=document.forma1.Descripcion.value
	if (Trim(Descripcion)==""){
		alert("<?php echo $msgstr["errsave"]?>")
		return
	}
	document.savesearch.Descripcion.value=Descripcion
	var winl = (screen.width-300)/2;
	var wint = (screen.height-200)/2;
	msgwin=window.open("","savesearch","menu=no,status=yes,width=300, height=200,left="+winl+",top="+wint)
	msgwin.focus()
	document.savesearch.submit()
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
<div class="language">
		<?php include("submenu_prestamo.php");?>
</div>

</div>

	<div class="breadcrumb"><h3>
<?php echo $msgstr["pft"].": ".$arrHttp["base"]?>
</h3></div>

	<div class="actions">
<?php
	if (isset($arrHttp["encabezado"])){

		<span><strong>".$msgstr["back"]."</strong></span></a>
			";
?>

</div>



<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reports.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: reports_menu.php";
?>
</font>
	</div>
<form name=forma1 method=post action=../dataentry/imprimir_g.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Dir value=<?php echo $arrHttp["Dir"]?>>
<input type=hidden name=Modulo value=<?php if (isset($arrHttp["Modulo"])) echo $arrHttp["Modulo"]?>>
<input type=hidden name=tagsel>
<input type=hidden name=Opcion>
<input type=hidden name=vp>


<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
?><center>
<div class="middle form">
			<div class="formContent">
<!-- USE AN EXISTING FORMAT -->
<?php
	echo "<center><table>
			<tr>
			<td align=left   valign=center>";
	DoList("trans");
	DoList("users");
	DoList("suspml");

?>
</td>

</table>
<p>
</center>
</div>
</div>
</center>
<?php
include("../common/footer.php");
?>
</body>
</html>