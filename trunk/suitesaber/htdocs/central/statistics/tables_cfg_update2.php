<?php
session_start();
if (!isset($_SESSION["permiso"])) die;
include ("../config.php");
$lang=$_SESSION["lang"];
// ARCHIVOD DE MENSAJES
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// VARIABLES QUE VIENEN DE LA PÁGINA
include("../common/get_post.php");


// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILOinclude("../common/header.php");

// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){//	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "<form name=stats method=post>";
echo "<div class=\"sectionInfo\">
";
if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics"){
	$script="tables_generate.php";
}else{
	$script="../dbadmin/menu_modificardb.php";
}

?>
</div>
</div>



<div class="middle form">
	<div class="formContent">
<?php
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tabs.cfg";
$fp=fopen($file,"w");
$vc=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($vc as $value){	$r=fwrite($fp,$value."\n");}
$r=fclose($fp);
echo "<h4>". $arrHttp["base"]."/".$_SESSION["lang"]."/def/tabs.cfg"." <br /><br /> ".$msgstr["updated"]."!</h4>" ;
?>

<a id="botoes"  href="<?php echo"$script?base=".$arrHttp["base"]."$encabezado";?>" target="_top" >Recarregue a página</a>
	</div>
</div>
</form>
<?php
include("../common/footer.php");
?>
</body>
</html>
