<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      typeofrecs.php
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
include("../common/header.php");
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<script>
	function SendForm(wks){
		if (check==""){
			return
		document.forma1.format.value=check
		document.forma1.wks.value=wks
		document.forma1.submit()

</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["recval"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
<?php echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
?>
		
		<span><strong><?php echo $msgstr["cancel"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/recval.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 	<a href=../documentacion/edit.php?archivo=<?php echo $_SESSION["lang"]?>/recval.html target=_blank><?php echo $msgstr["edhlp"]?></a>
<?php echo "&nbsp; &nbsp; Script: typeofrecs.php" ?></font>
	</div>
<div class="middle form">
	<div class="formContent">
<?
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
unset($fp);
$tr=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($tr))  $tr=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
if (file_exists($tr)) $fp=file($tr);
?>
<div class="middle form">
			<div class="formContent">
<center>
<form name=validation>
<h3>
<input type=radio name=format value=recval><?php echo $msgstr["recval"]?>&nbsp;
<input type=radio name=format value=beginf><?php echo $msgstr["beginf"]?>&nbsp;
<input type=radio name=format value=endf><?php echo $msgstr["endf"]?></h3>
<h3><?php echo $msgstr["typeofrecords"]?></h3>
<table>
<?php
$ix=0;
$tr="";
$nr="";
if (isset($fp)){
	foreach($fp as $value){
		$value=trim($value);
		if ($value!=""){
				if (isset($ttm[1])) $nr=trim($ttm[1]);
				$ix=1;
				$ttm=explode('|',$value);
				echo "<tr><td><a href='javascript:SendForm(\"".urlencode($value)."\")'>".$ttm[3]."</a></td>\n";
			}
		}
	}
}
echo "<tr><td><a href='javascript:SendForm(\"\")'>".$msgstr["1recval"]."</a></td>\n";
?>
</table>
</form>
<form name=forma1 action=recval.php method=post>
<input type=hidden name=base value=<?php echo $arrHttp["base"].">\n";
if ($encabezado=="&encabezado=s")
 echo "<input type=hidden name=encabezado value=s>\n";
?>
<input type=hidden name=wks>
<input type=hidden name=format value="">
</form>
</center>
</div>
</div></div>
<?php include ("../common/footer.php");?>
</body></html>