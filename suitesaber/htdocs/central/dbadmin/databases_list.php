<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      databases_list.php
 * @desc:      
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
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");

?>
<link rel=stylesheet href=../css/styles.css type=text/css>
<script language=Javascript src=../dataentry/js/selectbox.js></script>
<script language=Javascript src=../dataentry/js/lr_trim.js></script>
<script>
function Editar(){
	msgwin=window.open("editararchivotxt.php?archivo=bases.dat&desde=menu$encabezado&desde=menu","editpar","width=700, height=600, resizable, scrollbars")
	msgwin.focus()

}
function Enviar(){
	ValorCapturado=""
	for (i=0;i<document.forma1.lista.options.length;i++){
		a= Trim(document.forma1.lista.options[i].value)
		if (a!="") {
			if (ValorCapturado=="")
				ValorCapturado=a
			else
			    ValorCapturado+="\n"+a
		}
	}
	document.forma1.txt.value=ValorCapturado
	document.forma1.submit()
}
</script>
</head>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
<div class="language">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton\">";
?>
		
		<span><strong><?php echo $msgstr["cancel"]?></strong></span></a>
</div>
</div>
	<div class="breadcrumb">
<h3><?php echo $msgstr["dblist"].": ".$arrHttp["base"]?></h3>
	</div>
	<div class="actions">

	</div>


<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/databases_list.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/databases_list.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; Script: databases_list.php";
?>

	</div>
<div class="middle form">
	<div class="formContent">
<form name=forma1 action=actualizararchivotxt.php method=post onsubmit='javascript:return false'>
<input type=hidden name=txt>
<input type=hidden name=archivo value='<?php echo "bases.dat"?>'>
<input type=hidden name=base value='<?php echo $arrHttp["base"]?>'>
<?php if (isset($arrHttp["encabezado"]))
       echo "<input type=hidden name=encabezado value=s>";
?>
<br><center>
<table border=0>
	<tr>
		<td valign=center>
   			<INPUT id="ajuda" TYPE="button" VALUE="&#9652;" onClick="moveOptionUp(this.form['lista'])">
			<BR><BR>
			<INPUT id="ajuda" TYPE="button" VALUE="&#9662;" onClick="moveOptionDown(this.form['lista'])">
   		</td>
		<td>
			<select name=lista size=20>
<?
$fp=file($db_path."bases.dat");
foreach ($fp as $value){
	if (!empty($value)) {
		$b=explode('|',$value);
		echo "<option value='$value'>".$b[1]." (".$b[0].")</option><br>";
	}
}

?>


			</select>
		</td>
</table>
<input id=botoes type=submit value=<?php echo $msgstr["update"]?> onClick=javascript:Enviar()> &nbsp; &nbsp;
<input id=botoes type=submit value=<?php echo $msgstr["edit"]?> onClick=javascript:Editar()>
&nbsp; <input id=botoes type=submit value="<?php echo $msgstr["cancel"]?>" onClick="document.cancelar.submit();return false">
</form>
<form name=cancelar method=post action=menu_modificardb.php>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<?php if (isset($arrHttp["encabezado"]))
	echo "<input type=hidden name=encabezado value=s>
	";
?>
</form>
</center>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>
