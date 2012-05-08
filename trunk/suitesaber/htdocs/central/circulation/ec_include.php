<?php
// se determina si el préstamo está vencido
function compareDate ($FechaP){
global $locales,$config_date_format;
//Se convierte la fecha a formato ISO (yyyymmaa) utilizando el formato de fecha local
	$f_date=explode('/',$config_date_format);
	switch ($f_date[0]){
		case "DD":
			$dia=substr($FechaP,0,2);
			break;
		case "MM":
			$mes=substr($FechaP,0,2);
			break;
	}
	switch ($f_date[1]){
		case "DD":
			$dia=substr($FechaP,3,2);
			break;
		case "MM":
			$mes=substr($FechaP,3,2);
			break;
	}
	$year=substr($FechaP,6,4);
	$exp_date=$year."-".$mes."-".$dia;
	$todays_date = date("Y-m-d");
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	return $diff;

}//end Compare Date

// se presenta la  información del usuario
	$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp.pft";
    if (!file_exists($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/loans_usdisp.pft";
   	$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		$ec_output.= $linea."\n";
	}
	$ec_output.="\n<script>nMultas=0;nSusp=0</script>\n" ;
	include("sanctions_read.php");
	$ec_output.=$sanctions_output;
//	foreach ($prestamo as $linea) echo "$linea<br>";
    $permitir_prestamo="S";
// se leen los prestamos pendientes
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
    if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
   	$query = "&Expresion=TRU_P_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	foreach ($contenido as $linea){
//		echo "$linea<br>";		$prestamos[]=$linea;
	}
	$nv=0;   //número de préstamos vencidos
	$np=0;   //Total libros en poder del usuario

	if (count($prestamos)>0) {
		$ec_output.= "<strong>".$msgstr["loans"]."</strong>
		<table width=100% bgcolor=#3A89AF>
		<td> </td>
		<th class=th_tit><h6>".$msgstr["inventory"]."</h6></th>
		<th class=th_tit><h6>Capa</h6></th>
		<th class=th_tit><h6>Status</h6></th>
		<th class=th_tit><h6>".$msgstr["control_n"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["signature"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["reference"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["typeofitems"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["loandate"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["devdate"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["overdue"]."</h6></th>
		<th class=th_tit><h6>".$msgstr["renewed"]."</h6></th>\n";

			foreach ($prestamos as $linea) {			if (trim($linea)!=""){
				$p=explode("^",$linea);

				$np++;
				$dif= compareDate ($p[5]);
				$fuente="";
				$mora="0";
				if ($dif<0) {
					$nv++;
					$mora=abs($dif/(60*60*24));    //cuenta de préstamos vencidos
				    $fuente="<font color=red>";
				}
	//		v800^c,'^',v800^q,'^',v800^n," Ej."v800^l,'^',v800^t,'^',v800^p,'^',v800^h,'^',v800^o,'^',f(mfn,1,0),/
				$ec_output.= "<tr><td  bgcolor=white valign=top>";
				$ec_output.="<input type=radio name=chkPr value=$mora  id=".$p[0].">";
				$ec_output.= "<input type=hidden name=politica value=".$politica[$p[3]][$p[6]]."> \n";
				$ec_output.="</td>

					<td bgcolor=white nowrap align=center valign=top>".$p[0]."</td>".
					"<td bgcolor=white nowrap align=center valign=top>".$p[14]."</td>".
					"<td bgcolor=white nowrap align=center valign=top>".$p[15]."</td>".
					"</td><td bgcolor=white nowrap align=center valign=top>".$p[12]."(".$p[13].")</td><td bgcolor=white nowrap align=center valign=top>".$p[1]."<td bgcolor=white valign=top>".$p[2]."</td><td bgcolor=white align=center valign=top>". $p[3]. "</td><td bgcolor=white nowrap align=center valign=top>".$p[4]."</td><td nowrap bgcolor=white align=center valign=top>$fuente".$p[5]."</td><td align=center bgcolor=white valign=top>".$mora."</td><td align=center bgcolor=white valign=top>". $p[11]."</td></tr>";
        	}
		}
		$ec_output.= "</table></dd>";
        $ec_output.= "<script>
		np=$np
		nv=$nv
		</script>\n";
	}

?>