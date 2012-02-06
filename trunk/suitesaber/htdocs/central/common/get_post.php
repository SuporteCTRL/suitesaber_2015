<?php
if (!isset($SESION["super_user"]))  $_SESSION["super_user"]="";
$arrHttp=array();
if (isset($_GET)){
	foreach ($_GET as $var => $value) {
		if (trim($value)!="") $arrHttp[$var]=$value;
		}
}
if (isset($_POST)){
	foreach ($_POST as $var => $value) {
		if (!empty($value)) $arrHttp[$var]=$value;
	}
}

?>