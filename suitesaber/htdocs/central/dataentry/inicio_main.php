<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
global $Permiso;
$valortag = Array();
$arrHttp=array();
global $arrHttp,$xFormato,$valortag,$nombre;
require_once ("../config.php");

}
include ("../lang/admin.php");
include ("../lang/soporte.php");
include ("../lang/lang.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;
if (isset($arrHttp["newindow"]))
	$_SESSION["newindow"]="Y";



if (isset($_SESSION["login"])) $arrHttp["login"]=$_SESSION["login"];
//else
//	$_SESSION["login"]=$
if (isset($_SESSION["password"])) $arrHttp["password"]=$_SESSION["password"];
if (isset($_SESSION["permiso"])) $arrHttp["startas"]=$_SESSION["permiso"];

function LeerRegistro() {
   global $llamada, $valortag,$maxmfn,$arrHttp,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl;
// en la variable $arrHttp vienen los par�metros que se le van a pasar al script .xis
// el �ndice IsisScript contiene el nombre del script .xis que va a ser invocado

// la variable $llave permite retornar alguna marca que est� en el formato de salida
// identificada entre $$LLAVE= .....$$

	$llave_pft="";
	$IsisScript=$xWxis."login.xis";
	$query = "&base=acces&cipar=$db_path"."par/acces.par"."&login=".$_SESSION["login"]."&password=".$_SESSION["password"];
	include("../common/wxis_llamar.php");
 	$ic=-1;
 	$tag= "";
 	foreach ($contenido as $linea){
 		if ($ic==-1){
    		$pos=strpos($linea, '##LLAVE=');
    		if (is_integer($pos)) {
     			$llave_pft=substr($linea,$pos+8);
     			$pos=strpos($llave_pft, '##');
     			$llave_pft=substr($llave_pft,0,$pos);
			}
		}else{
			$linea=trim($linea);
			$pos=strpos($linea, " ");
			if (is_integer($pos)) {
				$tag=trim(substr($linea,0,$pos));
			}
		}

	}
	return $llave_pft;
}

/////
/////   INICIO DEL PROGRAMA
/////


$query="";


//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";

if (isset($arrHttp["base"])){
    $bdsel=trim($arrHttp["base"]);
    $base_x=explode('|',$bdsel);
    $db_copies="";
    if (isset($base_x[2]) and $base_x[2]=="Y") $db_copies="Y";
	$ix=strpos($base_x[0],'^',2);
	$bd=substr($base_x[0],2,$ix-2);;
	$bdright= substr($base_x[0],$ix+2);
	$bddesc=$base_x[1];
	if (isset($arrHttp["lang"])){
	}else{
	include ("../lang/admin.php");
	if (!isset($_SESSION["Expresion"])) $_SESSION["Expresion"]="";
	$Permiso=$_SESSION["permiso"];
	if (empty($Permiso)){
		echo "Missing user rights";
		session_destroy();
		die;
    foreach ($Permiso as $key=>$value){
    		break;
	$arrHttp["base"]=$bases;
	$arrHttp["cipar"]=$arrHttp["base"].".par";
	$NombreBase="";
	$arrHttp["Opcion"]="STATUS";
	$arrHttp["IsisScript"]="control.xis";
	$llave=LeerRegistro();
	$stat=explode("\|",$llave);
	$llave=substr($stat[2],7);
	echo "<HTML><title>";
	echo $institution_name;
	echo "</title>
				<head>
				<script language=javascript src=js/lr_trim.js></script>
				<script languaje=javascript>
				self.resizeTo(screen.availWidth,screen.availHeight)
				self.moveTo(0,0)
				self.focus();\n";
	if (isset($_SESSION["newindow"]))
// for detecting if is a new window or the same window
				echo "var neww=\"&newindow=y\"\n";
	else
				echo "var neww=\"\"\n";
	echo"
				var listabases=Array()
				var lock_db=''
				var browseby=\"mfn\"
				var Expresion=\"\"
				var Expre_b=\"\"
                var typeofrecord=''
				var mfn=0
				var maxmfn=0
				var Mfn_Search=0
				var Max_Search=0
				var Search_pos=0
				var db_permiso=\"$bdright\"
				var db_copies=\"$db_copies\"         // to check if the database uses the copies database
				var NombreBase='$bddesc'
				var ix_basesel=0
				var ix_langsel=0
				var Marc=''
				var base=\"$bd\"
				var cipar=\"$bd.par\"
				var Formato='ALL'
				var tl=''
				var nr=''
				var xeliminar=0
				var xeditar=''
				var ModuloActivo=\"catalog\"
				var CG_actual=''
				var CG_nuevo=''
				var prefijo_indice=\"\"
				var formato_indice=\"\"
				ValorCapturado=''
				var NombreBaseCopiarde=''
				var wks=\"\"
				buscar=''
				lang='".$_SESSION["lang"]."'
				ep=''
				ConFormato=true
				Capturando=''
				toolbarEnabled=''      //enable/disable the toolbar
				function AbrirVentanaAyuda(){
					insWindow = window.open('../documentacion/ayuda.php?help='+lang+'/dataentry_toolbar.html', 'Ayuda', 'location=no,width=700,height=550,scrollbars=yes,top=10,left=100,resizable');
					insWindow.focus()
				}
			";

?>

function ApagarEdicion(){
     return
}

function PrenderEdicion(){
	return
}


function TipoDeRegistro(){
	top.main.location.href="typeofrecs.php?base="+base
	return
	top.frames[2].document.writeln("<html><body style='font-family:arial'>")
	top.main.document.writeln("<center><br><br>")
	top.main.document.writeln("<h4><?php echo $msgstr["typeofr"]?></h4><table>")
	tr=typeofrecord.split('$$$')
	ix=tr.length
	for (i=0;i<ix;i++){
		if (Trim(tr[i])!=""){
			linea=tr[i].split('|')
			top.main.document.writeln("<tr><td><a href=\"javascript:top.wks='"+tr[i]+"|"+tl+"|"+nr+"';top.Menu('crear')\"><span style='font-size:10px;font-family:arial'>"+linea[3]+"</span></a></td>")
		}
	}
	top.main.document.writeln("</table></body></html>")
	top.main.document.close()

function AddCopies(){
if (db_copies=="Y")
		urlcopies="&db_copies=Y"
	else
		urlcopies=""
	if (browseby=="search")
		Mfn_copy=Mfn_Search
	else
		Mfn_copy=mfn
    url='../copies/copies_add.php?base='+base+'&Mfn='+Mfn_copy+'&Formato='+Formato+urlcopies
//READ THE TYPES OF ACQUISITIONS
 $file=$db_path."copies/def/".$_SESSION["lang"]."/acquiredby.tab";
 if (!file_exists($file)) $file=$db_path."copies/def/".$lang_db."/acquiredby.tab";
 $tacq=file($file);
 ?>
	parent.main.document.writeln("<html>")
	parent.main.document.writeln("<body><font face=arial>")
	parent.main.document.writeln("<center><br><br>")
	parent.main.document.writeln("<h4><?php $msgstr["typeofr"]?></h4><table>\n")
<?php
foreach ($tacq as $value){
	$value=trim($value);
	$t=explode('|',$value);
?>
	parent.main.document.writeln("</table></body></html>")
	parent.main.document.close()

}

function ValidarIrA(){
  	xmfn=top.menu.document.forma1.ir_a.value

	var strValidChars = "0123456789";
   	if (xmfn.length == 0 || xmfn==0){
		alert("<?php echo $msgstr["especificarnr"]?>")
		return false
	}
	blnResult=true
   	//  test strString consists of valid characters listed above
   	for (i = 0; i < xmfn.length; i++){
    	strChar = xmfn.charAt(i);
    	if (strValidChars.indexOf(strChar) == -1){
    		blnResult = false;
    	}
    }
	if (blnResult==false){
		alert("<?php echo $msgstr["especificarvaln"]?>")
		return false
	}
	if (xmfn>maxmfn){
	  	alert("<?php echo $msgstr["numfr"]?>")
	  	return false
	}
	return xmfn
}

function Menu(Opcion){
    	return
	if (db_copies=="Y")
		urlcopies="&db_copies=Y"
	else
		urlcopies=""
    if (lock_db=="Y") return
    switch (Opcion){
		case "cancelar":
		case "actualizar":
	 	 	ApagarEdicion()
	 	 	break;
		case "editar":
	  		break;
	}

	if (Opcion!="eliminar") xeliminar=0
	if (base=="" ){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	Capturando=''
    ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1){
		ix=0
	}else{
		Formato=top.menu.document.forma1.formato.options[ix].value
	}
	FormatoActual="&Formato="+Formato+"&Diferido=N"
    if (xeditar=="S" && Opcion!="cancelar" && Opcion!="eliminar" && Opcion!="z3950"){
     	alert("<?php echo $msgstr["aoc"]?>")
  		return
 	}
 	if (Opcion=="tabla" || Opcion=="ira"){

	 	xmfn=top.menu.document.forma1.ir_a.value
		if (xmfn=="")  {
		 	top.menu.document.forma1.ir_a.value=1
		}else{
		  	t=xmfn.split("/")
			top.menu.document.forma1.ir_a.value=t[0]
		}

	}
	works=""
	if (wks!="") works="&wks="+wks

    if (Opcion!="actualizar" && Opcion!="editar" && Opcion!="eliminar" && Opcion!="z3950") xeditar=""

 	if (Opcion!="eliminar") xeliminar=0

	if (browseby=="search"){
		tope=Max_Search

	}else{
		tope=maxmfn
	}

	switch (Opcion) {
		case "edit_Z3950":
			Desplegar="N"
            xError="S"
            if (browseby=="search")
				Mfn_p=Mfn_Search
			else
				Mfn_p=mfn
           	top.main.location.href="z3950.php?Mfn="+Mfn_p+"&Opcion=edit&base="+base+"&cipar="+cipar+FormatoActual
            break
		case "addloanobjects":
		    if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/loan_objects_add.php?base="+base+"&Mfn="+Mfn_copy
			return
		case "addcopies":  // add copies to the inventory database
			if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/copies_add.php?base="+base+"&Mfn="+Mfn_copy+"&Formato="+Formato+urlcopies
			return
		case "editdelcopies":    //edit/delete copies from the inventory database
			if (browseby=="search")
				Mfn_copy=Mfn_Search
			else
				Mfn_copy=mfn
			top.main.location.href="../copies/copies_edit.php?base="+base+"&Mfn="+Mfn_copy+"&Formato="+Formato+urlcopies
			return
		case 'home':
			if (base!="") url="&base="+base
			top.location.href="../common/inicio.php?reinicio=s"+url+neww;
			break
		case 'stats':
			top.main.location.href="../statistics/tables_generate.php?base="+base+"&cipar="+base+".par"
			break
			top.main.location.href="default_edit.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			top.xeditar="valdef"
			break
		case "deletedv":
			top.main.location.href="default_delete.php?Opcion=valdef&ver=N&Mfn=0&base="+top.base
			break
		case "recvalidation":
			if (mfn==0 && Mfn_Search==0){
  				alert("<?php echo $msgstr["selmod"]?>")
  				return
  			}
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
  			url="recval_display.php?&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit
  			recvalwin=window.open(url,"recval","width=550,height=300,resizable,scrollbars")
  			recvalwin.focus()
			break;
			Mfn_Search=1
			mfn=1
			top.main.document.location="fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from=1&ver=N"+FormatoActual+works+urlcopies
			break;
		case "administrar":
			top.main.location="administrar.php?base="+base+"&cipar="+cipar
			break;
		case "copiar_archivo":
			top.main.document.location="copiar_archivo.php?&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'imprimir':
  		 	top.main.document.location="../dbadmin/pft.php?Modulo=dataentry&base="+base+"&cipar="+cipar
  	  		break
  	  	case 'global':
  		 	top.main.document.location="c_global.php?&base="+base+"&cipar="+cipar
			return;
  	  		break
		case 'tabla':
			xmfn=top.menu.document.forma1.ir_a.value
			res=ValidarIrA()
			mfn=Number(xmfn)
  			if (res){
   				Opcion="tabla"

  		 		top.main.document.location.href="actualizarportabla.php?Opcion=tabla&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=N"+FormatoActual+works
   				buscar=""
   			}
  	  		break
		case 'alfa':
			formato_ix=formato_indice+"'$$$'f(mfn,1,0)"
	    	Prefijo="&prefijo="+prefijo_indice+"&formato_e="+ formato_ix
			var width = screen.width-600-100
			url="alfa.php?Opcion=autoridades&base="+base+"&cipar="+cipar+Prefijo+"&Formato="+Formato
			msgwin=window.open(url,"Indice","status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=600,height=580,top=10,left="+width)
    		msgwin.focus()
			return
			break
  		case 'ayuda':
    		AbrirVentanaAyuda()
   			break
		case 'z3950' :
            Desplegar="N"
            xError="S"
            if (browseby=="search")
				Mfn_p=Mfn_Search
			else
				Mfn_p=mfn
            if (xeditar=="S"){
            	top.main.location.href="z3950.php?Mfn="+Mfn_p+"&Opcion=edit&base="+base+"&cipar="+cipar+FormatoActual
            	top.main.location.href="z3950.php?Opcion=new&base="+base+"&cipar="+cipar+FormatoActual
            }
            break
    	case 'dup_record':
    	    if (mfn==0 && Mfn_Search==0){
  				alert("<?php echo $msgstr["selmod"]?>")
  				return
  			}
			xeditar="S"
			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
			cnv=""
			loc="fmt.php?Opcion=presentar_captura&Mfn="+mfn_edit+"&ver=N&base="+base+"&cipar="+base+".par&basecap="+base+"&ciparcap="+base+".par"+cnv
            top.main.location.href=loc
            break
		case 'capturar_bd' :
			Capturando='S'
            Desplegar="N"
            xError="S"
            formato_ix=escape(formato_indice+"'$$$'f(mfn,1,0)" )
			width=screen.width
			msgwin=window.open("capturar_main.php?base="+base+"&cipar="+cipar+"&formato_e="+formato_ix+"&prefijo="+prefijo_indice+"&formatoactual="+FormatoActual+"&fc=cap&html=ayuda_captura.html","capturar")
			msgwin.focus()
           	break
  		case 'proximo':
			if (mfn<=0) mfn=0
   			mfn++
   			if (mfn>tope) mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'anterior':
   			if (mfn<=0) mfn=1
   			if (mfn>1) mfn=mfn-1
   			Opcion="leer"
   			buscar=""
            if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'primero':
   			mfn=1
   			buscar=""
   			Opcion="leer"
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'ultimo':
   			mfn=tope
   			Opcion="leer"
   			buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
   		case "same":
   			Opcion="leer"
            buscar=""
   			if (browseby=='search') Search_pos=mfn
   			top.menu.document.forma1.ir_a.value=mfn+"/"+tope
   			break
  		case 'eliminar':
			if (mfn==0){
				alert("<?php echo $msgstr["seleliminar"]?>")
				return
			}
   			if (xeliminar==0){
    			alert("<?php echo $msgstr["confirmdel"]?>")
    			xeliminar=xeliminar+1
   			}else{
				if (xeditar=="S")
					Mfn_p=top.main.document.forma1.Mfn.value
				else
					if (browseby=="search")
						Mfn_p=Mfn_Search
					else
						Mfn_p=mfn

				if (Mfn_p=="New"){
					alert("<?php echo $msgstr["cancelnuevo"]?>")
					return
				}
				if (Mfn_p==0){
					alert("<?php echo $msgstr["seleliminar"]?>")
					return
				}
				if (xeliminar==""){
					alert("<?php echo $msgstr["confirmdel"]?>")
					xeliminar="1"
				}else{
					xeliminar=""
					xeditar=""
					top.main.document.location="../dataentry/fmt.php?Opcion=eliminar&base="+base+"&cipar="+cipar+"&Mfn="+Mfn_p+"&ver=N"+FormatoActual+works+urlcopies

				}
			}
			return
   			break
  		case 'ira':
  		  	xmfn=ValidarIrA()
			buscar=""
  			if (xmfn){
	  			if (ConFormato==true){
            		Opcion="ver"
        		}else{
         			Opcion="leer"
     			}
				mfn=xmfn
  		 	}
  			break
 		}

		if (Opcion=="editar"){
  			if (mfn==0 && Mfn_Search==0){
  				alert("<?php echo $msgstr["selmod"]?>")
  				return
  			}
  			ix=top.menu.document.forma1.wks.selectedIndex
  			if (ix==-1){

  			xeditar="S"
  			if (browseby=="search")
  				mfn_edit=Mfn_Search
  			else
  				mfn_edit=mfn
	  		 	top.main.document.location="../dataentry/fmt.php?Opcion=editar&base="+base+"&cipar="+cipar+"&Mfn="+mfn_edit+"&ver=N"+FormatoActual+works+urlcopies
  		 	return
  		}

		if (Opcion=="ver"){
  			if (tope!=0) top.main.document.location="../dataentry/fmt.php?Opcion=ver&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+urlcopies
  			return
  		}
		if (Opcion=="leer"){
  			if (ConFormato==true){
            	Opcion="ver"
        	}else{
         		Opcion="leer"
     		}

            if (mfn<=0) mfn=1
            if (tope==0) return
            if (browseby=="mfn"){
  		 		top.main.document.location.href="../dataentry/fmt.php?Opcion="+Opcion+"&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+works+urlcopies
  			}else{
  				url="../dataentry/fmt.php?Opcion=buscar&Expresion="+Expresion+"&base="+base+"&cipar="+cipar+"&from="+Search_pos+FormatoActual+"&Mfn="+Mfn_Search+urlcopies
  				top.main.document.location.href=url
  			return
  		}

        if (Opcion=="cancelar") {
            if (browseby=="mfn"){
  		 		top.main.document.location.href="../dataentry/fmt.php?Opcion="+Opcion+"&base="+base+"&cipar="+cipar+"&Mfn="+mfn+"&ver=S"+FormatoActual+works+"&unlock=S"+urlcopies
  			}else{
  				url="../dataentry/fmt.php?Opcion=cancelar&base="+base+"&cipar="+cipar+"&from="+Search_pos+"&Mfn="+Mfn_Search+FormatoActual+urlcopies
  				url+="&unlock=S";
  				top.main.document.location.href=url
  			}
  			return
  		if (Opcion=="nuevo" || Opcion=="crear"){
			tipom=""
			if (typeofrecord!="" && Opcion=="nuevo"){
				TipoDeRegistro()
			    xeditar="S"
	 			top.main.document.location="../dataentry/fmt.php?Opcion=nuevo&base="+base+"&cipar="+cipar+"&Mfn=New&ver=N"+FormatoActual+"&tipom="+tipom+works+urlcopies
	 		}
  			return
  		}

  		if (Opcion=="actualizar"){
  			if (xeditar!="S"){
  				alert("<?php echo $msgstr["menu_edit"]?>")
    			return
  			}

  			xeditar=''
  			top.main.document.forma1.Opcion.value="actualizar"
  			top.main.document.forma1.submit()
  		}

 		if (Opcion=="buscar"){

  			top.buscar='S'
  			top.Search_pos=1
			top.main.document.location="../dataentry/buscar.php?Opcion=formab&prologo=prologoact&desde=dataentry&base="+base+"&cipar="+cipar+FormatoActual
  			return
  		}
  		if (Opcion=="cancelar")
     			ApagarEdicion()
     		else
     			PrenderEdicion()

	}

function Unload(){
	self.location.href="unload.php"
	alert("Fin de Sesi�n")
}

</script>

</head>

<frameset rows=88,45,* cols=* border=0>
<?php
if (isset($arrHttp["base"])){
    echo "<frame name=encabezado src=menubases.php?inicio=s&Opcion=Menu_o&base=$bd&cipar=$bd.par&Mfn=".$arrHttp["Mfn"]."&base_activa=$bd&per=$bdright MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no FRAMEBORDER=NO>\n";
	echo "<frame name=main  src=\"\" scrolling=yes frameborder=NO  marginheight=0   MARGINWIDTH=0 >";
	echo "<frame name=encabezado src=menubases.php?iOpcion=Menu_o&base=acces&cipar=cipar.par&Mfn=".$arrHttp["Mfn"]." MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no FRAMEBORDER=NO>\n";
	echo "<frame name=main src=\"homepage.htm\" scrolling=yes frameborder=no marginheight=2   MARGINWIDTH=0 >";
?>

</frameset>
</HTML>
