<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      estado_de_cuenta.php
 * @desc:      loan history
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
include("../lang/admin.php");
include("../lang/prestamo.php");
include("../common/get_post.php");
$arrHttp["base"]="users";
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
	if (c==13) EnviarForma("")
    return true;
  }

function EnviarForma(Proceso){	if (Trim(document.usersearch.code.value)=="" && Trim(document.inventorysearch.inventory.value)==""){		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]."/".$msgstr["inventory"]?>")
		return	}
	if (Proceso==""){
		if (Trim(document.usersearch.code.value)!=""){
			document.EnviarFrm.usuario.value=document.usersearch.usercode.value
			document.EnviarFrm.action="usuario_prestamos_presentar.php"
		}else{
			if (Trim(document.inventorysearch.inventory.value)!=""){
				document.EnviarFrm.inventory.value=document.inventorysearch.inventory.value
				document.EnviarFrm.action="numero_inventario.php"
			}
		}
	}else{
		switch (Proceso){			case "U":
				document.EnviarFrm.usuario.value=document.usersearch.usercode.value
				document.EnviarFrm.action="usuario_prestamos_presentar.php"
				break
			case "I":
				document.EnviarFrm.inventory.value=document.inventorysearch.inventory.value
				document.EnviarFrm.action="numero_inventario.php"
				document.EnviarFrm.submit()
				break		}
	}
	document.EnviarFrm.submit()
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

function AbrirIndice(TipoI,Ctrl){

	switch (TipoI){
		case "U":
			db="users"
			prefijo="NO_"
			AbrirIndiceAlfabetico(Ctrl,"NO_","","","users","users.par","30",1,"","v30,`$$$`,if p(v20) then v20 else v35 fi")
			break
 		case "I":
			db="trans"
			prefijo="!Z"
   			AbrirIndiceAlfabetico(Ctrl,"TR_P","","","trans","trans.par","10",1,"","v10,`$$$`,v10")
			break
	}
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
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/loans/user_statment.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/loans/user_statment.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: estado_de_cuenta.php</font>\n";
?>
	</div>
<div class="middle list">
	<div class="searchBox">
	<form name=usersearch action="" method=post onsubmit="javascript:return false">
	<input type=hidden name=Indice>
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td><td>
		<input type="text" name="usercode" id="code" value="<?php if (isset($arrHttp["usuario"])) echo $arrHttp["usuario"]?>" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="index" value="<?php echo $msgstr["list"]?>" class="submit" onClick="javascript:AbrirIndice('U',document.usersearch.usercode)" />
		<input type="button" name="buscar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma('U')"/>
		</td></table>
	</form>
	</div>
	<div class=\"spacer\">&#160;</div>
	<div class="searchBox">
	<strong><i><?php echo $msgstr["ec_inv"]?></i></strong>
	<form name=inventorysearch action=numero_inventario.php method=post onsubmit="javascript:return false">
	<table width=100%>
		<td width=100>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td>
		<input type="text" name="inventory" id="searchExpr" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />

		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('I',document.inventorysearch.inventory)"/>
		<input type="button" name="buscar" value="<?php echo $msgstr["search"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma('I')"/>
		</td></table>
	</form>
	</div>
	<br><br><dd>
		<?php echo $msgstr["clic_en"]." <i>".$msgstr["search"]."</i> ".$msgstr["para_c"]?>
</div>
<form name=EnviarFrm method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=usuario value="">
<input type=hidden name=inventory>
</form>
<?php include("../common/footer.php");
echo "</body></html>" ;
if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){	echo "
	<script>
	alert('".$arrHttp["inventory"].": ".$msgstr["inventory"]." ".$msgstr["noloan"]."')
	</script>
	";}
?>