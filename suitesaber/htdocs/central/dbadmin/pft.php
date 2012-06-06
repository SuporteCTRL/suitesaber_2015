<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      pft.php
 * @desc:      Allows reading and modification of the .pft file. 
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
include ("../lang/admin.php");
include ("../lang/dbadmin.php");


function LeerArchivos($Dir,$Ext){
// se leen los archivos con la extensión .pft
$the_array = Array();
$handle = opendir($Dir);
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
   		if(is_file($Dir."/".$file))
		   if (substr($file,strlen($file)-4,4)==".".$Ext) $the_array[]=$file;
   }
}
closedir($handle);
return $the_array;
}

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//


include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (strpos($arrHttp["base"],"|")===false){

}else{
	$ix=strpos($arrHttp["base"],'^b');
	$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}
if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";

$arrHttp["login"]=$_SESSION["login"];
$arrHttp["password"]=$_SESSION["password"];

$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";
$login=$arrHttp["login"];
$password=$arrHttp["password"];

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
}

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
if ($arrHttp["Opcion"]!="new"){
	$pft=LeerArchivos($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/","pft");
	echo "\n<script>Dir='pfts/".$_SESSION["lang"]."/'</script>\n";
	$arrHttp["Dir"]="pfts/".$_SESSION["lang"];

	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
	if (file_exists($archivo)){
		$fpTm=file($archivo);
	}else{
		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		if (file_exists($archivo)){
			$fpTm=file($archivo);
		}else{
			echo $msgstr["fatal"].". ".$msgstr["misfile"].": ".$db_path.$arrHttp["base"]."/".$arrHttp["base"].".fdt";
			die;
		}
	}
}else{
	$arrHttp["Dir"]="";
	$fpTm=explode("\n",$_SESSION["FDT"]);
}
foreach ($fpTm as $linea){
	if (!empty($linea)) {
		$t=explode('|',$linea);
		if ($t[0]!="S")
   		$Fdt[]=rtrim($linea);
	}
}

include("../common/header.php");
?>
<script language="javascript1.2" src="../dataentry/js/lr_trim.js"></script>
<script language=Javascript src=../dataentry/js/selectbox.js></script>
<style type=text/css>
#botoes {
	padding: 3px 4px 3px 4px;	
	}
td{
	font-size:12px;
	font-family:Arial;
}

div#useexformat{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#createformat{
<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#pftedit{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#testformat{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#saveformat{
	<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>
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
	if (document.forma1.tipof[0].checked || document.forma1.tipof[1].checked){
		alert("<?php echo $msgstr["r_noheading"]?>")
		document.forma1.pft.focus()
	}

}

function CopiarExpresion(){
	Expr=document.forma1.Expr.options[document.forma1.Expr.selectedIndex].value
	document.forma1.Expresion.value=Expr

}

function CopySortKey(){
	Sort=document.forma1.sort.options[document.forma1.sort.selectedIndex].value
	document.forma1.sortkey.value=Sort
}

function CreateSortKey(){
	msgwin=window.open("","sortkey","resizable,scrollbars, width=750,height=600")
	document.sortkey.submit()
	msgwin.focus()
}

function AbrirVentana(Archivo){
	xDir=""
	msgwin=window.open(xDir+"ayudas/"+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function EsconderVentana( whichLayer ){
var elem, vis;

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
		case "createformat":
<?php if ($arrHttp["Opcion"]!="new"){
		echo '
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

	}
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

function SubCampos(Tag,delim,ed){
	xtag="(if p(v"+Tag+") then "
	for (ic=0;ic<delim.length;ic++){
		if(delim.substr(ic,1)=="-")
			delimiter="*"
 		else
 			delimiter=delim.substr(ic,1)
 		edicion=ed.substr(ic,1)
 		if (ic==0)
 			edicion=""
 		else
 			if (edicion!="") edicion=" "+edicion
		//if (ic!=delim.length-1)
			if (edicion!="")
				xtag+=',|'+edicion+'|v'+Tag+'^'+delimiter+','
	        else
			    xtag+="| |v"+Tag+'^'+delimiter+","
       	//else
       	//	xtag+="v"+Tag+'^'+delimiter+','

	}
	xtag+=" if iocc<>nocc(v"+Tag+") then '<br>' fi"
	xtag+=" fi/)"
	return xtag
}

function GenerarFormato(Tipo){
    if (document.forma1.list21.options.length==0){
    	alert("<?php echo $msgstr["selfieldsfmt"]?>")
    	return
    }
    <?php if ($arrHttp["Opcion"]!="new")
		echo "document.forma1.fgen.selectedIndex=-1
		";
	?>

	formato=""
	head=""    //COLUMNS HEADING
    switch (Tipo){
    	case "T":             //TABLE
    		formato="'<table border=1 width=90% cellspacing=0 cellspadding=0 >'\n"
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
				if (xTag=="" || xTipoE=="L"){
					campo="'<tr><td colspan=2 valign=top><span style=\"font-family:arial; font-size:12px;\"><strong>"+t[2]+"</strong></td>'/\n"
		    	}else {
		    		if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|<br>|"
					}
			    	campo="if p(v"+xTag+ ") then '<tr><td width=20% valign=top><span style=\"font-family:arial; font-size:12px;\"><strong>"+t[2]+"</b></td><td valign=top><span style=\"font-family:arial; font-size:12px;\">'"+tag+",'</td>' fi/\n"
				}
				formato+=campo
			}
			formato+="'</table><p>'";
    		break
    	case "PL":
    	case "P":
	    	for (i=0;i<document.forma1.list21.options.length;i++){
		    	campo=document.forma1.list21.options[i].value
		    	t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
				if (xTag=="" || xTipoE=="L"){
					campo="'<br /><strong>"+t[2]+"</strong></td>'/\n"
		    	}else {
		    		if (Tipo=='PL')
		    			label_f=  "<span style=\"font-family:arial; font-size:12px;\"><strong>"+t[2]+"</strong></span>: "
		 			else
		 				label_f=""
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|; |"
					}

		    		campo="if p(v"+xTag+ ") then '<br />"+label_f+"<span style=\"font-family:arial; font-size:12px;\">'"+tag+", fi/\n"
				}
				formato+=campo
			}
			formato+="'<P>'/\n"
    		break
    	case "CT":
    		formato+="\n'<tr>',"
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
		  		if (xTag!=""){
		  			res=""
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag+"+|; |"
					}
			    	campo="'<td valign=top><span style=\"font-family:arial; font-size:12px;\">'"+tag+" if a(v"+xTag+") then '&nbsp;' fi,'</span></td>'/\n"
			    	formato+=campo
			    	head+=t[2]+"\n"
				}
			}
    		break;
    	case "CD":
    		for (i=0;i<document.forma1.list21.options.length;i++){
			    campo=document.forma1.list21.options[i].value
			    t=campo.split('|')
				xTag=t[1]
				xTipoE=t[0]
		  		if (xTag!=""){
					if(Trim(t[5])!=""){
						tag=SubCampos(xTag,t[5],t[6])
					}else{
						tag="v"+xTag
					}
			    	campo=tag+",'|',\n"
			    	formato+=campo
			    	head+=t[2]+"\n"
				}

			}
			formato+="/"
    		break;
    }

	document.forma1.pft.value=formato
	document.forma1.headings.value=head

}

function LeerArchivo(Opcion){
  	if (Opcion!="agregar"){
		ix=document.forma1.fgen.selectedIndex
		if (ix==-1 || ix==0){
    		alert("<?php echo $msgstr["r_self"]?>")
    		return
		}
		fmt=document.forma1.fgen.options[ix].value
		desc=document.forma1.fgen.options[ix].text
		forsel=document.forma1.fgen.options[ix].value
  	}else{
  		forsel="*"  //para indicar que es un formato nuevo
  	}
  	xfmt=fmt+'|'
  	fm=xfmt.split('|')
  	document.forma1.nombre.value=fm[0]
  	document.forma1.descripcion.value=desc
	msgwin=window.open("leertxt.php?base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["base"]?>.par&pft=s&archivo="+forsel,"editar","menu=no,status=yes, resizable, scrollbars,width=790")
	msgwin.focus()
}

function SubirFormato(){
	document.forma1.pft.value=""
	BorrarFormato("todos")
	theHeight=150
	theWidth=400
	var theTop=(screen.height/2)-(theHeight/2);
	var theLeft=(screen.width/2)-(theWidth/2);
	var features= 'height='+theHeight+',width='+theWidth+',top='+theTop+',left='+theLeft+",scrollbars=yes,resizable";
	msgupload=window.open("","upload",features)
	msgupload.document.writeln("<html><Title><?php echo $msgstr["pft"]?></title>")
	msgupload.document.writeln("<style>")
	msgupload.document.writeln("td{font-family:arial;font-size:10px}</style>")
	msgupload.document.writeln("<form action=upload_pft.php method=POST enctype=multipart/form-data>")
	msgupload.document.writeln("<input type=hidden name=Opcion value=PFT>")
	msgupload.document.writeln("<dd><table bgcolor=#eeeeee>")
	msgupload.document.writeln("<tr>")
	msgupload.document.writeln("<tr><td class=title><?php echo $msgstr["subir"]." ".$msgstr["pft"]?></td>")
	msgupload.document.writeln("<tr><td><input name=userfile[] type=file size=20></td><td></td>")
	msgupload.document.writeln("<tr><td><input type=submit value='<?php echo $msgstr["subir"]?>'></td>")
	msgupload.document.writeln("</table>")
	msgupload.document.writeln("<p>")
	msgupload.document.writeln("</form>")
	msgupload.focus()
	msgupload.document.close()
}
function BorrarFormato(area){
	if (area=="todos"){
		document.forma1.headings.value=""
		document.forma1.pft.value=""
    }else{
    	Ctrl=eval ("document.forma1."+area)
    	Ctrl.value=""
    }

	moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false)
	for (i=0;i<document.forma1.tipof.length;i++){
		document.forma1.tipof[i].checked=false
	}
}

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}



function EnviarForma(vp){
	if (vp=="P") {

		document.forma1.vp.value="S"
		document.forma1.target="relat"
		//msgwin=window.open("","VistaPrevia","resizable, status, scrollbars")
		}else{
		document.forma1.vp.value=vp
		document.forma1.target=""
		}
	if (vp=="PP") {
		document.forma1.vp.value="PP"
		document.forma1.target="VistaPrevia"
		msgwin=window.open("","VistaPrevia","resizable, status, scrollbars")
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

	if (Trim(document.forma1.pft.value)=="" && document.forma1.fgen.selectedIndex<1 && Trim(document.forma1.pft.value)==""  ){
	  	alert("<?php echo $msgstr["r_selgen"]?>")
	  	return
	}
	if (Trim(document.forma1.Expresion.value)=="" && (Trim(document.forma1.Mfn.value)=="" )){
		alert("<?php echo $msgstr["r_selreg"]?>")
		return
	}

  	document.forma1.submit()
  	msgwin.focus()
}

function GuardarFormato(){
	document.forma1.fgen.selectedindex=-1
	if (Trim(document.forma1.pft.value)==""){
	  	alert("<?php echo $msgstr["r_selgen"]?>")
	  	return
	}
	if (Trim(document.forma1.nombre.value)==""){
		alert("<?php echo $msgstr["espftname"]?>");
		return
	}
	if (Trim(document.forma1.descripcion.value)==""){
		alert("<?php echo $msgstr["r_fnomb"]?>")
		return
	}
	fn=document.forma1.nombre.value
	bool=  /^[a-z][\w]+$/i.test(fn)
 	if (bool){

   	}else {
      	alert("<?php echo $msgstr["errfilename"]?>");
      	return
   	}
   	tipoformato=""
   	for (i=0;i<document.forma1.tipof.length;i++){
   		if (document.forma1.tipof[i].checked)
   			tipoformato=document.forma1.tipof[i].value
   	}
	document.guardar.pft.value=document.forma1.pft.value
	document.guardar.headings.value=document.forma1.headings.value
	document.guardar.tipof.value=tipoformato
	document.guardar.nombre.value=document.forma1.nombre.value
	document.guardar.descripcion.value=document.forma1.descripcion.value
	document.guardar.base.value=document.forma1.base.value
	document.guardar.submit()

}

function Buscar(){
	base='<?php echo $arrHttp["base"]?>'
	cipar=base+".par"
	Url="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&Target=s&Tabla=imprimir&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}

function EliminarFormato(){
	if (document.forma1.fgen.selectedIndex==0 || document.forma1.fgen.selectedIndex==-1){
		alert("<?php echo $msgstr["selpftdel"]?>")
		return
	}
	ix=document.forma1.fgen.selectedIndex
	if (confirm("delete "+document.forma1.fgen.options[ix].text+"?")){
		file=document.forma1.fgen.options[ix].value +'|'
		f=file.split('|')
    	document.frmdelete.pft.value=f[0]
    	document.frmdelete.submit()
    }
}

function ValidarFormato(){
	if (Trim(document.forma1.pft.value)==""){
		alert("<?php echo $msgstr["genformat"]?>")
		return
	}
	document.forma1.action="crearbd_new_create.php"
	document.forma1.submit()
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
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo"><div class="language">
<?php
if ($arrHttp["Opcion"]=="new"){
	$ayuda="pft_create.html";
	echo "<a href=fst.php?Opcion=new&base=".$arrHttp["base"]."$encabezado class=\"defaultButton\">

	<span><strong>".$msgstr["back"]."</strong></span></a>";
	echo "<a href=\"menu_creardb.php?$encabezado\"$encabezado class=\"defaultButton\">

<span><strong>".$msgstr["cancel"]."</strong></span></a>
	";
}else{
	$ayuda="pft.html";
	if (isset($arrHttp["encabezado"])){
		if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDB"])){
			if (isset($arrHttp["retorno"]))
				$retorno=$arrHttp["retorno"];
			else
				$retorno="menu_modificardb.php";
			echo "<a href=\"$retorno"."?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton\">

		<span><strong>".$msgstr["cancel"]."</strong></span></a>
			";
		}else{
			echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton\">

		<span><strong>".$msgstr["cancel"]."</strong></span></a>
			";
		}
	}
}
?>
</div></div>
	<div class="breadcrumb"><h3>
<?php echo $msgstr["pft"].": ".$arrHttp["base"]?>
	</h3></div>

	<div class="actions">


</div>


</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
echo " Script: pft.php";
?></font>
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
?>
<div class="middle form" style="position:relative; width:40%;background:#fff;float:left;">
			<div class="formContent" >
<table border=0 >
	<td  align=center>
		<?php echo "<strong>".$msgstr["r_fgent"]."</strong>";?>
        &nbsp;  <a href=http://bvsmodelo.bvsalud.org/download/cisis/CISIS-LinguagemFormato4-<?php echo $_SESSION["lang"]?>.pdf target=_blank><?php echo $msgstr["cisis"]?>
        </a>
.   </td>
<?php
echo "</table>\n";
//USE AN EXISTING FORMAT
 if ($arrHttp["Opcion"]!="new"){
	echo "<table  >
			<tr>
			<td align=left   valign=center>
    		<a style=\"width:300px;\" class=\"areas1\" href=\"javascript:toggleLayer('useexformat');\"><strong>". $msgstr["useexformat"]."</strong></a>
    		<div id=useexformat >
    		<br />".$msgstr["r_formatos"].": <div class=styled-select><select  name=fgen onclick=javascript:BorrarFormato(\"todos\")></div>
    		<option value=''>";
    unset($fp);
    $archivo=$db_path.$base."/pfts/".$_SESSION["lang"]."/formatos.dat";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/pfts/".$lang_db."/formatos.dat";
	if (file_exists($archivo)) $fp = file($archivo);
	if ($fp){
		foreach ($fp as $value){
			if (!empty($value)) {
				$pp=explode('|',$value);
				if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_pft_ALL"])
				   or isset($_SESSION["permiso"][$arrHttp["base"]."_pft_".$pp[0]])){
					echo "<option value=\"".$pp[0]."|".$pp[2]."|".$pp[3]."\">".$pp[1]." (".$pp[0].")</option>\n";
				}
			}
		}

	}
?>
	</select>

	<a id="botoes" href="javascript:LeerArchivo()"><?php echo $msgstr["edit"]?></a> 
	<a id="botoes" href="javascript:EliminarFormato()"><?php echo $msgstr["delete"]?></a>
</div>
</td>

</table>
<?}else{
		echo "<div id=useexformat></div>";

}
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_EDPFT"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDB"])){
?>
<!-- CREATE A FORMAT -->
<table border=0>
	<tr>
		<td valign=top>
		<a class="areas1" style="width:300px;"  href="javascript:EsconderVentana('pftedit');toggleLayer('createformat');toggleLayer('pftedit')">
		<strong><?php echo $msgstr["r_creaf"]?></strong></a>
  <br />
    	<div id=createformat style="margin-left:-7px; width:300px;"><br />
    	<?php echo $msgstr["r_incluirc"]?>
			<table border=0>
				<td width=100>
				<Select name=list11 style="width:150px;font-size:10px;" multiple size=10 onDblClick="moveSelectedOptions(this.form['list11'],this.form['list21'],false)">

 <?
 	$t=array();
 	foreach ($Fdt as $linea){
 		$t=explode('|',$linea);
   		echo "<option value='".$linea."'>".$t[2]." (".$t[1].")\n";
  	}
?>
				</select></td>
				<td style="width:30px;" align="center"><center>
					<a id="ajuda" href="#" onClick="moveSelectedOptions(document.forms[0]['list11'],document.forms[0]['list21'],false);return false;">
					&#9656;</a>
					<a id="ajuda"  href="#" onClick="moveAllOptions(document.forms[0]['list11'],document.forms[0]['list21'],false); return false;">
					&#9656;&#9656;</a>
					<a id="ajuda"  href="#" onClick="moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;">
					&#9666;&#9666;</a>
					<a id="ajuda"  href="#" onClick="moveSelectedOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;">
					&#9666;</a>

				</td>
				<td>
					<select name="list21" multiple size="10" style="width:100px;font-size:10px;" onDblClick="moveSelectedOptions(this.form['list21'],this.form['list11'],false)">

					</select>
				</td>
				<td align="left" valign="middle" width=50>
					<a id="ajuda"  href="#" onClick="moveOptionUp(document.forms[0]['list21'])" title="<?php echo $msgstr["r_subir"]?>" >&#9652;</a>
					
					<a id="ajuda"  href="javascript:moveOptionDown(document.forms[0]['list21'])" title="<?php echo $msgstr["r_bajar"]?>">&#9662;</a>
				</td>


			</table>
	
			<table>
				<tr>
				<td><h2><?php echo $msgstr["r_fgent"]?></h2>
					       <input type=radio name=tipof value=T onclick=GenerarFormato('T') ><?php echo $msgstr["r_tabla"]?>
					<br /><input type=radio name=tipof value=P onclick=GenerarFormato('P')><?php echo $msgstr["r_parrafo"]?>
					<br /><input type=radio name=tipof value=PL onclick=GenerarFormato('PL')><?php echo $msgstr["r_parrafo"]?>(com legendas)
					<br /> <input type=radio name=tipof value=CT onclick=GenerarFormato('CT')><?php echo $msgstr["r_colstab"]?>
					<br /><input type=radio name=tipof value=CD onclick=GenerarFormato('CD')><?php echo $msgstr["r_colsdelim"]?>

				</td>
				<tr>
				<td>
					<table>
								<input id=botoes type=button name=borrar value=<?php echo $msgstr["borrar"]?> onClick='javascript:BorrarFormato("pft")'>
					<tr><td valign="top" style="width:200px;">
					
					<?php echo $msgstr["pftex"]?>
						<textarea name=pft cols=30 rows=15 style="width:200px;font-size:11px;font-family:courier new;"></textarea>

	    			</td>
    				<td valign="top" style="width:100px;"><?php echo $msgstr["r_heading"]?>
    				<textarea name=headings cols=9 rows=15 style="width:100px;font-size:11px;font-family:courier new;" onfocus=CheckType()></textarea>
    	</td></tr>
			</table>
          </div>
		</td>
		</td>
	</table>			
			
			
		</div>
		</td>

		<td>
		<div id=pftedit>

</table>


<!-- GENERATE OUTPUT -->
<?php
}else{
	echo "<div id=\"createformat\"></div>";
}
if ($arrHttp["Opcion"]!="new"){?>
<table>
	<tr>
		<td>
		<a class="areas1" style="width:300px;" HREF="javascript:toggleLayer('testformat')"><strong><?php echo $msgstr["generateoutput"]?></strong></a>
    		<div id="testformat" style="margin-left:-7px; width:300px;"><br />
    		<table>
		<!--<td bgcolor="#dddddd"><?php echo $msgstr["r_recsel"]?></td>-->
	<tr>
		<td><strong><?php echo $msgstr["r_mfnr"]?></strong>:<br /> 
		<?php echo $msgstr["r_desde"]?>: <input id="form" type="text" name="Mfn" size="5"><?php echo $msgstr["r_hasta"]?>:<input type="text"  id="form" name="to" size="5">
	
		 <a id="tag" href="javascript:BorrarRango()"><?php echo $msgstr["borrar"]?></a>
		 	
		<script> if (top.window.frames.length>0)
			document.writeln(" &nbsp; (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script></td>
	<tr>
		<td><strong><?php echo $msgstr["r_busqueda"]?></strong>: <br />
<?php
unset($fp);
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab"))
	$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
else
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab"))
		$fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab");
if ($fp){
	echo "".$msgstr["copysearch"].":";
	echo "<select name=Expr  onChange=CopiarExpresion()>
    		<option value=''>
    ";
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$pp=explode('|',$value);
			echo "<option value=\"".$pp[1]."\">".$pp[0]."</option>\n";
		}
	}

}
?>
			</select>
			<a id="botoes" href="javascript:Buscar()">
			<!--<span style="transform:rotate(-45deg);font-size:24px;-moz-transform:rotate(-45deg);-webkit-transform:rotate(-45deg);-ms-transform:rotate(-45deg);-o-transform:rotate(-45deg);">&#9906;&nbsp;</span>-->
			<?php echo $msgstr["advsearch"]?></a>
			<br />
			<textarea rows="2" cols="33" name="Expresion"><?php if ($Expresion!="") echo $Expresion?></textarea>
			<br /><a id="botoes" href="javascript:BorrarExpresion()"><?php echo $msgstr["borrar"]?></a>
<?php
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])){
	echo "&nbsp; <a id=\"botoes\" href=\"javascript:toggleLayer('savesearch')\"><strong>". $msgstr["savesearch"]."</strong></a>";
	echo "<div id=savesearch>".$msgstr["r_desc"].": <input type=text name=Descripcion size=40>
     	&nbsp &nbsp <input type=button value=\"". $msgstr["savesearch"]."\" onclick=GuardarBusqueda()><hr>
		</div>\n";
}
?>
<hr>
		</td>
	<tr>
		<td colspan=2><strong><?php echo $msgstr["sortkey"]?></strong>: &nbsp;
		<input type=text name=sortkey size=30> <br /> <?php echo $msgstr["sortkeycopy"]?>
		&nbsp; &nbsp;
    		<select name=sort  onChange=CopySortKey()>
    		<option value=''>
<?php
unset($fp);
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab"))
	$fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab");
else
	if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab"))
		$fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/sort.tab");
if ($fp){
	foreach ($fp as $value){
		if (!empty($value)) {
			$pp=explode('|',$value);
			echo "<option value=\"".trim($pp[1])."\">".$pp[0]."</option>\n";
		}
	}

}

echo "			</select>";
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_EDSORT"])){
 echo "&nbsp;<a id=botoes href=javascript:CreateSortKey()>".$msgstr["sortkeycreate"]."</a>";
 }
?>
		</td>

	<tr>
		<td align="center">
		<br /><hr><br />
			<strong><?php echo $msgstr["sendto"]?></strong>:
		
	
<a id="botoes" href="javascript:EnviarForma('WP')"><?php echo $msgstr["word"]?></a>
			
<a id="botoes" href="javascript:EnviarForma('TB')"><?php echo $msgstr["wsproc"]?></a>
			
<a id="botoes" href="javascript:EnviarForma('TXT')" value="T">&real; TXT</a>			
	
<a id="botoes" href="javascript:EnviarForma('PP')"><?php echo $msgstr["print"]?></a>
			
<a id="botoes" href="javascript:EnviarForma('P')"><?php echo $msgstr["preview"]?></a>
			

		</td>
</table>
</div>
</td>
</table>

<?php
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_EDPFT"])){
$save="Y";
?>
<table>
	<tr>
		<td>
			<a class="areas1" style="width:300px;"  href="javascript:toggleLayer('saveformat')"><strong><?php echo $msgstr["r_guardar"]?></strong></a>
    		<div id=saveformat><p>
			<table border=0 cellpadding=0>
				<td bgcolor="#dddddd">
			<?php echo $msgstr["r_guardar"]."<br /> ".$arrHttp["base"]."/". $arrHttp["Dir"]?>/ </td>
				<td><input type=text name=nombre size=30 maxlength=30></td>
				<tr><td align=right valign=top>
					<?php echo $msgstr["r_desc"]?></td><td valign=top><input type=text name=descripcion maxlength=10 size=30>
					<br />
					<a id="botoes" href="javascript:GuardarFormato()"><?php echo $msgstr["save"]; ?></a>
				</td>
			</table>
			</div>
	</td>
</table>
<?php }else{
	$save="N";
}
echo "\n<script>save='$save'</script>\n";
if (!isset($arrHttp["Modulo"]))
	if (!isset($arrHttp["encabezado"]))
		echo "&nbsp; &nbsp;<a href=menu_modificardb.php?Opcion=".$arrHttp["Opcion"]."&base=".$arrHttp["base"].">".$msgstr["cancel"]. "</a><p>";
}else{
	echo "<a style=\"float:right;width:200px;margin-bottom:150px;\" id=botoes href=javascript:ValidarFormato()>".$msgstr["createdb"] ."</a>";
}
?>
<!--a href=menu_modificardb.php?base=<?php echo $arrHttp["base"]?>><?php echo $msgstr["cancel"]?></a>-->
<input type=hidden name=sel_oper>
</form>
<form name=guardar method=post action=pft_update.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=pft>
<input type=hidden name=nombre>
<input type=hidden name=descripcion>
<input type=hidden name=tipof>
<input type=hidden name=headings>
<input type=hidden name=pftname>
<input type=hidden name=Modulo value=<?php if (isset($arrHttp["Modulo"])) echo $arrHttp["Modulo"]?>>
<input type=hidden name=sel_oper>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
</form>
<form name=frmdelete action=pft_delete.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=pft>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
</form>
<form name=savesearch action=../dataentry/busqueda_guardar.php method=post target=savesearch>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=Expresion value="">
	<input type=hidden name=Descripcion value="">
</form>	<p>
<form name=sortkey method=post action=sortkey_edit.php target=sortkey>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=encabezado value=s>
</form>
</center>
</div>
</div>

<div style="position:relative;width:60%;background:#fff;float:right;height:1000px;">
<iframe style="width:100%;height:100%;" src="#" id="relat" name="relat" frameborder="0" >
</div>







<?php
include("../common/footer.php");
?>
</body>
</html>
<?php if (isset($arrHttp["pft"])and $arrHttp["pft"]!="") {
?> <script>
		xpft='<?php echo $arrHttp["pft"]?>'
		xDesc=xpft='<?php echo $arrHttp["desc"]?>'
		document.forma.nombre.value=xpft
		document.forma1.descripcion.value=
		msgwin=window.open("leertxt.php?base=<?php echo $arrHttp["base"]."&cipar=".$arrHttp["cipar"]?>&archivo="+xpft,"editar","menu=no, resizable, scrollbars,width=790")
		msgwin.focus()
	</script>
<?
  }
?>
<?php
if ($arrHttp["Opcion"]=="new")
	echo "\n<script>toggleLayer('pftedit')\n</script>\n"; ?>
