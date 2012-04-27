<?php
global $valortag;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

include("../config.php");

include("../common/get_post.php");


if (isset($arrHttp["cambiolang"]))  $_SESSION["lang"]=$arrHttp["lang"];
include ("../lang/admin.php");
include ("../lang/lang.php");
include("leerregistroisispft.php");

$arrHttp["IsisScript"]="ingreso.xis";
$arrHttp["Mfn"]=$_SESSION["mfn_admin"];

//LeerRegistroMfn("acces","acces.par",$_SESSION["mfn_admin"],&$maxmfn,"leer","","",$xWxis,"ingreso.xis");
//$b=explode("\n",$valortag[100]) ;
//foreach($b as $value){//	$value=trim($value);
	if ($value!=""){
		$ix=strpos($value,'^',2);
		if ($ix===false) $ix=strlen($value);
		$key=substr($value,2,$ix-2);
		if (trim($key)!=""){
	//		echo $key."<br>";
			$bases[$key]=$value;
		}
//	}
}
$fp = file($db_path."bases.dat");
if (!$fp){
	echo $msgstr["notfound"]." bases.dat";
	die;
}
echo "<script>
top.listabases=Array()\n";
foreach ($fp as $linea){
	if (trim($linea)!="") {
		$ix=strpos($linea,"|");
		$llave=trim(substr($linea,0,$ix));
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
		echo "top.listabases['$llave']='".trim(substr($linea,$ix+1))."'\n";
	}

}
echo "</script>\n";
include("../common/header.php");
?>
<script>
lang='<?php echo $_SESSION["lang"]?>'

function AbrirAyuda(){
	msgwin=window.open("ayudas/"+lang+"/menubases.html","Ayuda","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,width=750,height=500,top=10,left=5")
	msgwin.focus()
}

Entrando="S"

function VerificarEdicion(Modulo){
	 if(top.xeditar=="S"){
		alert("<?php echo $msgstr["aoc"]?>")
		return
	}
}

function CambiarBase(){
	tl=""
   	nr=""
  	i=document.OpcionesMenu.baseSel.selectedIndex
  	top.ixbasesel=i
   	if (i==-1) i=0
  	abd=document.OpcionesMenu.baseSel.options[i].value
  	top.base=abd
	if (abd.substr(0,2)=="--"){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	ix=abd.indexOf("^b");
	if (ix>0){		base=abd.substr(2,ix-2)
	}else{		base=abd.substr(2)}
	top.base=base
		if (document.OpcionesMenu.baseSel.options[i].text==""){
		return
	}
	abd=abd.substr(ix+2)
	ix=abd.indexOf("^c");
	if (ix>0){
		top.db_copies=abd.substr(ix+2)
	}else{
		top.db_copies=""
	}

	cipar=base+".par"
	top.nr=nr
	document.OpcionesMenu.base.value=base
   	document.OpcionesMenu.cipar.value=cipar
	document.OpcionesMenu.tlit.value=tl
	document.OpcionesMenu.nreg.value=nr
	top.base=base
	top.cipar=cipar
	top.mfn=0
	top.maxmfn=99999999
	top.browseby="mfn"
	top.Expresion=""
	top.Mfn_Search=0
	top.Max_Search=0
	top.Search_pos=0
	switch (top.ModuloActivo){
		case "dbadmin":

			top.menu.location.href="../dbadmin/index.php?base="+base

            break;
		case "catalog":
			i=document.OpcionesMenu.baseSel.selectedIndex
			document.OpcionesMenu.baseSel.options[i].text
			if (top.NombreBase==document.OpcionesMenu.baseSel.options[i].text) return
			top.NombreBase=document.OpcionesMenu.baseSel.options[i].text
			top.menu.document.forma1.ir_a.value=""
			top.main.location.href="inicio_base.php?base="+base+"&cipar="+cipar
			i=document.OpcionesMenu.baseSel.selectedIndex
			break
		case "Capturar":

			break
	}
}

function Modulo(){	Opcion=document.OpcionesMenu.modulo.options[document.OpcionesMenu.modulo.selectedIndex].value
	switch (Opcion){
		case "loan":
			top.location.href="../common/change_module.php?modulo=loan"
			break
		case "acquisitions":
			top.location.href="../common/change_module.php?modulo=acquisitions"
			break

		case "dbadmin":
				document.OpcionesMenu.modulo.selectedIndex=0
				top.ModuloActivo="dbadmin"
			top.menu.location.href="../dbadmin/index.php?basesel="
			break
		case "catalog":
			top.main.location.href="inicio_base.php?inicio=s&base="+base+"&cipar="+base+".par"
			top.ModuloActivo="catalog"
			if (i>0) {				top.menu.location.href="../dataentry/menu_main.php?Opcion=continue&cipar=acces.par&cambiolang=S&base="+base			}else{				top.menu.location.href="../dataentry/blank.html"			}
			break

	}
}

function CambiarLenguaje(){
	url=top.main.location.href
	lang=document.OpcionesMenu.lenguaje.options[document.OpcionesMenu.lenguaje.selectedIndex].value
	Opcion=top.ModuloActivo
	top.encabezado.location.href="menubases.php?base="+top.base+"&base_activa="+top.base+"&lang="+lang+"&cambiolang=s"
	switch (Opcion){
		case "loan":
			break
		case "dbadmin":
			top.menu.location.href="../dbadmin/index.php?Opcion=continue&lang="+lang+"&base="+top.base
			top.main.location.href=url
			break
		case "catalog":
			break
		case "statistics":
			break

	}
}
</script>
</head>
<body class="heading">
<form name=OpcionesMenu>
<input type=hidden name=base value="">
<input type=hidden name=cipar value="">
<input type=hidden name=marc value="">
<input type=hidden name=tlit value="">
<input type=hidden name=nreg value="">
<div class="heading">
	<div class="institutionalInfo heading">
				<img title="<?php  echo $institution_name ?>" alt="<?php  echo $institution_name ?>" src=..<?php echo $logo ?> width="120" />
	</div>
	
		<div class="userInfo" style="width: 190px;float:right;">
	
	
		<span><?php echo $_SESSION["nombre"]?></span>,
		<?php echo $_SESSION["profile"]?> |
<?php
if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){
	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span><img alt=\"$msgstr[logout]\" src=\"../css/$theme/images/logout.png\"></span></a>";}else{	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span><img alt=\"$msgstr[logout]\" src=\"../css/$theme/images/logout.png\"></span></a>";}
?>
</div>
	
	<div style="float:right;">
	<div class="styled-select" >
<?php
$central="";
$circulation="";
$acquisitions="";
foreach ($_SESSION["permiso"] as $key=>$value){
	if (substr($key,0,8)=="CENTRAL_")  $central="Y";
	if (substr($key,0,5)=="CIRC_")  $circulation="Y";
	if (substr($key,0,4)=="ACQ_")  $acquisitions="Y";

}
if ($circulation=="Y" or $acquisitions=="Y"){
		echo "<!--<label>$msgstr[modulo]<label>:-->";
         ?>
  			<select name=modulo onclick=VerificarEdicion() onchange=Modulo()>
  				<option value=catalog><?php echo $msgstr["catalogacion"]?>
  				<option value=dbadmin><?php echo $msgstr["dbadmin"]?>
  				<option value=loan><?php echo $msgstr["prestamo"]?>
  				<option value=acquisitions><?php echo $msgstr["acquisitions"]?>
  			</select>
          <?php } ?>
</div>

<div class="styled-select" >		
<!--<label><?php echo $msgstr["bd"]?></label>:-->
		<select name=baseSel onchange=CambiarBase() onclick=VerificarEdicion()>
		<option value=""></option>
<?
$i=-1;
$hascopies="";
foreach ($lista_bases as $key => $value) {
	$xselected="";
	$t=explode('|',$value);
	if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){
		if (isset($arrHttp["base_activa"])){
			if ($key==$arrHttp["base_activa"]) 	{				$xselected=" selected";
				$hascopies=$t[1];			}

		}
		if (!isset($t[1])) $t[1]="";
		echo "<option value=\"^a$key^badm^c".$t[1]."\" $xselected>".$msgstr["bd"]." ".$t[0]."\n";
	}
}
echo "</select>" ;
if ($hascopies=="Y" and (isset($_SESSION["permiso"]["CENTRAL_ADDCO"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))){	echo "\n<script>top.db_copies='Y'\n</script>\n";}
?>
</div>
</div>	



<div class="opt_catalog" >

</form>



</div>


	</div>

</div>


<script>
<?php
if (isset($arrHttp["inicio"]))
	$inicio="&inicio=s";
else
	$inicio="";
echo "top.menu.location.href=\"menu_main.php?base=\"+top.base+\"$inicio\"\n";?>
</script>
</body>
</html>

