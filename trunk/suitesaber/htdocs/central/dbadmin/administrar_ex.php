<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      administrar_ex.php
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
include ("../config.php");
include("../lang/dbadmin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

function InicializarBd(){
global $arrHttp,$OS,$xWxis,$db_path,$Wxis,$msgstr;
 	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=".$arrHttp["Opcion"];
 	$IsisScript=$xWxis.$arrHttp["IsisScript"];
 	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
	 	if ($linea=="OK"){
	 		echo "<h3>".$arrHttp["base"]." ".$msgstr["init"]."</h3>";
	 	}
 	}
}
function MostrarPft(){
global $arrHttp,$xWxis,$Wxis,$db_path,$wxisUrl;

	$IsisScript=$xWxis.$arrHttp["IsisScript"];
	if (!isset($arrHttp["from"])) $arrHttp["from"]="";
	if (!isset($arrHttp["count"])) $arrHttp["count"]="";
 	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=".$arrHttp["Opcion"]."&from=".$arrHttp["from"]."&count=".$arrHttp["count"];
  	include("../common/wxis_llamar.php");
    return $contenido;

}
function VerStatus(){
	global $arrHttp,$xWxis,$OS,$db_path,$Wxis;
	$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
 	$IsisScript=$xWxis."administrar.xis";
 	include("../common/wxis_llamar.php");
 	$ix=-1;
	foreach($contenido as $linea) {
		if (!empty($linea)) {
			$ix++;
			if ($ix>0) {
	  			$a=explode(":",$linea);
	  			$tag[$a[0]]=$a[1];
			}
		}
	}
	return $tag;
}

function Footer(){
	echo "</div></div>";
	include("../common/footer.php");
	echo "</body></html>";
	die;
}

include("../common/get_post.php");

$encabezado="";
if (isset($arrHttp["encabezado"])) $encabezado="&encabezado=s";
include("../common/header.php");
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">
<div class="language">
<?php echo "<a href=\"../dbadmin/menu_mantenimiento.php?reinicio=s&base=".$arrHttp["base"]."&encabezado=s\" class=\"defaultButton\">";
?>

					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
</div>
</div>

			<div class="breadcrumb">
				<?php echo "<h3>".$msgstr["maintenance"]." " .$msgstr["database"].": ".$arrHttp["base"]."</h3>"?>
			</div>

			<div class="actions">

			</div>

<?php }
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";
echo "<font size=1> &nbsp; &nbsp; Script: administrar_ex.php</font><br>";
switch ($arrHttp["Opcion"]) {
    case "inicializar":
    	if (!file_exists($db_path.$arrHttp["base"])){
    		echo "<h3>".$db_path.$arrHttp["base"].": ".$msgstr["folderne"]."</h3>";
    		Footer();
    	}
    	if (!file_exists($db_path."par/".$arrHttp["base"].".par")){
    		echo "<h3>".$db_path."par/".$arrHttp["base"].".par: ".$msgstr["ne"]."</h3>";
    		Footer();
    	}
    	$arrHttp["IsisScript"]="administrar.xis";
    	$tag=VerStatus();
		if (!isset($arrHttp["borrar"])){
			if ($tag["BD"]!="N"){
				echo "<center><br><span class=td><h4>".$arrHttp["base"]."<br><font color=red>".$msgstr["bdexiste"]."</font><br>".$tag["MAXMFN"]." ".$msgstr["registros"]."<BR>";
				echo "<script>
					if (confirm(\"".$msgstr["elregistros"]." ??\")==true){
						borrarBd=true
					}else{
						borrarBd=false
					}
					if (borrarBd==true){
						if (confirm(\"".$msgstr["seguro"]." ??\")==true){
							borrarBd=true
						}else{
							borrarBd=false
						}
					}
					if (borrarBd==true)
						self.location=\"administrar_ex.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&Opcion=inicializar&borrar=true$encabezado\"
					</script>";
			}else{

				InicializarBd();
				$arrHttp["Opcion"]="unlockbd";
			}
		}else{
			$arrHttp["IsisScript"]="administrar.xis";
			InicializarBd();
			$fp=fopen($db_path."par/".$arrHttp["base"].".par","r");
			if (!$fp){
				echo $arrHttp["base"].".par"." ".$msgstr["falta"];
				die;
			}
			$fp=file($db_path."par/".$arrHttp["base"].".par");
			foreach($fp as $value){
				$ixpos=strpos($value,'=');
				if ($ixpos===false){
				}else{
					if (substr($value,0,$ixpos)==$arrHttp["base"].".*"){
						$path=trim(substr($value,$ixpos+1));
						$ixpos=strrpos($path, '/');
						$path=substr($path,0,$ixpos)."/";
//						echo "<p>$path<p>";
						break;
					}
				}
			}
			$arrHttp["Opcion"]="unlockbd";
		}
		break;
	case "fullinv":

		$contenido=VerStatus();
		$arrHttp["IsisScript"]="fullinv.xis";
		MostrarPft();
		break;


		case "listar":
	case "unlock":
		$contenido=VerStatus();
		foreach ($contenido as $linea){			if (substr($linea,0,7)=='MAXMFN:'){				$maxmfn=trim(substr($linea,7));
				break;
			}
        }
        $arrHttp["from"]=$arrHttp["Mfn"];
		$arrHttp["count"]=$arrHttp["to"]-$arrHttp["from"]+1;
		$to=$arrHttp["to"]+$arrHttp["count"]+1;
		echo "<form name=forma1 method=post action=mfn_ask_range.php>";
		echo "<input type=hidden name=base value=".$arrHttp["base"].">";
		echo "<input type=hidden name=cipar value=".$arrHttp["cipar"].">";
		echo "<input type=hidden name=Opcion value=".$arrHttp["Opcion"].">";
		echo "<input type=hidden name=from value=".$arrHttp["from"].">";
		echo "<input type=hidden name=to value=".$arrHttp["to"].">";
		echo $msgstr["cg_from"]." = ".$arrHttp["from"]." - ".$msgstr["cg_to"]." = ".$arrHttp["to"]." (".$arrHttp["count"]." ".$msgstr["records"].")";
		echo "<table class=listTable>";
		switch ($arrHttp["Opcion"]){			case "unlock":
				echo "<th>Mfn</th><th>&nbsp;</th>";
				break;
			case "listar":
				echo "<th>Mfn</th><th>Locked by</th><th>Isis Status</th>";
				break;		}
		$arrHttp["IsisScript"]="administrar.xis";
		$contenido=MostrarPft();
        $nb=0;
		foreach ($contenido as $value) {
			$value=trim($value);
			if ($value!=""){				switch ($arrHttp["Opcion"]){					case "unlock":
						$t=explode('|',$value);
						if (trim($t[1])=="UNLOCKED") $nb++;
						echo '<tr><td>'.$t[0]."</td><td>".$t[1]."</td>\n";
						break;
					case "listar":
						$t=explode('|',$value);
						if (trim($t[2])!=""){
							$nb++;
							echo '<tr><td>'.$t[0]."</td><td>".$t[1]."</td><td>".$t[2]."</td>\n";
						}
						break;				}
			}		}
		echo "</table>";
        if ($nb==0){        	echo "<strong>".$msgstr["noblockedrecs"]."</strong>";        }else{        	echo $nb." ".$msgstr["blockedrecs"];        }
		if ($arrHttp["to"]<$maxmfn){			echo "<p><input type=submit value=".$msgstr["continuar"].">";		}
		echo "</form>";
		break;


	case "unlockbd":
	   $arrHttp["IsisScript"]="administrar.xis";
		$contenido=VerStatus();
		foreach ($contenido as $value) echo "$value<br>";
		echo "<p>".$msgstr["mnt_desb"];
		echo "<p>";
		$contenido=MostrarPft();
		foreach ($contenido as $value) echo "<dd>$value<br>";
		$contenido=VerStatus();
		foreach ($contenido as $value) echo "$value<br>";
		break;



	case "listadecampos":
		include("adm_listadecampos.php");
		break;
		echo "<html>\n";
		echo "<body>\n";
		echo "<script languaje=javascript>\n";
		echo "function Buscar(Clave){\n";
		echo 'Clave=Clave.substr(0,30)'."\n";
		echo 'Clave="\""+escape(Clave)+"\""'."\n";
		echo '	url="/wxis/wxis.exe?IsisScript=auditoria.xis&Opcion=buscar&Expresion="+Clave+"&Path='.$arrHttp["Path"].'&base='.$arrHttp["base"]."&cipar=".$arrHttp["base"].".par\"\n";
		echo '  msgwin=window.open(url,"Window2","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=400,top=50,left=50")'."\n";
		echo '  msgwin.focus()'."\n";
		echo "}\n";
		echo "</script>\n";
		$arrHttp["IsisScript"]="auditoria.xis";
		LeerRegistro();
		break;


}
if (!isset($arrHttp["encabezado"])){
	if ($arrHttp["Opcion"]!="fullinv")
 		echo "<p><center><a href=index.php?base=".$arrHttp["base"]." class=boton> &nbsp; &nbsp; Menu &nbsp; &nbsp; </a>";
}
?>
