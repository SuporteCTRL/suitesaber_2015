<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      prestar.php
 * @desc:      Ask for the inventory number and the user code for processing a loan
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
if (file_exists($db_path."loans.dat"))	echo "<script>search_in='IN='\n";
else
    echo "<script>search_in=''\n";
echo "</script>\n";

?>
<script src=../dataentry/js/lr_trim.js></script>
<script>


function EnviarForma(){
	if (Trim(document.inventorysearch.inventory.value)=="" || Trim(document.inventorysearch.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]." / ".$msgstr["usercode"]?>")
		return
	}
    document.inventorysearch.submit()}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"

	switch (Tipo){		case "I":
			Separa=""
			ancho=200
			if (search_in==""){
    			Prefijo=Separa+"&prefijo=IN_"
				url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato=@autoridades.pft"
			}else{
				ix=document.inventorysearch.db.selectedIndex
				sel=document.inventorysearch.db.options[ix].value
				s=sel.split('|')
				bd=s[0]
				pref="IN_"				Prefijo=Separa+"&prefijo="+pref
				url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato=@autoridades.pft"			}
			break
		case "U":
			Separa=""
			Formato="v30,`$$$`,if a(v20) then v35 else v20 fi"
    		Prefijo=Separa+"&prefijo=NO_"
    		ancho=200
			url_indice="capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
			break	}
	msgwin=window.open(url_indice,"Indice","width=480, height=425,scrollbars")
	msgwin.focus()
}

</script>
<?php
$encabezado="";
echo "<body onLoad=javascript:document.inventorysearch.inventory.focus()>\n";
include("../common/institutional_info.php");
$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["loan"];
		  if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") echo " - ".$msgstr["users"].": ".$arrHttp["usuario"];
		?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/loan.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/loan.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: prestar.php </font>
	</div>";
// prestar, reservar o renovar
?>


<form name=inventorysearch action=usuario_prestamos_presentar.php method=post onsubmit="javascript:return false">
<input type=hidden name=Opcion value=prestar>
<div class="middle list">
	<div class="searchBox">
<?php
//READ BASES.DAT TO FIND THOSE DATABASES NOT WORKING WITH COPIES DATABASES
if (file_exists($db_path."loans.dat")){	$fp=file($db_path."loans.dat");
?>
	<div class="searchBox">
	<table width=100% border=0>
		<td width=150>
		<label for="dataBases">
			<strong><?php echo $msgstr["basedatos"]?></strong>
		</label>
		</td><td>
		<select name=db>
<?php
	foreach ($fp as $value){		$v=explode('|',$value);		echo "<option value='$value'>".$v[1]."</option>";	}
?>
		</select>
		</td>
	</table>
	</div>
<?php }?>

	<div class="searchBox">
		<table width=100% border=0>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["usercode"]?></strong>
		</label>
		</td>
		<td>
		<input type="text" name="usuario" id="usuario" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry'; "
<?php
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
	echo "value=\"".$arrHttp["usuario"]."\"";
?>/>
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('U',document.inventorysearch.usuario)"/>
		<input type="submit" name="prestar" value="<?php echo $msgstr["loan"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>

		</td></table>
        <?php echo $msgstr["clic_en"]." <i>[".$msgstr["loan"]."]</i> ".$msgstr["para_c"]?>

	</div>
	<div class="searchBox">
	<table width=100% border=0>
		<td width=150>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td>
		<input type="text" name="inventory" id="inventory" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" />
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndice('I',document.inventorysearch.inventory);return false"/>
		</td>
	</table>
	</div>


	</div>
</div>

</form>
<?php include("../common/footer.php");
echo "</body></html>" ;

?>