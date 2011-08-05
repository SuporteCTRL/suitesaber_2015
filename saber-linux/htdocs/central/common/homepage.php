<?php
$Permiso=$_SESSION["permiso"];
$fp = file($db_path."bases.dat");

include("../config.php");

if (!$fp){
	echo "falta el archivo bases.dat";
	die;
}
foreach ($fp as $linea){
	$linea=trim($linea);
	if ($linea!="") {
		$ix=strpos($linea,"|");
		$llave=trim(substr($linea,0,$ix));
		$lista_bases[$llave]=trim(substr($linea,$ix+1));
	}

}
$central="";
$circulation="";
$acquisitions="";
$ixcentral=0;
foreach ($_SESSION["permiso"] as $key=>$value){
	if (substr($key,0,8)=="CENTRAL_")  	{		$central="Y";
		$ixcentral=$ixcentral+1;	}
	if (substr($key,0,5)=="CIRC_")  	$circulation="Y";
	if (substr($key,0,4)=="ACQ_")  		$acquisitions="Y";

}
// Se determina el nombre de la página de ayuda a mostrar
if (!isset($_SESSION["MODULO"])) {	if ($central=="Y" and $ixcentral>1) {		$arrHttp["modulo"]="catalog";	}else{		if ($circulation=="Y"){			$arrHttp["modulo"]="loan";		}else{			$arrHttp["modulo"]="acquisitions";		}	}}
switch ($arrHttp["modulo"]){	case "catalog":
		$ayuda="homepage.html";
		$module_name=$msgstr["catalogacion"];
		$_SESSION["MODULO"]="catalog";
		break;
	case "acquisitions":
		$ayuda="acquisitions/homepage.html";
		$module_name=$msgstr["acquisitions"];
		$_SESSION["MODULO"]="acquisitions";
		break;
	case "loan":
		$ayuda="circulation/homepage.html";
		$module_name=$msgstr["loantit"];
		$_SESSION["MODULO"]="loan";}
include("header.php");
?>
<script languaje=javascript>
	function CambiarLenguaje(){
		if (document.cambiolang.lenguaje.selectedIndex>0){
               lang=document.cambiolang.lenguaje.options[document.cambiolang.lenguaje.selectedIndex].value
               self.location.href="inicio.php?reinicio=s&lang="+lang
		}
	}
	function CambiarBase(Modulo){
		if (Modulo!="traducir"){
			ix=document.admin.base.selectedIndex
	    	if (ix<1){
	    		alert("<?php echo $msgstr["seldb"]?>")
	    		return
			}
	    }

	    switch(Modulo){
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":
				document.admin.action="../dbadmin/menu_mantenimiento.php";
                   break;
   			case "estructuras":
				document.admin.action="../dbadmin/menu_modificardb.php";
                break;
    		case "reportes":
				document.admin.action="../dbadmin/pft.php";
                 break;
		}
		document.admin.submit();
	}
	function CambiarBaseAdministrador(Modulo){
		if (Modulo!="traducir"){
			ix=document.admin.base.selectedIndex
		    if (ix<1){
		    	alert("<?php echo $msgstr["seldb"]?>")
		    	return
		    }
		}
	    switch(Modulo){			case 'table':
				document.admin.action="../dataentry/browse.php"
				break
	    	case "resetautoinc":
	    	   	document.admin.action="../dbadmin/resetautoinc.php";
	    		break;
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":
				document.admin.action="../dbadmin/menu_mantenimiento.php";
                break;
   			case "estructuras":
				document.admin.action="../dbadmin/menu_modificardb.php";
                break;
    		case "reportes":
				document.admin.action="../dbadmin/pft.php";
                break;
    		case "traducir":
				document.admin.action="../dbadmin/menu_traducir.php";
                break;
    		case "stats":
    			document.admin.action="../statistics/tables_generate.php";
    			break;
    		case "z3950":
    			document.admin.action="../dbadmin/z3950_conf.php";
    			break;
	    }
		document.admin.submit();
	}
	function ModificarBase(){
	    ix=document.admin.base.selectedIndex
	    if (ix<1){
	    	alert("<?php echo $msgstr["seldb"]?>")
	    	return
	    }
		base_sel=document.admin.base_lista.options[ix].value
		base_sel=base_sel.substr(2)
		i=base_sel.indexOf('^')
		base_sel=base_sel.substr(0,i)
		self.location.href="dbadmin/menu_modificardb.php?base="+base_sel+"&encabezado=S"
	}
	function ModificarBaseAdministrador(){
	    ix=document.admin.base_lista.selectedIndex
	    if (ix<1){
	    	alert("<?php echo $msgstr["seldb"]?>")
	    	return
	    }
		base_sel=document.admin.base_lista.options[ix].value
		base_sel=base_sel.substr(2)
		i=base_sel.indexOf('^')
		base_sel=base_sel.substr(0,i)
		self.location.href="dbadmin/menu_modificardb.php?base="+base_sel+"&encabezado=S"
	}
	</script>


	<script>
	$(function() {
		$( "#tabs" ).tabs().find( ".ui-tabs-nav" ).sortable({ axis: "x" });
	});
	</script>
		<style type="text/css">
			/*demo page css*/
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>


	<style>
	#draggable { width: 60px; height: 60px; padding: 0.5em; }
	</style>
	<script>
	$(function() {
		$( ".menuButton" ).draggable();
	});
	</script>

</head>
<body>
<?php include("institutional_info.php");
	if (isset($msg_path))
		$path_this=$msg_path;
	else
		$path_this=$db_path;
	$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
 	if (!file_exists($a)) {
 		$a=$path_this."lang/en/lang.tab";
 	}
 	if (!file_exists($a)){
		echo $msgstr["flang"]." ".$a;
		die;
	}
 	$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
 	if (!file_exists($a)) { 		$a=$path_this."lang/en/lang.tab"; 	}
 	if (!file_exists($a)){
		echo $msgstr["flang"]." ".$a;
		die;
	}
?>
<div class="language"><form name=cambiolang><?php echo $msgstr["lang"]?>:
	<select name=lenguaje onchange=CambiarLenguaje() >
		<option value=""></option>
		 <?php

 	if (file_exists($a)){
		$fp=file($a);
		$selected="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$l=explode('=',$value);
				if ($l[0]==$_SESSION["lang"]) $selected=" selected";
				echo "<option data-html-text=$l[1] value=$l[0] $selected>".$l[1]."</option>";
				$selected="";
			}
		}
	}else{
		echo $msgstr["flang"].$db_path."lang/".$_SESSION["lang"]."/lang.tab";
		die;
	}
?>
	</select>
	</form>
</div>
<div class="sectionInfo">
	<div class="breadcrumb">
		<h3><?php echo $msgstr["inicio"]." - $module_name"?></h3>
	</div>
	<div class="actions">
		<?php include("modules.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/$ayuda"?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 <?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/$ayuda target=_blank>".$msgstr["edhlp"];
	echo "</a>
		<font color=white>&nbsp; &nbsp; Script: homepage.php </font>";
}
?>
</div>
<div class="middle homepage">
<?php
$Permiso=$_SESSION["permiso"];
switch ($_SESSION["MODULO"]){	case "catalog":
		AdministratorMenu();
		break;
	case "loan":
		MenuLoanAdministrator();
		break;
	case "acquisitions":
		MenuAcquisitionsAdministrator();
		break;}
echo "		</div>
	</div>";

echo "	</body>
</html>";

///---------------------------------------------------------------

function AdministratorMenu(){
global $msgstr,$db_path,$arrHttp,$lista_bases,$Permiso,$dirtree;
	$_SESSION["MODULO"]="catalog";
	
	include("../config.php");
?>




		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $msgstr["database"]?></a></li>
				<li><a href="#tabs-2"><?php echo $msgstr["admtit"]?></a></li>
				<li><a href="#tabs-3">Ajuda!</a></li>
			</ul>

<div id="tabs-1">
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection ">
			<div class="sectionIcon">
				&#160;
			</div>
			<div class="sectionTitle">

			</div>
			<div class="sectionButtons">
            	<div class="searchTitles">
					<form name="admin" action="dataentry/inicio_main.php" method="post">
					<input type=hidden name=encabezado value=s>
					<input type=hidden name=retorno value="../common/inicio.php">
					<input type=hidden name=modulo value=catalog>
					<?php if (isset($arrHttp["newindow"]))
					echo "<input type=hidden name=newindow value=Y>\n";?>
					<div class="stInput">
						<label for="searchExpr"><?php echo $msgstr["seleccionar"]?>:</label>
						<select name=base >
				<option value=""></option>
<?php
$i=-1;
foreach ($lista_bases as $key => $value) {
	$xselected="";
	$t=explode('|',$value);
	if (isset($Permiso["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"])){
		if (isset($arrHttp["base"]) and $arrHttp["base"]==$key or count($lista_bases)==1) $xselected=" selected";
		echo "<option value=\"^a$key^badm|$value\" $xselected>".$t[0]."\n";
	}
}
?>
	<!--	<option value=""></option> -->
						</select>
					</div>
					</form></div>

				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div><br />
					


<a href="javascript:CambiarBaseAdministrador('toolbar')" class="menuButton tooltip catal ">
						
						<span><?php echo $msgstr["dataentry"]?></span></a>



				

<?php
if (isset($Permiso["CENTRAL_STATGEN"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a  href="javascript:CambiarBaseAdministrador('stats')" class="menuButton tooltip statButton">

					<span><?php echo $msgstr["statistics"]?></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_PREC"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a  href="javascript:CambiarBase('reportes')" class="menuButton tooltip reportButton">

					<span><?php echo $msgstr["reports"]?></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_MODIFYDEF"]) or isset($Permiso["CENTRAL_ALL"])){
?>
				<a href="javascript:CambiarBaseAdministrador('estructuras')" class="menuButton tooltip update_databaseButton">

					<span><?php echo $msgstr["updbdef"]?></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_DBUTILS"]) or isset($Permiso["CENTRAL_ALL"])){
?>

				<a href="javascript:CambiarBaseAdministrador('utilitarios')" class="menuButton tooltip utilsButton">

					<span><?php echo $msgstr["maintenance"]?></span>
				</a>
<?php
}
if (isset($Permiso["CENTRAL_Z3950CONF"])  or isset($Permiso["CENTRAL_ALL"])){
?>
	
<?php
}
?>

			</div>
			<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>




</div>
<?php

if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"])  or isset($Permiso["CENTRAL_URDADM"])
  or isset($Permiso["CENTRAL_RESETLIN"])  or isset($Permiso["CENTRAL_TRANSLATE"])  or isset($Permiso["CENTRAL_EXDBDIR"]))
{
?>



<!-- SEGUNDO ACORDEON -->

<div id="tabs-2"> 
                    
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection ">
					<div class="sectionIcon">
						&#160;
					</div>

					<div class="sectionButtons">
<?Php
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"])){
?>
                    <a href="../dbadmin/menu_creardb.php?encabezado=S" class="menuButton tooltip databaseButton">

					<span><?php echo $msgstr["createdb"]?></span></a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_URADM"])){
?>
				<a href="../dbadmin/users_adm.php?encabezado=s&base=acces&cipar=acces.par" class="menuButton tooltip userButton">

					<span><?php echo $msgstr["usuarios"]?></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_RESETLIN"])){
?>
				<a href="../dbadmin/reset_inventory_number.php?encabezado=s" class="menuButton tooltip resetButton">

					<span><?php echo $msgstr["resetinv"]?></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_TRANSLATE"])){
?>
				<a href="javascript:CambiarBaseAdministrador('traducir')" class="menuButton tooltip exportButton">

					<span><?php echo $msgstr["translate"]?></span>
				</a>
<?Php
}
if ($dirtree==1){
	if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_EXDBDIR"])){
?>
				<a href="../dbadmin/dirtree.php?encabezado=s" class="menuButton tooltip exploreButton">

					<span><?php echo $msgstr["expbases"]?></span>
				</a>
<?Php }
}?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			




</div>







</div>


<div id="tabs-3"> 
      <div>

			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection ">
					<div class="sectionIcon">
						&#160;
					</div>

					<div class="sectionButtons">

		
				<a href="apoio/descricao_lilacs.pdf" target="_blank"  class="menuButton tooltip newButton">

					<span>Manual de Descrição Bibliográfica LILACS</span>
				</a> 


				<a href="http://bireme.br" target="_blank"  class="menuButton tooltip newButton">

					<span>Pesquisar BIREME</span>
				</a> 


				<a href="javascript:void(1)"onclick="window.open('http://decs.bvs.br/cgi-bin/wxis1660.exe/decsserver/?IsisScript=../cgi-bin/decsserver/decsserver.xis&interface_language=p&previous_page=homepage&previous_task=NULL&task=start','windowname1','width=680, height=400,scrollbars=yes');return false;"  class="menuButton tooltip newButton">

					<span>Consulta ao DeCS</span>
				</a> 


				<a href="javascript:void(1)"onclick="window.open('http://biblioteca.saude.rs.gov.br/relatorios-estatisticas/index.html','windowname1','width=680, height=400,scrollbars=yes');return false;"  class="menuButton tooltip newButton">

					<span>Como gerar relatórios</span>
				</a> 
         			</div>
			<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
</div>



<?php
	}
}
// end function Administrador



function MenuAcquisitionsAdministrator(){
	include("menuacquisitions.php");
}

function MenuLoanAdministrator(){
   include("menucirculation.php");
}
