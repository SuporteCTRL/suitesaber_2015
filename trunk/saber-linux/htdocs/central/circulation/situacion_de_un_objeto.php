<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      situacion_de_un_objeto.php
 * @desc:      Checks an item status
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

include("../lang/prestamo.php");
include("../lang/admin.php");
include("../common/get_post.php");
$arrHttp["base"]="biblo";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13) EnviarForma()
    return true;
  }

function EnviarForma(){	if (Trim(document.searchBox.Expresion.value)=="" && Trim(document.inventorysearch.code.value)==""){		alert("<?php echo $msgstr["falta"]." ".$msgstr["control_n"]?>")
		return	}
	if (Trim(document.searchBox.Expresion.value)!=""){
		document.searchBox.submit()
	}else{		document.inventorysearch.submit()	}
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
		msgwin.focus()
}

function AbrirIndice(Ix,Ctrl){
	switch (Ix){		case "S":
			db="biblio"
			prefijo="ST_"
			AbrirIndiceAlfabetico(Ctrl,"ST_","","","loanobjects","biblo.par","3",1,"","v3^*,|.|v3^b,|.|v3^c,|.|v3^d")
			break
		case "I":

			AbrirIndiceAlfabetico(Ctrl,"CN_","","","loanobjects","copies.par","1",1,"","v1")
			break
	}
}

function PresentarDiccionario(){
		msgwin=window.open("","Diccionario","scrolling, height=400")
		ix=document.searchBox.indexes.selectedIndex
		if (ix<1){
			alert("<?php echo $msgstr["selcampob"]?>")
			return
		}
		sel=document.searchBox.indexes.options[ix].value
		t=sel.split('|')

		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Diccio.value="document.searchBox.searchExpr"
		document.diccionario.submit()
		msgwin.focus()
	}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["ecobj"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/object_statment.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/object_statment.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: situacion_de_un_objeto.php</font>\n";
?>
	</div>
<div class="middle list">
	<div class="searchBox">
	<form name=searchBox action="situacion_de_un_objeto_ex.php" method=post onsubmit="javascript:return false">
	<input type=hidden name=Opcion value=buscar>
	<input type=hidden name=base value=biblo>
	<input type=hidden name=desde value=1>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php //echo $msgstr["search"]?></strong>
		</label>
		</td><td>
<?php
$arrHttp["base"]="biblo";
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
?>
				<input type="hidden" name="Expresion" id="searchExpr" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';"
				value='<?php if (isset($arrHttp["Expresion"])) echo trim(stripslashes($arrHttp["Expresion_b"]))?>' />
<!--				<select name="indexes" class="textEntry">
					<option></option>
<?php

$fp=file($archivo);
foreach ($fp as $value){	$value=trim($value);
	$t=explode('|',$value);
	$xselected="";
	if (isset($arrHttp["Indice"])){
		if ($arrHttp["Indice"]==$t[1]) $xselected=" selected";
	}
	echo "<Option value='$value' $xselected>".trim($t[0])."\n";

}
?>
				</select>
				<input type="submit" name="ok" value="<?php echo $msgstr["index"]?>" class="submit" onClick=javascript:PresentarDiccionario() />
				<input type="submit" name="ok" value="<?php echo $msgstr["search"]?>" class="submit" onClick=javascript:document.diccionario.from.value=1;EnviarForma() />
  -->
		</td></table>
	</form>
	</div>
	<div class=\"spacer\">&#160;</div>
	<div class="searchBox">
	<form name=inventorysearch action="situacion_de_un_objeto_ex.php" method=post onsubmit="javascript:return false">
	<input type=hidden name=Opcion value=inventario>
	<input type=hidden name=base value=biblo>
	<input type=hidden name=desde value=1>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["control_n"]?></strong>
		</label>
		</td><td>
		<input type="text" name="code" id="searchExpr" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('I',document.inventorysearch.code)"/>
		<input type="submit" name="ok" value="<?php echo $msgstr["search"]?>" class="submit" onClick=EnviarForma() />
		</td></table>
	</form>
	</div>
</div>
<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=desde value=1>
</form>
<form name=diccionario method=post action=diccionario.php target=Diccionario>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
	<input type=hidden name=prefijo>
	<input type=hidden name=Formato>
	<input type=hidden name=campo>
	<input type=hidden name=id>
	<input type=hidden name=Diccio>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=Opcion value=diccionario>
	<input type=hidden name=Target value=s>
	<input type=hidden name=Expresion>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>