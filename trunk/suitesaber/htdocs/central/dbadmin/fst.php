<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/get_post.php");

if (file_exists($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst")){
	$arrHttp["Opcion"]="update";
}else{
	$arrHttp["Opcion"]="new";
}
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
include("../common/header.php");
?>
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid.css">
<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXGrid_skins.css">
<script  src="../dataentry/js/dhtml_grid/dhtmlXCommon.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGridCell.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_drag.js"></script>
<script  src="../dataentry/js/dhtml_grid/dhtmlXGrid_excell_link.js"></script>
<script  src="../dataentry/js/lr_trim.js"></script>
<script languaje=javascript>
		pl_type=""
		Opcion="<?php echo $arrHttp["Opcion"]?>"
		valor=""
		prefix=""
		fila=""
		columna=11

		function Asignar(){
			mygrid.cells2(fila,columna).setValue(valor)
			mygrid.cells2(fila,12).setValue(prefix)
			closeit()
		}
		function Capturar_Grid(){
			cols=mygrid.getColumnCount()
			rows=mygrid.getRowsNum()
			VC=""
			for (i=0;i<rows;i++){
				if (Trim(mygrid.cells2(i,0).getValue())!=""){
					if (VC!="") VC=VC+"\n"
					for (j=0;j<cols;j++){
						cell=mygrid.cells2(i,j).getValue()
						if (j!=13) VC=VC+cell+' '
					}
				}
			}
			return VC

		}


		function Enviar(){
            <?php if ($arrHttp["Opcion"]=="new") echo "document.forma1.action.value='pft.php'\n"?>
			document.forma1.ValorCapturado.value=Capturar_Grid()
			document.forma1.submit()
		}

		function Test(){
			if (Trim(document.fst.Mfn.value)==""){
				alert("<?php echo $msgstr["mismfn"]?>")
				return
			}
			msgwin=window.open("","FST_Test")
			msgwin.document.close()
			msgwin.focus()
			document.test.Mfn.value=document.fst.Mfn.value
			document.test.ValorCapturado.value=Capturar_Grid()
			document.test.submit()

		}
                function doBeforeRowDeleted(rowId){
                        VC=""
                        for (j=0;j<3;j++){
                                  cell=mygrid.cells(rowId,j).getValue()
                                  VC=VC+cell
                        }
                        if (VC=="")
                                  return true
                        else
                                  return confirm("<?php echo $msgstr["arysure"]?>");
                }
	</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "<form name=fst method=post>";
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["fst"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">";
if ($arrHttp["Opcion"]=="new"){
	if (isset($arrHttp["encabezado"])){
		echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton cancelButton\">";
	}else{
		echo "<a href=menu_creardb.php class=\"defaultButton cancelButton\">";
	}

}else{
	echo "<a href=\"menu_modificardb.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">";
}
echo "
	<span><strong>".$msgstr["cancel"]."</strong></span></a>";
if ($arrHttp["Opcion"]=="new"){
	echo "<a href=fdt.php?Opcion=new&base=".$arrHttp["base"]."$encabezado class=\"defaultButton backButton\">
	
	<span><strong>".$msgstr["back"]."</strong></span></a>";
}
//echo "<a href=javascript:Enviar() class=\"defaultButton saveButton\">
//	
//	<strong>".$msgstr["update"]."</strong></a>";
?>
</div><div class="spacer">&#160;</div></div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/fst.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/fst.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: fst.php";
?>
</font>
	</div>
<div class="middle form">
			<div class="formContent">
<table width=100% border=0>
   	<td width=680 valign=top >
   		<table>
	        <tr>
			<td>
				<a href="javascript:void(0)" onclick="mygrid.addRow((new Date()).valueOf(),['','',''],mygrid.getRowIndex(mygrid.getSelectedId()))"><?php echo $msgstr["addrowbef"]?></a>
				&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick="mygrid.deleteSelectedItem()"><?php echo $msgstr["remselrow"]?></a>
			<!--	&nbsp; &nbsp; &nbsp;<a href="javascript:void(0)" onclick=Organize()>Organize FST</a>--><br>
			</td>
			<tr>
				<td valign=top>
					<div id="gridbox" width="650px" height="250px" style="left:0;top:0;background-color:white;overflow:hidden"></div>
				</td>

			</tr>
			<tr>
				<td>
					<?php if ($arrHttp["Opcion"]!="new"){
						echo $msgstr["testmfn"];
						echo "<input type=text size=5 name=Mfn><a href=javascript:Test()>".$msgstr["test"]."</a>  &nbsp; &nbsp;";
						}

					?>
						 <a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>  &nbsp; &nbsp;
					<?
					if ($encabezado=""){
						if ($arrHttp["Opcion"]!="new")
							echo "<a href=menu_modificardb.php?base=". $arrHttp["base"].">".$msgstr["cancel"]."</a>";
				  		else
				    		echo "<a href=menu_creardb.php>".$msgstr["cancel"]."</a>";
					}
					?>
	 			</td>
			</tr>
		</table>
	</td>
	<td valign=top><iframe id="cframe" src="fdt_leer.php?Opcion=<?php echo $arrHttp["Opcion"]?>&base=<?php echo $arrHttp["base"]?>" width=100% height=400 scrolling=yes name=fdt></iframe>
	</td>
		</table>
	</td>
</table>
<script>
	mygrid = new dhtmlXGridObject('gridbox');
   mygrid.setSkin("modern");
   // mygrid.enableMultiline(true);

	mygrid.setImagePath("../imgs/");

	mygrid.setHeader("<?php echo $msgstr["id"]?>,<?php echo $msgstr["intec"]?> ,<?php echo $msgstr["formate"]?>");
	mygrid.setInitWidths("40,100,500")
	mygrid.setColAlign("left,left,left")
	mygrid.setColTypes("ed,coro,ed");
	mygrid.getCombo(1).put("","");
	mygrid.getCombo(1).put("0","<?php echo $msgstr["fst_0"]?>");
	mygrid.getCombo(1).put("1","<?php echo $msgstr["fst_1"]?>");
	mygrid.getCombo(1).put("2","<?php echo $msgstr["fst_2"]?>");
	mygrid.getCombo(1).put("3","<?php echo $msgstr["fst_3"]?>");
	mygrid.getCombo(1).put("4","<?php echo $msgstr["fst_4"]?>");
	mygrid.getCombo(1).put("5","<?php echo $msgstr["fst_5"]?>");
	mygrid.getCombo(1).put("6","<?php echo $msgstr["fst_6"]?>");
	mygrid.getCombo(1).put("7","<?php echo $msgstr["fst_7"]?>");
	mygrid.getCombo(1).put("8","<?php echo $msgstr["fst_8"]?>");
	mygrid.setColSorting("int,int")
    mygrid.enableAutoHeigth(true,300);
    mygrid.setOnBeforeRowDeletedHandler(doBeforeRowDeleted);

    mygrid.enableDragAndDrop(true);
	//mygrid.enableLightMouseNavigation(true);
	//mygrid.enableMultiselect(false);

	mygrid.init();
    i=-0

<?  $i=-1;
	unset($fp);
	if ($arrHttp["Opcion"]=="update"){
		$fp=file($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst");
		$t=array();
	}else{
		if (isset($_SESSION["FST"])){
            $_SESSION["FST"].="\n";
			$fp=explode("\n",$_SESSION["FST"]);
		}
	}
	if (isset($fp)){
		foreach ($fp as $value){
			if (!empty($value)) {
				$ix=strpos($value," ");
				$t[0]=trim(substr($value,0,$ix));
				$value=trim(substr($value,$ix));
				$ix=strpos($value," ");
				$t[1]=trim(substr($value,0,$ix));
				$t2=htmlspecialchars_decode (trim(substr($value,$ix+1)));
				$t[2]=str_replace("'","\'",trim(substr($value,$ix+1)));
				$i++;
				echo "i=$i\n
				id=(new Date()).valueOf()
				mygrid.addRow(id,['".trim($t[0])."','".trim($t[1])."','".trim($t[2])."'],i)\n
				mygrid.setRowTextStyle( id,\"font-family:courier new;\")\n ";
			}
		}
   }
?>
	i++
	for (j=i;j<i+30;j++){
		mygrid.addRow((new Date()).valueOf(),['','',''],j)
	}


	mygrid.clearSelection()
	mygrid.setSizes();
</script>


</form>
<form name=forma1 action=fst_update.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
</form>
<form name=test action=fst_test.php method=post target="FST_Test">
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Mfn>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
</form>
</div></div>
<?php
include("../common/footer.php");
?>
</body>
</html>
