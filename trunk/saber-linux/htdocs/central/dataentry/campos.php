<?php  session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");

include ("../lang/admin.php");
include("../common/header.php");
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
echo "<script>\n";
echo "PickList=new Array()\n";
if (!isset($arrHttp["wks"])) $arrHttp["wks"]=$arrHttp["base"].".fdt";

// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeraci�n autom�tica y el prefijo con el cual se indiza el n�mero de control
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["wks"];
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["wks"];
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo $arrHttp["falta"].": ".$archivo;
		    die;
		 }
	}
	$found=false;
	$ix=-1;

	foreach ($fp as $linea){
		if (trim($linea)!=""){
			if ($l[1]==$arrHttp["tag"] or $found==true){
				$found=true;
				if ($ix==-1){
					$ix=0;
					$ix++;
					if ($l[0]=="S") {
	                    $Ind="";
	                    if ($ind_sc<2){
	                    	if (substr($subc,$ind_sc,1)==1 or substr($subc,$ind_sc,1)==2)
	                    		$Ind="I";
	                    }
	                    $key=$Ind.substr($subc,$ind_sc,1);
							PickList($key,$l[11]);
							$l=$ix-1;
			}
	}
echo "</script>\n";

?>

input 		{BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000; BORDER-BOTTOM-COLOR: #000000; BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; FONT-FAMILY: Arial,Helvetica; BORDER-RIGHT-WIDTH: 1px}
<script language=JavaScript src=js/terminoseleccionado.js></SCRIPT>
	base=window.opener.top.base
	url_indice=""
	Ctrl_activo=""
	lista_sc=Array()
	function getElement(psID) {
		return document.getElementById(psID);

	} else {
		return document.all[psID];
	}
}

	    document.forma1.Indice.value=xI
	    Separa="&delimitador="+Separa
  		msgwin.focus()

	}

	function AbrirIndice(ira){

	function Ayuda(tag){
		help=window.opener.url_H
		if (help!=""){
			tagx=String(tag)
			if (tagx.length<3) tagx="0"+tagx
			if (tagx.length<3) tagx="0"+tagx
			url="../documentacion/ayuda_db.php?help="+base+"/ayudas/<?php echo $_SESSION["lang"]."/"?>tag_"+tagx+".html"
		}
		msgwin=window.open(url,"Ayuda","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=400,top=100,left=100")
		msgwin.focus()

</script>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/assist_sc.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
	<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/assist_sc.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp; Script: campos.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
<body link=black vlink=black bgcolor=white>

<input type=hidden name=tagcampo>
<input type=hidden name=Formato>
<input type=hidden name=Repetible>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class=td2>
    	<td>
		</td>
	<tr>
		<td id="asubc">
		</td>
	<td align=center>
		<a href="javascript:self.close()"><img src=img/cancelar.gif  border=0><br><?php echo $msgstr["cancelar"]?></a>
	</td>
  	if (Occ>0) {
  	}else{
</center>
</div>
</div>
<?php include("../common/footer.php")?>
<?php
// ===============================================
function PickList($ix,$file){
global $db_path,$lang_db,$arrHttp;
	if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$file;
	if (file_exists($archivo)){
		$Options="";
		foreach ($fp as $value) {
			if ($value!=""){

?>
