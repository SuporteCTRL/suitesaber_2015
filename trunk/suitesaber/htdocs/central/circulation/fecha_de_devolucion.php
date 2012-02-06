<?php
//Se calcula la fecha de devolución, tomando en cuenta los días feriados
function FechaDevolucion($lapso,$unidad,$fecha_inicio){
global $feriados,$locales,$notrabaja,$config_date_format;

	$f_date=explode("/",$config_date_format);
	switch ($unidad){
		case "H":
		//	$date=$timeStamp;
			$newdate = date("Ymd h:i A",strtotime("+$lapso hours"));
        	return $newdate;

			break;
		case "D":
            if ($fecha_inicio==""){
				$dev= date("Y-m-d",strtotime("+0 days"));
	        }else{	        	$dev= date("Y-m-d",strtotime($fecha_inicio."+0 days"));	        }
			break;
	}
    $d=0;
    $df=0;
    $diaFeriado="F";
    $dia_sem="F";
    $timeStamp=strtotime($dev);
    $total_days=-1;
    // se determinan los días feriados
    while ($d<$lapso){
    	$total_days++;
    	$fdev=date("Y-m-d",strtotime($dev."+$total_days days"));
    	$timeStamp=strtotime($fdev);
    	$f=explode('-',$fdev);
    	$mes=$f[1];
    	$dia=$f[2]-1;
    	if (isset($feriados[$mes*1]) and substr($feriados[$mes*1],$dia,1)=="F"){
    		$diaFeriado="F";
    		$df=$df+1;
    		$dia_sem="";
    	}else{
    		$diaFeriado="";
    		// se determina cuáles dias no trabaja la biblioteca
    		$dia_sem=date("w",$timeStamp);
    		if (!isset($locales[$dia_sem]["from"])) {
    			$df=$df+1;
    			$dia_sem="F";
    		}else{    			$d++;    		}
    	}
    }
    $lapso=$lapso+$df-1;
    $dev= date("Ymd h:i:s A",strtotime($dev."+$lapso days"));
	return $dev;

}
?>