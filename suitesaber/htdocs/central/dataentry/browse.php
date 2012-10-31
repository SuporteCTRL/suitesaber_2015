<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      browse.php
 * @desc:      Browse database records
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
//
// SHOWS THE RECORD OF A DATABASE IN A TABLE VIEW
//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
include("../lang/dbadmin.php");

include("../lang/admin.php");
include("../lang/prestamo.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["Expresion"])){
	$arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
	$Expresion=trim($arrHttp["Expresion"]);
	$Expresion=str_replace("  "," ",$Expresion);
	$Expresion=str_replace("  "," ",$Expresion);
	$xor="�or�";
	$xand="�and�";
	$Expresion=str_replace (" {", "{", $Expresion);
	$Expresion=str_replace (" or ", $xor, $Expresion);
	$Expresion=str_replace ("+", $xor, $Expresion);
	$Expresion=str_replace (" and ", $xand, $Expresion);
	$Expresion=str_replace ("*", $xand, $Expresion);
	while (is_integer(strpos($Expresion,'"'))){
		$nse=$nse+1;
		$pos1=strpos($Expresion,'"');
		$xpos=$pos1+1;
		$pos2=strpos($Expresion,'"',$xpos);
		$subex[$nse]=trim(substr($Expresion,$xpos,$pos2-$xpos));
		if ($pos1==0){
			$Expresion="{".$nse."}".substr($Expresion,$pos2+1);
		}else{
			$Expresion=substr($Expresion,0,$pos1-1)."{".$nse."}".substr($Expresion,$pos2+1);
		}
	}

	$Expresion=str_replace(" ","*",$Expresion);
	while (is_integer(strpos($Expresion,"{"))){
		$pos1=strpos($Expresion,"{");
		$pos2=strpos($Expresion,"}");
		$ix=substr($Expresion,$pos1+1,$pos2-$pos1-1);
		if ($pos1==0){
			$Expresion=$subex[$ix].substr($Expresion,$pos2+1);
		}else{
			$Expresion=substr($Expresion,0,$pos1)." ".$subex[$ix]." ".substr($Expresion,$pos2+1);
		}
	}
	$Expresion=str_replace ("�", " ", $Expresion);
	$Expresion=urlencode($Expresion);
}

$base=$arrHttp["base"];
if (strpos($base,'^')===false){

}else{
	$b=explode('^',$base);
	$base=substr($b[1],1);
	$arrHttp["base"]=$base;
}
$Permiso=$_SESSION["permiso"];
if ($Permiso==""){
	echo "<br><br><h2>".$msgstr["menu_noau"]."<h2>";
	die;
}

if (isset($arrHttp["unlock"]) and $arrHttp["Mfn"]!="New"){
// if the record editing was cancelled unlock the record or keep deleted
	$query="";
    if (isset($arrHttp["unlock"])){
    	if (isset($arrHttp["Status"]) and $arrHttp["Status"]!=0)
    		$IsisScript=$xWxis."eliminarregistro.xis";
    	else
    		$IsisScript=$xWxis."unlock.xis";
    	$query = "&base=" . $arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"]. ".par&Mfn=" . $arrHttp["Mfn"]."&login=".$_SESSION["login"];
    	include("../common/wxis_llamar.php");
    	$res=implode("",$contenido);
    	$res=trim($res);
    }
}
if (!isset($arrHttp["from"])) $arrHttp["from"]=1;

$arrHttp["Mfn"]=1;
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/tb".$arrHttp["base"];
if (!file_exists($Formato.".pft")) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/tb".$arrHttp["base"];
$to=$arrHttp["from"]+29;
if (!isset($arrHttp["Expresion"])){
	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato&Opcion=buscar";
	$IsisScript=$xWxis."leer_mfnrange.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}else{
	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["from"]."&to=$to&Formato=$Formato".".pft&Expresion=".$Expresion;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}

include("../common/header.php");
?>
<script>
xEliminar="";
Mfn_eliminar=0;
function Browse(){
	if (Indices=="Y") document.browse.Expresion.value=""
	document.browse.submit();
}

function Editar(Mfn,Status){
	document.editar.Mfn.value=Mfn
	document.editar.Status.value=Status
	document.editar.Opcion.value="editar"
	document.editar.submit()
}

function Crear(){
	document.editar.Mfn.value="New"
	document.editar.Opcion.value="nuevo"
	document.editar.submit()
}

function EjecutarBusqueda(Accion){
	if (document.forma1.showdeleted.checked) {
		document.browse.showdeleted.value="yes"
	}
	switch (Accion){

		case "first":
			document.diccionario.from.value=1
			document.browse.from.value=1
			break
		case "previous":
               desde=desde-29
               if (desde<=0) desde=1
               document.diccionario.from.value=desde
               document.browse.from.value=desde
			break
		case "next":
			break
		case "last":
			desde=last-29
			if (desde<=0) desde=1
			document.diccionario.from.value=desde
			document.browse.from.value=desde
			break
	}
	if (Indices=="Y"){
		if (document.forma1.showdeleted.checked) {
			document.diccionario.showdeleted.value="yes"
		}
		ix=document.forma1.indexes.selectedIndex
		sel=document.forma1.indexes.options[ix].value
		t=sel.split('|')

        document.diccionario.target=""
        if (Indices=="Y") document.diccionario.Expresion.value=document.forma1.expre.value
        document.diccionario.action="browse.php"
		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Opcion.value="buscar"
		document.diccionario.submit()
	}else{
		if (Indices=="Y")document.diccionario.Expresion.value=document.forma1.expre.value
  		if (document.forma1.showdeleted.checked) {
			document.browse.showdeleted.value="yes"
		}
		document.browse.submit()
	}
}

function PresentarDiccionario(){
	msgwin=window.open("","Diccionario","scrolling, height=500,width=600")
	ix=document.forma1.indexes.selectedIndex
	if (ix<1){
		alert("<?php echo $msgstr["selcampob"]?>")
		return
	}
	sel=document.forma1.indexes.options[ix].value
	t=sel.split('|')

	document.diccionario.campo.value=escape(t[0])
	document.diccionario.prefijo.value=t[2]
	document.diccionario.id.value=t[1]
	document.diccionario.Diccio.value="document.forma1.expre"
	document.diccionario.submit()
	msgwin.focus()
}

/** Confirma��o antes de excluir 20121023 
	Adicionada a linha do if confirm **/
function Eliminar(Mfn){
if (confirm("<?php echo $msgstr["delitem"] ?>"+" "+Mfn)==true){

	xEliminar=""
	document.eliminar.Mfn.value=Mfn
	document.eliminar.submit()
	
	}
}
/** FIM Confirma��o antes de excluir **/
function Mostrar(Mfn){
	msgwin=window.open("show.php?base=<?php echo $arrHttp["base"]?>&cipar=<?php echo $arrHttp["base"]?>.par&Mfn="+Mfn+"&encabezado=s&Opcion=editar","show","width=600,height=400,scrollbars, resizable")
	msgwin.focus()
}
</script>
<?php
echo "<body>";
include("../common/institutional_info.php");
$encabezado="&encabezado=s";
?>
<form name=forma1 onsubmit="javascript:return false">
<div class="sectionInfo">
	<div class="language">

<?php
if (file_exists($db_path."/menu.dat")){
	MenuBrowse();
}else{



		if (!isset($arrHttp["return"])){
			$ret="../common/inicio.php?reinicio=s$encabezado";
			if (isset($arrHttp["modulo"])) $ret.="&modulo=".$arrHttp["modulo"];
			if (isset($arrHttp["base"])) $ret.="&base=".$arrHttp["base"];
		}else{
			$ret=str_replace("|","?",$arrHttp["return"])."$encabezado=".$arrHttp["encabezado"];
		}
	?>
		
		<a href="<?php echo $ret?>" class="defaultButton"><span><strong><?php echo $msgstr["back"]?></strong></span></a>
		
		
		<a href="javascript:Crear()" class="defaultButton"><span><strong><?php echo $msgstr["crear"]?></strong></span></a>
		


<?php }?>
	<div class="actions">

	</div>
</div>

<div class="breadcrumb">
		<?php echo $msgstr["admin"]." (".$arrHttp["base"],")"?>
		    <span><input type=checkbox name=showdeleted value=show
                <?php if (isset($arrHttp["showdeleted"])) echo " ";
                	echo ">".$msgstr["showdelrec"]?></span>
</div>



<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/admin.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: browse.php</font>";
?>
</div>
		<div class="middle list">
<?php
$ad_s="";  // Hay formulario de b�squeda avanzada?
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/camposbusqueda.tab";
if (file_exists($archivo)){
	$ad_s="S";
	echo "<Script>Indices='Y'</script>\n" ;
?>


		<div class="searchBox">
				<label for="searchExpr">
					<strong><?php echo $msgstr["buscar"]?></strong>
				</label>
				<input type="text" name="expre" id="Expre" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';"
				value='<?php if (isset($arrHttp["Expresion"])) echo $arrHttp["Expresion"]?>' />
				<select name="indexes" class="textEntry">
					<option></option>
<?php

	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			$xselected="";
			if (isset($arrHttp["Indice"])){
				if ($arrHttp["Indice"]==trim($t[1])) $xselected=" selected";
			}
			echo "<Option value='$value' $xselected>".$t[0]."\n";
		}

	}
?>
				</select>

				<input id="botoes" type="button" name="ok" value="<?php echo $msgstr["index"]?>" xclass="submit" onClick=javascript:PresentarDiccionario() />
				<input  type="submit"  name="ok" value="<?php echo $msgstr["buscar"]?>" class="submit" onClick=javascript:document.diccionario.from.value=1;EjecutarBusqueda() />
				<?php if (isset($arrHttp["Expresion"]))
					echo "\n<input type=\"submit\" name=\"ok\" value=\"".$msgstr["bmfn"]."\"  onClick=javascript:Browse() />"
				?>
				<input type=hidden name=Target value=S>


		</div>
<?php }else{
	echo "<Script>Indices='N'</script>\n" ;
}
echo " </form>\n";
echo "
			<table class=\"listTable\">
				<tr>
					<th>&nbsp;</th>
	";
// se lee la tabla con los t�tulos de las columnas
$archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/tbtit.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/tbtit.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/tb".$arrHttp["base"]."_h.txt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/tb".$arrHttp["base"]."_h.txt";
if (file_exists($archivo)){
	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if (!empty($value)) {
			$t=explode('|',$value);
			foreach ($t as $rot) echo "<th>$rot</th>";
		}
	}
}
echo "<th class=\"action\">&nbsp;</th></tr>";
foreach ($lista_users as $value){
	$value=trim($value);
	if ($value!=""){
		$u=explode('|',$value);
		$Mfn=$u[0];
		$Status=$u[1];
		if ($Status=="") $Status=0;
		$desde=$u[2];
		$hasta=$u[3];
		unset($arrHttp["showdeleted"]);
		if (($Status==0 or $Status==-2) or (isset($arrHttp["showdeleted"]) and $Status==1)){
			echo "<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
			echo "<td>".$u[2]."/",$u[3];
			if ($Status==1) echo "<img src=\"../images/delete.png\" align=absmiddle alt=\"excluir base de dados\" title=\"excluir base de dados\" />";
			echo "</td>";
			for ($ix=4;$ix<count($u);$ix++) echo "<td>" .$u[$ix]."</td>";
			echo "<td class=\"action\" nowrap>
				<a id=botoes href=javascript:Editar($Mfn,$Status)>
				".$msgstr["edit"]."</a>
				<a id=botoes href=javascript:Mostrar(".$Mfn.")>".$msgstr["show"]."</a>";
			if ($Status==0) echo "
				<a id=botoes href=\"javascript:Eliminar($Mfn)\">".$msgstr["eliminar"]."</a>";
			else {
				switch ($Status){
					case -2:
						echo $msgstr["recblock"];
						break;
					case 1:
						echo $msgstr["recdel"];
						break;
				}
			}
			echo "</td>";
			echo "</tr>";
		}
	}
}
echo "			</table>";

?>			<div class="tMacroActions">
				<div class="pagination">
					<a id="botoes_top" href="javascript:EjecutarBusqueda('first')" class="singleButton eraseButton">
						<span>&#160;</span>
						&#171; <?php echo $msgstr["first"]?>
						<span>&#160;</span>
					</a>
					<a id="botoes_top" href="javascript:EjecutarBusqueda('previous')" class="singleButton eraseButton">
						<span>&#160;</span>
						&#171; <?php echo $msgstr["previous"]?>
						<span>&#160;</span>
					</a>
					<a id="botoes_top"  href="javascript:EjecutarBusqueda('next')" class="singleButton eraseButton">
						<span >&#160;</span>
						&#187; <?php echo $msgstr["next"] ?>
						<span>&#160;</span>
					</a>
					<a id="botoes_top" href="javascript:EjecutarBusqueda('last')" class="singleButton eraseButton">
						<span>&#160;</span>
						&#187; <?php echo $msgstr["last"]?>
						<span>&#160;</span>
					</a>
					<div class="spacer">&#160;</div>
				</div>
				<div class="spacer">&#160;</div>
			</div>
		</div>
<?php
echo "</div></div>";
include("../common/footer.php");
echo "
 <form name=eliminar method=post action=eliminar_registro.php>
 <input type=hidden name=base value=".$arrHttp["base"].">
 <input type=hidden name=from value=".$arrHttp["from"].">
 <input type=hidden name=retorno value=browse.php?base=".$arrHttp["base"]."&modulo=loan>\n ";
 if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
 echo "<input type=hidden name=Mfn>\n";
 if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
 if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
 $desde=$desde+1;
echo "</form>
<form name=diccionario method=post action=diccionario.php target=Diccionario>
	<input type=hidden name=showdeleted>
	<input type=hidden name=base value=".$arrHttp["base"].">
	<input type=hidden name=cipar value=".$arrHttp["base"].".par>
	<input type=hidden name=prefijo>
	<input type=hidden name=Formato>
	<input type=hidden name=campo>
	<input type=hidden name=id>
	<input type=hidden name=Diccio>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=Opcion value=diccionario>
	<input type=hidden name=Target value=s>
	<input type=hidden name=Expresion>
	<input type=hidden name=Tabla value=browse>
</form>
<form name=browse method=post action=browse.php>
	<input type=hidden name=showdeleted>
	<input type=hidden name=base value=".$arrHttp["base"].">
	<input type=hidden name=cipar value=".$arrHttp["base"].".par>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=to>";
if (isset($arrHttp["encabezado"])){
	echo "<input type=hidden name=encabezado value=s>\n";
}
if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"])."\">\n";
echo "</form>
<form name=editar method=post action=fmt.php>
	<input type=hidden name=from value=".$arrHttp["from"].">
	<input type=hidden name=base value=".$arrHttp["base"].">
	<input type=hidden name=cipar value=".$arrHttp["base"].".par>
	<input type=hidden name=modulo value=".$arrHttp["modulo"].".par>
    <input type=hidden name=Mfn>
    <input type=hidden name=Status>
    <input type=hidden name=retorno value=browse.php>
    <input type=hidden name=Opcion value=editar>
    <input type=hidden name=encabezado value=s>
";
if (isset($arrHttp["encabezado"])){
	echo "<input type=hidden name=encabezado value=s>\n";
}
if (isset($arrHttp["return"])){
	echo "<input type=hidden name=return value=".$arrHttp["return"].">\n";
}
if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
echo "</form>
	</body>
</html>
<script>
	first=1
	last=$hasta
	desde=$desde
</script>
";

function MenuBrowse(){
global $msgstr,$arrHttp,$ret;
	echo "<div class=\"actions\">";

		if (!isset($arrHttp["return"])){
			$ret="../inicio.php?reinicio=s$encabezado";
			if (isset($arrHttp["base"])) $ret.="&base=".$arrHttp["base"];
		}else{
			$ret=str_replace("|","?",$arrHttp["return"])."&encabezado=".$arrHttp["encabezado"];
		}
	?>
		<a href=<?php echo $ret?>><?php echo $msgstr["back"]?></a> |
		<a href="javascript:Crear()"><?php echo $msgstr["crear"]?></a> |
		<a href="javascript:Generar()"><?php echo "Gerar Agenda"?>
		</a>
        &nbsp; &nbsp; &nbsp;
	</div>

<?php
}

?>
