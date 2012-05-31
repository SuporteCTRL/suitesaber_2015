<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)echo "$var=$value<br>";
if (strpos($arrHttp["picklist"],"%path_database%")===false){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["picklist"];
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["picklist"];
}else{
	$archivo=str_replace("%path_database%",$db_path,$arrHttp["picklist"]);
}

//echo $archivo;
include("../common/header.php");
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<script>
	function Enviar(){
		cols=mygrid.getColumnCount()
		rows=mygrid.getRowsNum()
		VC=""
		for (i=0;i<rows;i++){
			lineat=""
			for (j=0;j<cols;j++){
				cell=mygrid.cells2(i,j).getValue()
				if (cell.indexOf('|')!=-1){
					fila=i+1
					columna=j+1
					alert('<?php echo $msgstr["invalpipe"]?> '+fila+', col. '+columna)
					return
				}
				if (j==0)
					lineat=cell
	            else
					lineat=lineat+'|'+cell
			}
			if (lineat!="|" && lineat!="||"){
				if (VC=="")
					VC=lineat
				else
					VC+="\n"+lineat
			}
		}
		document.forma2.ValorCapturado.value=VC
		document.forma2.submit()
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid.css">
	<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid_skins.css">
	<script  src="../dataentry/js/dhtml_grid/dhtmlXCommon.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGridCell.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_drag.js"></script>
	<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_excell_link.js"></script>
<?php
echo "
	<div class=\"sectionInfo\"></div>
			<div class=\"breadcrumb\"><h3>".
				$msgstr["picklist"]. ": " . $arrHttp["base"]." - ".$arrHttp["picklist"]."
			</h3></div>
			<div class=\"actions\"><br><br><br>

	";
if (isset($arrHttp["desde"]) and $arrHttp["desde"]=="fixed_marc"){
	echo "<a href=\"fixed_marc.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton\">";
}else{
	 echo "<a  href=\"picklist.php?base=". $arrHttp["base"]."&row=".$arrHttp["row"]."&picklist=".$arrHttp["picklist"]."\" class=\"defaultButton\">";
}

	echo "<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>";
	echo "<a href=\"javascript:Enviar()\" class=\"defaultButton\">";
	echo "
	
					<span><strong>". $msgstr["save"]."</strong></span>
				</a>";
echo "			</div>
	

<div class=\"helper\">
<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/picklist_tab.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: picklist_edit.php" ;


?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
	<table width="100%">

        <tr>
        	<td>
        		<b><?php echo $msgstr["picklistname"].": " .$arrHttp["picklist"]?></b> &nbsp; &nbsp;
        </td>
        <tr>
		<td>
			<a id="botoes" href="javascript:void(0)" onclick="mygrid.addRow((new Date()).valueOf(),['',''],mygrid.getRowIndex(mygrid.getSelectedId()))"><?php echo $msgstr["addrowbef"]?></a>
			&nbsp;<a id="botoes" href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>
		<br>
		</td>
		<tr>
			<td>
				<div id="gridbox" xwidth="780px" height="200px" style="background-color:white;overflow:hidden"></div>
			</td>

		</tr>
		<tr>
			<td>
 			</td>
		</tr>
	</table>
<script>
	<?php echo "type=\"".$arrHttp["picklist"]."\"\n"?>
	mygrid = new dhtmlXGridObject('gridbox');

    //mygrid.setSkin("xp");
   // mygrid.enableMultiline(true);

	mygrid.setImagePath("../imgs/");
    if (type=="ldr_06.tab"){
		mygrid.setHeader("Code, Term, Fixed field structure");
		mygrid.setInitWidths("70,380,100")
		mygrid.setColAlign("left,left,left")
		mygrid.setColTypes("ed,ed,ed");
		mygrid.setColSorting("str,str,str")
	}else{
	    mygrid.setHeader("Code, Term");
		mygrid.setInitWidths("70,280")
		mygrid.setColAlign("left,left")
		mygrid.setColTypes("ed,ed");
		mygrid.setColSorting("str,str")
    }
    mygrid.enableAutoHeigth(true,300);

    mygrid.enableDragAndDrop(true);
	//mygrid.enableLightMouseNavigation(true);
	//mygrid.enableMultiselect(false);
	mygrid.enableAutoWidth(true);

	mygrid.init();
<?
	if (file_exists($archivo)){
		$fp=file($archivo);
		$i=-1;
		$t=array();
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$t=explode('|',$value);
				$i++;
				echo "i=$i\n";
                if (!isset($t[2]) and $arrHttp["picklist"]=="ldr_06.tab") $t[2]="";
				echo "mygrid.addRow((new Date()).valueOf(),['".trim($t[0])."','".trim($t[1])."','".trim($t[2])."'],i)\n";
			}
		}
	}else{
		echo"
		for (i=0;i<30;i++)
			mygrid.addRow((new Date()).valueOf(),['','',''],i)\n";
 	}
?>
	i++
	for (j=i;j<i+10;j++){
		mygrid.addRow((new Date()).valueOf(),['','',''],j)
	}


	mygrid.clearSelection()
	mygrid.setSizes();
    </script>
<br><br>
</form>
<form name=forma2 action=picklist_save.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=picklist value=<?php echo $arrHttp["picklist"]?>>
<input type=hidden name=row value=<?php echo $arrHttp["row"]?>>
<?php if (isset($arrHttp["desde"])) echo "<input type=hidden name=desde value=".$arrHttp["desde"].">\n";
if (isset($arrHttp["encabezado"]))  echo "<input type=hidden name=encabezado value=".$arrHttp["encabezado"].">\n";
?>
</form>
</div>
</div>
<?php include("../common/footer.php"); ?>
